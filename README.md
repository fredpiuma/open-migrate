# Open Migrate

Plugin WordPress livre para **exportar, importar e gerenciar backups** do site, **sem limite de tamanho**, sem telemetria e sem
conexões externas.

## Instalação

**[Baixar o plugin (zip do último release)](https://github.com/fredpiuma/open-migrate/releases/latest/download/open-migrate.zip)**

Esse zip tem só os arquivos do plugin. Não baixe o "Source code" do GitHub para instalar: ele traz também as ferramentas de desenvolvimento.

Pelo painel do WordPress: **Plugins → Adicionar novo → Enviar plugin**, envie o zip e ative o **Open Migrate**. O menu aparece na barra
lateral, com Exportar, Importar e Backups.

Pelo WP-CLI:

```bash
wp plugin install https://github.com/fredpiuma/open-migrate/releases/latest/download/open-migrate.zip --activate
```

Para atualizar para o release mais novo, rode o mesmo comando com `--force`.

Requer WordPress 5.8 ou superior e PHP 7.4 ou superior (64 bits para arquivos acima de 2 GB).

## Compatível com o All-in-One WP Migration

O Open Migrate é um fork do **All-in-One WP Migration and Backup 7.113**, da ServMask (GPLv3), e usa o mesmo formato `.wpress` e a mesma
pasta de backups (`wp-content/ai1wm-backups`). Você pode trocar de um plugin para o outro, nos dois sentidos, sem perder acesso aos
backups já feitos. As configurações de cada plugin ficam separadas.

## O que muda em relação ao original

- Sem limite de tamanho na importação: o arquivo é enviado em partes, no tamanho que o servidor aceita.
- Sem telemetria, feedback, atualizador de extensões pagas ou links para serviços externos.
- Só o que é importar, exportar e gerenciar backups. Telas de divulgação, vitrines de recursos pagos e o Reset Hub foram removidos.
- Pode ficar instalado ao lado do original: classes, funções, options e hooks têm prefixo próprio (`openmigrate_`).
- WP-CLI próprio: `wp openmigrate backup`, `export`, `list-backups`, `restore`, `import` e `delete`.

## Para quem quer contribuir

O código do plugin é o do original renomeado por script, mais um conjunto pequeno de mudanças manuais.

- Branch `upstream`: só recebe versões do original, importadas por `tools/sync-upstream.sh <versão>` (com tags `upstream/<versão>`).
  Nunca edite essa branch à mão.
- Branch `main`: o plugin. Versões novas do original entram com `git merge upstream`.
- `tools/upstream-map.json` lista as regras de renomeação, os literais protegidos e cada mudança manual em arquivo herdado
  (`local_changes`). Toda mudança manual em arquivo herdado precisa de uma entrada ali.
- `tools/build-zip.sh` gera o zip de instalação em `dist/`.

### Lançar uma versão

1. Atualize a versão em `open-migrate.php` (`Version:`), `constants.php` (`OPENMIGRATE_VERSION`) e `readme.txt` (`Stable tag`), e
   acrescente a entrada no topo do `CHANGELOG.md`.
2. No GitHub, crie um release com a tag `vX.Y.Z`. O workflow confere se a tag bate com as três versões, gera o zip e anexa
   `open-migrate.zip` e `open-migrate-X.Y.Z.zip` ao release.

## Créditos

Baseado no [All-in-One WP Migration and Backup](https://wordpress.org/plugins/all-in-one-wp-migration/), Copyright (C) ServMask Inc.
"All-in-One WP Migration" e "ServMask" são marcas dos respectivos titulares. O Open Migrate não é afiliado nem endossado por eles.
Mais detalhes em [CREDITS.md](CREDITS.md).

## Segurança

Para relatar uma vulnerabilidade, veja [SECURITY.md](SECURITY.md).

## Licença

GPLv3, a mesma do plugin original.

---

### Precisa de uma solução sob medida para a sua loja?

Desenvolvo plugins, integrações e melhorias para WordPress e WooCommerce, do checkout ao pós-venda. Me conte o que você precisa e vamos encontrar o melhor caminho para o seu projeto.

**Frederico de Castro** · Senior Web Developer & Software Architect

[![Fale comigo no WhatsApp](https://img.shields.io/badge/Fale_comigo_no_WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](https://wa.me/5511914636944)
[![E-mail](https://img.shields.io/badge/E--mail-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:contato@fredericodecastro.com.br)
[![Site](https://img.shields.io/badge/Site-1F2937?style=for-the-badge&logo=googlechrome&logoColor=white)](https://www.fredericodecastro.com.br/links/)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0A66C2?style=for-the-badge)](https://www.linkedin.com/in/fredericodecastro/)
[![Telegram](https://img.shields.io/badge/Telegram-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white)](https://t.me/fredericomdecastro)
