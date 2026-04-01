# Versão Para Aula

Esta pasta contém uma cópia do projeto preparada para codificação em aula.

## O que já está pronto

- Estrutura MVC
- Roteamento no `index.php`
- Conexão com banco
- Layout com Bootstrap
- Script SQL

## O que vamos codar em aula

- `models/Evento.php`
  - `listarTodos()`
  - `cadastrar()`
- `controllers/EventoController.php`
  - `listar()`
  - `salvar()`
  - `editar()`
- `views/eventos/lista.php`
  - colunas da tabela
- `views/eventos/formulario.php`
  - campos do formulário

## Ordem de implementação

1. Implementar `listarTodos()`
2. Implementar `listar()`
3. Completar a `lista.php`
4. Montar o `formulario.php`
5. Implementar `salvar()`
6. Implementar `editar()`

## Como usar

1. Importar `database/eventos.sql`
2. Abrir `http://localhost/crud-mvc-esqueleto/`
3. Completar os `TODO`s durante a aula
