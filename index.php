<?php
// Arquivo de entrada da aplicação.
// Toda requisição passa por aqui e depois é encaminhada para o controller.

require_once 'controllers/EventoController.php';
require_once 'controllers/AuthController.php';
require_once 'helpers/auth.php';

$controlador = new EventoController();
$controladorAuth = new AuthController();
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';

// Este switch funciona como um roteador simples: cada valor de "acao" chama um metodo do controller.
switch ($acao) {
    case 'login':
        $controladorAuth->mostrarLogin();
        break;

    case 'autenticar':
        $controladorAuth->autenticar();
        break;

    case 'logout':
        $controladorAuth->logout();
        break;

    case 'criar':
        $controlador->criar();
        break;

    case 'salvar':
        $controlador->salvar();
        break;

    case 'editar':
        $controlador->editar();
        break;

    case 'atualizar':
        $controlador->atualizar();
        break;

    case 'excluir':
        $controlador->excluir();
        break;

    default:
        $controlador->listar();
        break;
}
