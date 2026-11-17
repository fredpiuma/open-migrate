#!/usr/bin/env python3
"""Renomeação determinística do All-in-One WP Migration para o Open Migrate.

Uso: python3 -I tools/rebrand.py <origem> <destino> [--map docs/upstream-map.json]

Lê as regras de docs/upstream-map.json (rename, protected_literals), copia a árvore
<origem> para <destino> e aplica a renomeação. Mesma entrada, mesma saída.
"""
import argparse
import json
import os
import re
import shutil
import sys


def load_rules(map_path):
    with open(map_path, encoding="utf-8") as fh:
        data = json.load(fh)
    protected = []
    for item in data["protected_literals"]:
        pattern = item.get("regex") or re.escape(item["literal"])
        protected.append((item["literal"], re.compile(pattern)))
    return data, protected


def rename_path(rel, rules):
    parts = rel.split("/")
    name = parts[-1]
    for rule in rules["files"]:
        if "from" in rule and name == rule["from"]:
            name = rule["to"]
        elif "from_pattern" in rule and rule["from_pattern"] in name:
            name = name.replace(rule["from_pattern"], rule["to"])
    parts[-1] = name
    return "/".join(parts)


def transform(text, rules, protected):
    counts = {}
    store = []

    def mask(match):
        store.append(match.group(0))
        return "\x00%d\x00" % (len(store) - 1)

    for literal, regex in protected:
        before = len(regex.findall(text))
        counts[literal] = before
        text = regex.sub(mask, text)

    for token in rules["tokens"]:
        text = text.replace(token["from"], token["to"])

    text = re.sub(r"\x00(\d+)\x00", lambda m: store[int(m.group(1))], text)
    return text, counts


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("source")
    parser.add_argument("dest")
    parser.add_argument("--map", default=os.path.join(os.path.dirname(os.path.abspath(__file__)), "..", "docs", "upstream-map.json"))
    args = parser.parse_args()

    data, protected = load_rules(args.map)
    rules = data["rename"]
    extensions = tuple(rules["file_extensions"])

    if os.path.exists(args.dest) and os.listdir(args.dest):
        sys.exit("Destino não está vazio: %s" % args.dest)

    totals = {literal: [0, 0] for literal, _ in protected}
    files = []
    for root, dirs, names in os.walk(args.source):
        dirs.sort()
        for name in sorted(names):
            full = os.path.join(root, name)
            files.append(os.path.relpath(full, args.source).replace(os.sep, "/"))

    for rel in files:
        target = os.path.join(args.dest, rename_path(rel, rules))
        os.makedirs(os.path.dirname(target), exist_ok=True)
        src = os.path.join(args.source, rel)
        if rel.endswith(extensions):
            with open(src, "rb") as fh:
                raw = fh.read()
            try:
                text = raw.decode("utf-8")
            except UnicodeDecodeError:
                shutil.copyfile(src, target)
                continue
            new, counts = transform(text, rules, protected)
            for literal, regex in protected:
                totals[literal][0] += counts[literal]
                totals[literal][1] += len(regex.findall(new))
            with open(target, "wb") as fh:
                fh.write(new.encode("utf-8"))
        else:
            shutil.copyfile(src, target)
        shutil.copymode(src, target)

    broken = [lit for lit, (a, b) in totals.items() if a != b]
    if broken:
        sys.exit("Literais protegidos alterados: %s" % ", ".join(broken))
    for literal, (a, _) in totals.items():
        print("protegido %-20s %d ocorrência(s)" % (literal, a))
    print("ok: %d arquivos" % len(files))


if __name__ == "__main__":
    main()
