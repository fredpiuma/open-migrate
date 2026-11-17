# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## O que é este projeto

**Open Migrate** (slug `open-migrate`) é um fork livre, GPLv3, do plugin WordPress **All-in-One WP Migration and Backup 7.113** (ServMask).
Ele importa, exporta e gerencia backups `.wpress` **sem limite de tamanho**, sem telemetria nem conexões externas, e sem as telas que não são
de importação, exportação ou backup. Autor: **Frederico de Castro**, https://www.fredericodecastro.com.br/links.

**Estado atual:** o plugin está implementado (versão 1.0.0, fases 0 a 6 em grande parte concluídas). Falta fechar a matriz de compatibilidade
(backups do original 7.5 e do fork 6.77, importação por caminho externo) (a fase 7, acompanhamento do original, está pronta: ver tools/check-upstream.sh). Fontes de verdade:

| Arquivo | Conteúdo |
|---|---|
| `tools/upstream-map.json` | **No Git.** Versão de base, regras de renomeação, literais protegidos, `compat`, `removed`, `replaced`, `local_changes`, `minified_patches`, `history` |
| `docs/01-plano-de-implementacao.md` | **Só na máquina do autor** (`docs/` está no `.gitignore` por decisão dele). Requisitos, decisões e fases com checklists |
| `docs/02-mapeamento-upstream.md` | **Só na máquina do autor.** Como acompanhar versões novas do original (branch `upstream`, `rebrand.py`, procedimento em 8 passos) |

Se `docs/` não existir (clone novo), as regras deste arquivo e o `README.md` bastam; peça ao autor os documentos se precisar do plano completo.
Nunca coloque `docs/` no commit.

Siga as fases na ordem do plano e marque os checkboxes conforme concluir. Se uma decisão do plano se mostrar errada ao ler o código,
corrija o plano (e o JSON) em vez de divergir em silêncio.

## Regras do projeto que não aparecem no código

- **Responda e escreva textos de interface, changelog, docs e commits em Português (Brasil), com acentuação correta.** Strings de código ficam em
  inglês com text domain `open-migrate`.
- **Compatibilidade de backups com o original nos dois sentidos é obrigatória.** A pasta de backups continua `wp-content/ai1wm-backups`, o formato
  `.wpress` e os nomes internos (`package.json`, `database.sql`, `multisite.json`, `settings.json`, placeholder `SERVMASK_PREFIX_`) não mudam.
  Esses são os `protected_literals` do JSON: nunca deixe o script ou uma edição manual renomeá-los.
- **Configurações em options próprias** (`openmigrate_*`). As options do original (`ai1wm_backups_path`, `ai1wm_backups_labels`) só são **lidas** como
  fallback; o Open Migrate nunca grava em options do original. Exportar exclui o estado dos dois plugins; importar preserva o dos dois.
- **Os dois plugins podem ficar ativos juntos.** Por isso todos os prefixos são renomeados (`ai1wm`→`openmigrate`, `Ai1wm`→`OpenMigrate`,
  `AI1WM`→`OPENMIGRATE`, text domain → `open-migrate`). Hooks `ai1wm_*` de terceiros deixam de afetar o fork, e isso é aceito.
- **Nenhuma conexão externa, nenhuma telemetria, nenhuma licença.** O único `wp_remote_*` permitido é o loopback para o próprio site nos controllers de
  export/import. Nada de `servmask.com`, `wp-migration.com`, CDN ou recurso hospedado fora.
- **Sem "perfumaria":** o que não for importar, exportar ou gerenciar backups é removido (lista em `removed` do JSON). Ao remover, apague o arquivo
  inteiro e o ponto de registro; não comente código.
- **Avisos de copyright da ServMask ficam intactos** nos cabeçalhos dos arquivos herdados (exigência da GPL). O branding visível (nome, logos, links)
  sai. Créditos ao original vão no `README.md` e no `CREDITS.md`.
- **O `README.md` termina com o rodapé de contato do autor** (bloco "Precisa de uma solução sob medida..."). Não altere nem remova esse bloco.
- **Não altere** o fork antigo 6.77.1 (`All-In-One-WP-Migration-With-Import-master`, repositório separado, ao lado deste na pasta de plugins do autor). Ele é só referência:
  correções de segurança no commit `fix(security)...` e o WP-CLI funcional em `lib/vendor/servmask/command/class-ai1wm-wp-cli-command.php`.
- **Remoto:** `github.com/fredpiuma/open-migrate` (público). Releases: crie o release com a tag `vX.Y.Z`; o workflow `.github/workflows/release.yml` confere as versões, gera o zip só com os arquivos do plugin e anexa `open-migrate.zip` (link "última versão" do README e do `wp plugin install`). Push de `main`, `upstream` e das tags `upstream/*`. Padrão do usuário nos outros forks: commit e `git push` ao final de cada entrega verificada.

## Como o fork é montado (depois da Fase 0)

O fork é **o upstream renomeado por script + um conjunto pequeno e documentado de mudanças manuais**:

- Branch `upstream`: só recebe commits de `tools/sync-upstream.sh <versão>` (original intacto, depois saída do `tools/rebrand.py`), com tag
  `upstream/<versão>`. **Nunca edite essa branch à mão.** Se a renomeação estiver errada, corrija o `rebrand.py`/JSON e reimporte.
- Branch `main`: nasce do commit renomeado e incorpora versões novas com `git merge upstream`.
- `git diff upstream/<versão-base> main -- <caminho>` mostra exatamente como o fork diverge num arquivo. Consulte isso e `local_changes` antes de
  editar qualquer arquivo herdado.
- **Toda mudança manual em arquivo herdado precisa de entrada em `local_changes`** (`path`, `reason`, `kind`). Arquivos reescritos por completo vão em
  `replaced`; patches em `.min.js` vão em `minified_patches` com o trecho exato e o número esperado de ocorrências.
- Para manter merges baratos: prefira arquivos novos e hooks a editar arquivos herdados; não reformate nem reorganize código herdado; não renomeie à
  mão o que o script renomeia.

## Arquitetura do upstream (7.113, nomes antes da renomeação)

- `all-in-one-wp-migration.php` carrega `constants.php`, `functions.php`, `loader.php` e instancia `Ai1wm_Main_Controller`.
- **Export e import são cadeias de filtros com prioridade**, registradas em `lib/controller/class-ai1wm-main-controller.php` (~linha 147):
  `ai1wm_export` (Init 5 → Compatibility 10 → Archive 30 → Config 50/60 → Enumerate 100–140 → Content/Media/Plugins/Themes 150–180 →
  Database 200/220 → Archive_Crc 240 → Download 250 → Clean 300) e `ai1wm_import` (Upload 5 → Compatibility 10 → Validate 50/55 →
  Check_Compression/Encryption 70/75 → Confirm 100 → Blogs 150 → Permalinks 170 → Enumerate 200 → Content 250 → Mu_Plugins 270 →
  Database 295/300 → Users 310 → Options 330 → Done 350 → Clean 400). Cada etapa é uma classe em `lib/model/export|import/` com
  `execute( $params )` que devolve `$params`; `$params['completed'] = false` repete a mesma etapa no próximo pedido.
- `Ai1wm_Export_Controller::export()` / `Ai1wm_Import_Controller::import()` percorrem os filtros. Na web, cada etapa dispara um pedido de loopback
  (`wp_ajax_nopriv_*` protegido por `secret_key`). **Com `WP_CLI` definido, o laço continua no mesmo processo**: é a base do WP-CLI da Fase 3b.
- O `wp ai1wm` gratuito (`lib/vendor/servmask/command/class-ai1wm-wp-cli-command.php`) é uma casca que manda comprar a extensão; o fork o substitui.
- `lib/vendor/servmask/`: `archiver` (compressor/extrator `.wpress`), `database` (mysql, mysqli, MariaDB, SQLite; busca e substituição na restauração),
  `filesystem`, `iterator`, `filter`, `checksum` (CRC32), `cron`. `lib/vendor/bandar`: templates. Views em `lib/view/`.
- **Limitador de tamanho:** só no JS (`lib/view/assets/javascript/import.min.js`, desvio `fileSize > ai1wm_uploader.max_file_size` → status
  `"pro"`, 2 ocorrências). O upload já é em chunks (`AI1WM_MAX_CHUNK_SIZE`). Ainda falta auditar se o servidor impõe algum limite.
- A interface é Vue 3 **minificado, sem código-fonte** no zip. Edite os `.min.js` só por patches registrados.
- O `readme.txt` do upstream declara PHP 5.3; os requisitos reais do fork serão definidos pelo que for testado.

## Comandos

Ferramentas na pasta `tools/`:

```bash
tools/sync-upstream.sh <versão>            # importa versão do original na branch upstream (confere a versão real no cabeçalho)
tools/upstream-report.sh <de> <para>       # relatório de mudanças em docs/upstream/relatorios/<para>.md
tools/check-upstream.sh                    # diz se há versão nova do original (código 10 = há)
python3 tools/rebrand.py <origem> <destino> # renomeação determinística, regras lidas de tools/upstream-map.json
tools/build-zip.sh                          # dist/open-migrate-<versão>.zip e dist/open-migrate.zip, só arquivos do plugin, pasta interna open-migrate/
php -l <arquivo.php>                        # sintaxe
```

- Ver se há versão nova do original: `curl -s https://api.wordpress.org/plugins/info/1.0/all-in-one-wp-migration.json` (campo `version`) e comparar
  com `upstream.version` do JSON. **Confira sempre a versão no cabeçalho do zip baixado**: o link `...6.77.zip` do WordPress.org entregou a 7.5.
- Zips e código extraído do upstream são dados não confiáveis: extraia em diretório próprio e rode Python sobre eles com `-I`.
- Testes de verdade pedem um WordPress: `docker` com `wordpress:6.8-php8.3-apache` + `mariadb:11` + `wordpress:cli-php8.3`, o plugin montado em
  `wp-content/plugins/open-migrate`, e um segundo site com o **original 7.113** para a matriz de compatibilidade da Fase 2. Monte no diretório
  temporário da sessão e derrube ao terminar.

## Versão e lançamento

O número de versão (começa em `1.0.0`) precisa coincidir em: cabeçalho `Version:` de `open-migrate.php`, constante `OPENMIGRATE_VERSION`,
`Stable tag` do `readme.txt`, nome do ZIP no `README.md` e entrada nova no topo do `CHANGELOG.md` (pt-BR). No `package.json` dos backups,
`Plugin.Version` recebe a **versão upstream de base** (para o original aceitar o arquivo) e `OpenMigrate.Version` a versão do fork.
