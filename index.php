<?php
// Arquivo de entrada da aplicação.
// Toda requisição passa por aqui e depois é encaminhada para o controller.

require_once 'controllers/EventoController.php';

$controlador = new EventoController();
$acao = isset($_GET['acao']) ? $_GET['acao'] : 'listar';

switch ($acao) {
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
