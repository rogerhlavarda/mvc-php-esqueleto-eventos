<?php
require_once 'models/Evento.php';
require_once 'helpers/auth.php';

class EventoController
{
    private $modeloEvento;

    public function __construct()
    {
        $this->modeloEvento = new Evento();
    }

    public function listar()
    {
        // O controller pede ao model a lista completa de eventos para repassar esses dados para a view.
        $eventos = $this->modeloEvento->listarTodos();

        $mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : '';
        $tipoMensagem = isset($_GET['tipo']) ? $_GET['tipo'] : 'success';

        // A view usa as variaveis acima para montar a tabela e exibir mensagens ao usuario.
        require 'views/eventos/lista.php';
    }

    public function criar()
    {
        exigirAutenticacao();

        // Esse array vazio permite reutilizar a mesma view tanto no cadastro quanto na edicao sem gerar indices indefinidos.
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
        exigirAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Este array organiza os dados do formulario em um formato previsivel para o model.
            // Os nomes das chaves acompanham os nomes das colunas da tabela e dos campos do form.
            $dados = [
                'nome' => $_POST['nome'],
                'cidade' => $_POST['cidade'],
                'data_evento' => $_POST['data_evento'],
                'distancia' => $_POST['distancia'],
                'status_evento' => $_POST['status_evento'],
                'observacoes' => $_POST['observacoes']
            ];

            // O model executa o INSERT no banco e devolve true ou false para indicar o resultado.
            $sucesso = $this->modeloEvento->cadastrar($dados);

            // Depois do POST, o redirecionamento evita reenvio do formulario ao atualizar a pagina.
            if ($sucesso) {
                header('Location: index.php?mensagem=Evento cadastrado com sucesso.&tipo=success');
            } else {
                header('Location: index.php?mensagem=Erro ao cadastrar o evento.&tipo=danger');
            }
            exit;
        }
    }

    public function editar()
    {
        exigirAutenticacao();

        if (!isset($_GET['id'])) {
            header('Location: index.php?mensagem=ID do evento não informado.&tipo=warning');
            exit;
        }

        $id = (int) $_GET['id'];
        // O id vindo da URL identifica qual registro deve ser carregado para preencher o formulario.
        $evento = $this->modeloEvento->buscarPorId($id);
        // Se o registro nao existir, o fluxo volta para a listagem para evitar tela de edicao inconsistente.
        if (!$evento) {
            header('Location: index.php?mensagem=Evento não encontrado.&tipo=warning');
            exit;
        }

        $acaoFormulario = 'atualizar';
        $tituloPagina = 'Editar evento';

        // A tela de cadastro e edicao e a mesma; o que muda sao os dados enviados para a view.
        require 'views/eventos/formulario.php';
    }

    public function atualizar()
    {
        exigirAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // A atualizacao reaproveita a estrutura do cadastro, mas inclui o id para localizar o registro.
            $dados = [
                'id' => $_POST['id'],
                'nome' => $_POST['nome'],
                'cidade' => $_POST['cidade'],
                'data_evento' => $_POST['data_evento'],
                'distancia' => $_POST['distancia'],
                'status_evento' => $_POST['status_evento'],
                'observacoes' => $_POST['observacoes']
            ];

            $sucesso = $this->modeloEvento->atualizar($dados);

            if ($sucesso) {
                header('Location: index.php?mensagem=Evento atualizado com sucesso.&tipo=success');
            } else {
                header('Location: index.php?mensagem=Erro ao atualizar o evento.&tipo=danger');
            }

            exit;
        }
    }

    public function excluir()
    {
        exigirAutenticacao();

        if (!isset($_GET['id'])) {
            header('Location: index.php?mensagem=ID do evento não informado.&tipo=warning');
            exit;
        }

        // A exclusao usa apenas o id, pois ele identifica de forma unica o evento a ser removido.
        $id = (int) $_GET['id'];
        $sucesso = $this->modeloEvento->excluir($id);

        if ($sucesso) {
            header('Location: index.php?mensagem=Evento removido com sucesso.&tipo=success');
        } else {
            header('Location: index.php?mensagem=Erro ao remover o evento.&tipo=danger');
        }
        
        exit;
    }
}
