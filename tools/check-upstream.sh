#!/usr/bin/env bash
# Compara a versão de base (tools/upstream-map.json) com a mais recente do original no WordPress.org.
# Saída: "em dia" (código 0) ou "nova versão: X" (código 10), para uso manual ou agendado.
set -euo pipefail
cd "$(dirname "$0")/.."

base=$(python3 -I -c "import json;print(json.load(open('tools/upstream-map.json'))['upstream']['version'])")
api=$(python3 -I -c "import json;print(json.load(open('tools/upstream-map.json'))['upstream']['info_api'])")
atual=$(curl -fsS "$api" | python3 -I -c "import sys,json;print(json.load(sys.stdin)['version'])")

if [ "$atual" = "$base" ]; then
	echo "em dia: base $base é a mais recente do original"
	exit 0
fi
echo "nova versão: $atual (base atual $base)"
echo "próximo passo: tools/sync-upstream.sh $atual && tools/upstream-report.sh $base $atual && git merge upstream"
exit 10
