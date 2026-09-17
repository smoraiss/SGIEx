# SGIEx

Versão simples do SGIEx: PHP + MySQL/MariaDB + MVC enxuto.

## Instalação
1. Crie o banco executando `database/schema.sql`.
2. Altere a senha do usuário `sgiex_app` no SQL e no ambiente.
3. Configure `SGIEX_DB_HOST`, `SGIEX_DB_NAME`, `SGIEX_DB_USER` e `SGIEX_DB_PASS` ou edite `config/config.php`.
4. Coloque a pasta no XAMPP/htdocs.
5. Crie o primeiro administrador inserindo um hash produzido por `password_hash()` ou usando um pequeno script PHP local. Não há senha padrão no repositório.

A única entrada HTTP é `index.php`; consultas ao banco usam prepared statements.
