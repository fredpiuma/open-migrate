#!/usr/bin/env bash
# Gera dist/open-migrate-<versão>.zip e dist/open-migrate.zip (mesmo conteúdo, nome fixo para o link "última versão").
# Só entra o que o WordPress precisa para rodar o plugin, a partir dos arquivos rastreados no HEAD, dentro da pasta open-migrate/.
# Ficam de fora: tools/, .github/, README.md, CHANGELOG.md, CREDITS.md, SECURITY.md, CLAUDE.md e qualquer outro arquivo de desenvolvimento.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"
VERSION="$(sed -n 's/^ \* Version: *//p' open-migrate.php | head -1 | tr -d '\r ')"
[ -n "$VERSION" ] || { echo "Versão não encontrada em open-migrate.php" >&2; exit 1; }

INCLUDE=()
for p in open-migrate.php constants.php functions.php loader.php deprecated.php exceptions.php uninstall.php readme.txt LICENSE lib languages; do
	if git cat-file -e "HEAD:$p" 2>/dev/null; then
		INCLUDE+=("$p")
	fi
done

mkdir -p dist
OUT="dist/open-migrate-$VERSION.zip"
rm -f "$OUT" dist/open-migrate.zip
git archive --format=zip --prefix=open-migrate/ -o "$OUT" HEAD -- "${INCLUDE[@]}"
cp "$OUT" dist/open-migrate.zip
echo "$OUT"
echo "dist/open-migrate.zip"
