# Política de segurança

## Versões com suporte

Recebe correções de segurança a última versão publicada do Open Migrate (1.x).

## Como relatar uma vulnerabilidade

Não abra uma issue pública. Fale com o autor, Frederico de Castro, por um dos canais em
https://www.fredericodecastro.com.br/links, com o passo a passo para reproduzir, a versão do plugin e a do WordPress.

## O que o plugin faz para se proteger

- **Nenhuma conexão externa, telemetria ou licença.** A única requisição HTTP é o loopback para o próprio site nos controllers de exportação e importação.
- **Chave secreta.** Os endpoints de exportação, importação e status exigem `secret_key` válida, e a tela só a entrega a quem tem a capacidade correspondente. Sem chave ou com chave errada, o pedido é encerrado sem executar nada.
- **Capacidades.** As telas e ações do painel exigem `openmigrate_export_site`, `openmigrate_import_site` e `openmigrate_manage_backups`.
- **Nomes de arquivo e de pasta.** Caracteres inválidos e `../` são recusados, o `basename()` é aplicado e só é aceita a extensão `.wpress`.
- **Envio em partes.** O cabeçalho do `.wpress` é validado na primeira parte, e cada parte só pode começar dentro ou logo depois do que já foi recebido. Um `chunk_offset` abusivo não cria arquivo esparso nem enche o disco.
- **Arquivos PHP** terminam a execução se carregados direto, fora do WordPress.
- **REST API desligada por padrão.** Só é registrada se `OPENMIGRATE_REST_ENABLED` for definida.

## Pontos de atenção conhecidos

- **Os backups ficam em `wp-content/ai1wm-backups`**, pasta herdada do original para manter a compatibilidade. O `.htaccess` dela só desliga a listagem de pastas. Quem souber o nome exato do arquivo pode baixá-lo, e o nome tem um sufixo aleatório de 12 caracteres. Um backup contém o banco de dados inteiro, então bloqueie o acesso direto a `*.wpress` no servidor web (Nginx ou regra do Apache) e não publique os nomes dos arquivos.
- **Logs de erro** em `wp-content/plugins/open-migrate/storage/` podem mostrar caminhos do servidor. A pasta não tem listagem, mas os arquivos são acessíveis se o nome for conhecido. Bloqueie o acesso a ela no servidor se isso for um problema.
- **Importar substitui o banco**, inclusive a tabela de usuários e as senhas, pelos dados do backup. Restaure apenas arquivos de origem confiável.
- **Convivência com o original.** Os dois plugins podem ficar ativos, mas as restaurações feitas pelo original sobre um backup do Open Migrate desativam o Open Migrate, porque o plugin retira a si mesmo da lista de plugins ativos gravada no backup.
