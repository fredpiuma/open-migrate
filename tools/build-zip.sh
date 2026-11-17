#!/usr/bin/env bash
# Gera dist/open-migrate-<versão>.zip só com arquivos rastreados, pasta interna open-migrate/.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
VERSION="$(sed -n 's/^ \* Version: *//p' open-migrate.php | head -1 | tr -d '\r ')"
[ -n "$VERSION" ] || { echo "Versão não encontrada em open-migrate.php" >&2; exit 1; }
mkdir -p dist
OUT="dist/open-migrate-$VERSION.zip"
rm -f "$OUT"
git archive --format=zip --prefix=open-migrate/ -o "$OUT" HEAD -- \
	open-migrate.php constants.php functions.php loader.php deprecated.php exceptions.php uninstall.php \
	readme.txt LICENSE CREDITS.md lib languages 2>/dev/null || \
git archive --format=zip --prefix=open-migrate/ -o "$OUT" HEAD -- \
	open-migrate.php constants.php functions.php loader.php deprecated.php exceptions.php uninstall.php \
	readme.txt LICENSE CREDITS.md lib
echo "$OUT"
