# LogiControl – Gerenciador Logístico

Projeto acadêmico desenvolvido em PHP, MySQL, HTML, CSS, Bootstrap e JavaScript.

## Requisitos
- XAMPP com Apache e MySQL
- Navegador atualizado
- VS Code (opcional, recomendado)

## Instalação
1. Copie a pasta `LogiControl` para `C:\xampp\htdocs`.
2. Abra o XAMPP Control Panel e inicie Apache e MySQL.
3. Acesse `http://localhost/phpmyadmin`.
4. Clique em **Importar**, selecione `database/logistica.sql` e execute.
5. Confira os dados de conexão em `config/conexao.php` (padrão XAMPP: usuário `root`, senha vazia).
6. Acesse `http://localhost/LogiControl/`.

## Funcionalidades
- Painel com indicadores
- CRUD de produtos, endereços e transportadores
- Cadastro de frete com múltiplos produtos
- Relatório de fretes por período com exportação CSV

## Relacionamentos
- Um transportador pode estar associado a vários fretes.
- Um frete possui origem, destino e um transportador.
- Um frete pode conter vários produtos; a tabela `frete_produtos` registra os produtos e suas quantidades.

## Observações
- O Bootstrap é carregado por CDN, portanto a interface precisa de internet para carregar o visual do Bootstrap.
- Este projeto é uma base acadêmica. Antes de uso real, adicione autenticação, proteção CSRF, validações adicionais e controle de estoque.
