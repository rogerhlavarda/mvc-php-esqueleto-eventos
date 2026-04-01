<?php
require_once 'models/Evento.php';

class EventoController
{
    private $modeloEvento;

    public function __construct()
    {
        $this->modeloEvento = new Evento();
    }

    public function listar()
    {
        // TODO: buscar todos os eventos no model.
        // Dica: use o método listarTodos().

        $mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : '';
        $tipoMensagem = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';

        // TODO: carregar a view de listagem.
    }

    public function criar()
    {
        $evento = [
            'id' => '',
            'nome' => '',
            'cidade' => '',
            'data_evento' => '',
            'distancia' => '',
            'status_evento' => '',
            'observacoes' => ''
        ];
        $acaoFormulario = 'salvar';
        $tituloPagina = 'Cadastrar evento';

        require 'views/eventos/formulario.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: montar o array $dados com os campos recebidos do formulário.
            // Campos esperados:
            // nome, cidade, data_evento, distancia, status_evento, observacoes

            // TODO: chamar o model para cadastrar o evento.

            // TODO: redirecionar para a listagem com mensagem de sucesso ou erro.
            exit;
        }
    }

    public function editar()
    {
        if (!isset($_GET['id'])) {
            header('Location: index.php?mensagem=ID do evento não informado.&tipo=warning');
            exit;
        }

        // TODO: converter o id para inteiro.
        // TODO: buscar o evento pelo id usando o model.
        // TODO: se não encontrar, redirecionar com mensagem.

        $acaoFormulario = 'atualizar';
        $tituloPagina = 'Editar evento';

        // TODO: carregar a mesma view do formulário.
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO opcional:
            // implementar a atualização do evento reaproveitando a lógica do cadastro.
            exit;
        }
    }

    public function excluir()
    {
        if (!isset($_GET['id'])) {
            header('Location: index.php?mensagem=ID do evento não informado.&tipo=warning');
            exit;
        }

        // TODO opcional:
        // implementar a exclusão por id.
    }
}
