#!/usr/bin/env bash
# Importa uma versão do All-in-One WP Migration na branch `upstream` (2 commits + tag).
# Uso: tools/sync-upstream.sh <versão> [--verify]
#   --verify: não grava nada; recalcula a árvore renomeada e compara com a tag upstream/<versão>.
set -euo pipefail

VERSION="${1:?Uso: tools/sync-upstream.sh <versão> [--verify]}"
MODE="${2:-sync}"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
MAP="$ROOT/docs/upstream-map.json"
SRC_DIR="$ROOT/upstream-src"
ZIP="$SRC_DIR/all-in-one-wp-migration.$VERSION.zip"
SLUG="all-in-one-wp-migration"
WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

mkdir -p "$SRC_DIR"
if [ ! -f "$ZIP" ]; then
	echo "Baixando $VERSION..."
	curl -fsSL -o "$ZIP" "https://downloads.wordpress.org/plugin/$SLUG.$VERSION.zip"
fi

mkdir -p "$WORK/orig"
unzip -q "$ZIP" -d "$WORK/orig"
SRC="$WORK/orig/$SLUG"
[ -d "$SRC" ] || { echo "Zip sem a pasta $SLUG/" >&2; exit 1; }

REAL="$(sed -n 's/^ \* Version: *//p' "$SRC/$SLUG.php" | head -1 | tr -d '\r ')"
if [ "$REAL" != "$VERSION" ]; then
	echo "ABORTADO: o zip pedido é $VERSION, mas o cabeçalho diz $REAL." >&2
	exit 1
fi

python3 -I "$ROOT/tools/rebrand.py" "$SRC" "$WORK/brand" --map "$MAP" >/dev/null

# Data fixa para o commit ser reproduzível.
DATE="$(python3 -I - "$MAP" "$VERSION" <<'PY'
import json, sys
d = json.load(open(sys.argv[1], encoding="utf-8"))["upstream"]
print((d["released_at"] if d["version"] == sys.argv[2] and d.get("released_at") else "2026-01-01") + "T00:00:00+0000")
PY
)"
export GIT_AUTHOR_NAME="Open Migrate" GIT_AUTHOR_EMAIL="noreply@open-migrate.invalid"
export GIT_COMMITTER_NAME="$GIT_AUTHOR_NAME" GIT_COMMITTER_EMAIL="$GIT_AUTHOR_EMAIL"
export GIT_AUTHOR_DATE="$DATE" GIT_COMMITTER_DATE="$DATE"

cd "$ROOT"
tree_of() { # $1 = diretório
	GIT_INDEX_FILE="$WORK/index" git --work-tree="$1" add -A -f >/dev/null
	GIT_INDEX_FILE="$WORK/index" git write-tree
	rm -f "$WORK/index"
}

TREE_ORIG="$(tree_of "$WORK/orig/$SLUG")"
TREE_BRAND="$(tree_of "$WORK/brand")"

if [ "$MODE" = "--verify" ]; then
	TAGGED="$(git rev-parse "upstream/$VERSION^{tree}")"
	if [ "$TAGGED" = "$TREE_BRAND" ]; then echo "ok: upstream/$VERSION idêntico ($TREE_BRAND)"; exit 0; fi
	echo "DIVERGE: tag $TAGGED, recalculado $TREE_BRAND" >&2; exit 1
fi

if git rev-parse -q --verify "refs/tags/upstream/$VERSION" >/dev/null; then
	echo "A tag upstream/$VERSION já existe. Use --verify." >&2; exit 1
fi

PARENT=()
if git rev-parse -q --verify refs/heads/upstream >/dev/null; then PARENT=(-p "$(git rev-parse refs/heads/upstream)"); fi
C1="$(git commit-tree "$TREE_ORIG" "${PARENT[@]}" -m "Importação do original $VERSION")"
C2="$(git commit-tree "$TREE_BRAND" -p "$C1" -m "Rebranding mecânico $VERSION")"
git update-ref refs/heads/upstream "$C2"
git tag "upstream/$VERSION" "$C2"
git tag "upstream-original/$VERSION" "$C1"
echo "upstream: $C2 (tag upstream/$VERSION, original em upstream-original/$VERSION)"
