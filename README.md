# Open Migrate

Plugin WordPress livre para **exportar, importar e gerenciar backups** do site, **sem limite de tamanho**, sem telemetria e sem
conexões externas.

> **Status:** em desenvolvimento. O plano de implementação está em [docs/01-plano-de-implementacao.md](docs/01-plano-de-implementacao.md).

## Compatível com o All-in-One WP Migration

O Open Migrate é um fork do **All-in-One WP Migration and Backup 7.113**, da ServMask (GPLv3), e usa o mesmo formato `.wpress` e a mesma
pasta de backups (`wp-content/ai1wm-backups`). Você pode trocar de um plugin para o outro, nos dois sentidos, sem perder acesso aos
backups já feitos. As configurações de cada plugin ficam separadas.

## O que muda em relação ao original

- Sem limite de tamanho na importação.
- Sem telemetria, feedback, atualizador de extensões pagas ou links para serviços externos.
- Só o que é importar, exportar e gerenciar backups. Telas de divulgação, vitrines de recursos pagos e o Reset Hub foram removidos.
- Pode ficar instalado ao lado do original: classes, funções, options e hooks têm prefixo próprio (`openmigrate_`).

O acompanhamento das versões novas do original está descrito em [docs/02-mapeamento-upstream.md](docs/02-mapeamento-upstream.md).

## Créditos

Baseado no [All-in-One WP Migration and Backup](https://wordpress.org/plugins/all-in-one-wp-migration/), Copyright (C) ServMask Inc.
"All-in-One WP Migration" e "ServMask" são marcas dos respectivos titulares. O Open Migrate não é afiliado nem endossado por eles.

## Licença

GPLv3, a mesma do plugin original.

## Instalação

1. Baixe `open-migrate-1.0.0.zip`.
2. No painel do WordPress, vá em **Plugins → Adicionar novo → Enviar plugin** e envie o arquivo (ou descompacte em `wp-content/plugins/`).
3. Ative o **Open Migrate**. O menu aparece na barra lateral, com Exportar, Importar e Backups.

Requer WordPress 5.8 ou superior e PHP 7.4 ou superior (64 bits para arquivos acima de 2 GB).

---

### Precisa de uma solução sob medida para a sua loja?

Desenvolvo plugins, integrações e melhorias para WordPress e WooCommerce, do checkout ao pós-venda. Me conte o que você precisa e vamos encontrar o melhor caminho para o seu projeto.

**Frederico de Castro** · Senior Web Developer & Software Architect

[![Fale comigo no WhatsApp](https://img.shields.io/badge/Fale_comigo_no_WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white)](https://wa.me/5511914636944)
[![E-mail](https://img.shields.io/badge/E--mail-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:contato@fredericodecastro.com.br)
[![Site](https://img.shields.io/badge/Site-1F2937?style=for-the-badge&logo=googlechrome&logoColor=white)](https://www.fredericodecastro.com.br/links/)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0A66C2?style=for-the-badge)](https://www.linkedin.com/in/fredericodecastro/)
[![Telegram](https://img.shields.io/badge/Telegram-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white)](https://t.me/fredericomdecastro)
