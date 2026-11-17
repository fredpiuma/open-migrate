#!/usr/bin/env bash
# Gera docs/upstream/relatorios/<para>.md com o que mudou entre duas versões do original.
# Uso: tools/upstream-report.sh <de> <para>
set -euo pipefail
FROM="${1:?Uso: tools/upstream-report.sh <de> <para>}"
TO="${2:?}"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
OUT="docs/upstream/relatorios/$TO.md"
mkdir -p "$(dirname "$OUT")"

python3 -I - "$FROM" "$TO" "$OUT" <<'PY'
import fnmatch, json, subprocess, sys
frm, to, out = sys.argv[1:4]
m = json.load(open("docs/upstream-map.json", encoding="utf-8"))
git = lambda *a: subprocess.run(["git", *a], capture_output=True, text=True, check=True).stdout
files = git("diff", "--name-status", "upstream/%s" % frm, "upstream/%s" % to).splitlines()

def removed(path):
    for r in m["removed"]:
        if "path" in r and (path == r["path"] or (r["path"].endswith("/") and path.startswith(r["path"]))):
            return True
        if "path_glob" in r:
            import re
            g = re.sub(r"\{([^}]*)\}", lambda x: "(" + "|".join(x.group(1).split(",")) + ")", fnmatch.translate(r["path_glob"]).replace(r"\{", "{").replace(r"\}", "}"))
            if re.match(g, path) and path not in r.get("except", []):
                return True
    return False
replaced = {r["path"] for r in m["replaced"]}
local = {r["path"] for r in m["local_changes"]} | {r["path"] for r in m["minified_patches"]}

lines = ["# Relatório do upstream %s → %s" % (frm, to), "",
         "## Changelog do `readme.txt` (%s)" % to, ""]
try:
    readme = git("show", "upstream/%s:readme.txt" % to)
    sect = readme.split("== Changelog ==", 1)[1].split("\n== ", 1)[0] if "== Changelog ==" in readme else ""
    lines += ["```", sect.strip()[:6000], "```", ""]
except subprocess.CalledProcessError:
    lines += ["(readme.txt indisponível)", ""]
lines += ["## Arquivos", "", "| Status | Arquivo | Classificação |", "|---|---|---|"]
for row in files:
    st, path = row.split("\t")[0], row.split("\t")[-1]
    if path in replaced: c = "substituído no fork: manter a versão do fork, usar o diff como referência"
    elif removed(path): c = "removido no fork: ler o diff (pode conter correção de segurança)"
    elif path in local: c = "patch local: conferir `local_changes`/`minified_patches`"
    elif st.startswith("A"): c = "novo: decidir se entra ou vai para `removed`"
    else: c = "aplicar"
    lines.append("| %s | `%s` | %s |" % (st, path, c))
lines += ["", "## Estatística", "", "```", git("diff", "--stat", "upstream/%s" % frm, "upstream/%s" % to).strip(), "```", ""]
open(out, "w", encoding="utf-8").write("\n".join(lines))
print(out)
PY
