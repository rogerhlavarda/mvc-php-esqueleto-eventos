# Sessões em PHP no Projeto

Este projeto já possui um CRUD de eventos em MVC simples. A ideia é usar essa base para introduzir sessões em um sistema real, sem adicionar complexidade desnecessária.

## Estrutura atual do projeto

- `index.php`
  - ponto de entrada e roteador simples por `acao`
- `controllers/EventoController.php`
  - fluxo do CRUD de eventos
- `models/Evento.php`
  - acesso ao banco com PDO
- `views/eventos/*.php`
  - listagem e formulário
- `views/layout/*.php`
  - cabeçalho e rodapé compartilhados

## Onde sessões fazem sentido aqui

- no login, para manter o usuário autenticado entre páginas
- na proteção das ações de cadastro, edição, atualização e exclusão
- na exibição condicional de botões e informações do usuário no layout
- no logout, para encerrar a autenticação

## O que já foi preparado

- rotas novas de autenticação em `index.php`
- `controllers/AuthController.php`
- `helpers/auth.php`
- `views/auth/login.php`
- proteção estrutural das ações restritas com `exigirAutenticacao()`
- navegação com links de login/logout
- implementação completa da autenticação com sessão

## O que a autenticação faz no projeto

- inicia a sessão com `session_start()`
- grava o usuário autenticado em `$_SESSION`
- lê a sessão para identificar o usuário logado
- protege as ações de cadastro, edição, atualização e exclusão
- valida formulários com token CSRF
- destrói a sessão no logout

## Credenciais de demonstração

- E-mail: `usuario@exemplo.com`
- Senha: `123456`

## Como usar

1. Importar `database/eventos.sql`
2. Abrir `http://localhost/mvc-php-esqueleto-eventos/`
3. Fazer login com as credenciais de demonstração
