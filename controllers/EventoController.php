<?php
require_once 'models/Evento.php';
require_once 'helpers/auth.php';

class EventoController
{
    private $modeloEvento;
    private $distanciasPermitidas = ['5 km', '10 km', '15 km', '21 km', '42 km'];
    private $statusPermitidos = ['Planejado', 'Inscrito', 'Concluído'];

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
            exigirTokenCsrf($_POST['csrf_token'] ?? '');

            // Este array organiza os dados do formulario em um formato previsivel para o model.
            // Os nomes das chaves acompanham os nomes das colunas da tabela e dos campos do form.
            $dados = $this->normalizarDadosEvento($_POST);

            $erros = $this->validarDadosEvento($dados);
            if (!empty($erros)) {
                header('Location: index.php?acao=criar&mensagem=' . urlencode($erros[0]) . '&tipo=warning');
                exit;
            }

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
            exigirTokenCsrf($_POST['csrf_token'] ?? '');

            // A atualizacao reaproveita a estrutura do cadastro, mas inclui o id para localizar o registro.
            $dados = $this->normalizarDadosEvento($_POST);
            $dados['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $erros = $this->validarDadosEvento($dados, true);
            if (!empty($erros)) {
                $idRedirecionamento = isset($_POST['id']) ? (int) $_POST['id'] : 0;
                header('Location: index.php?acao=editar&id=' . $idRedirecionamento . '&mensagem=' . urlencode($erros[0]) . '&tipo=warning');
                exit;
            }

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

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?mensagem=A exclusão deve ser enviada por formulário seguro.&tipo=warning');
            exit;
        }

        exigirTokenCsrf($_POST['csrf_token'] ?? '');

        // A exclusao usa apenas o id, pois ele identifica de forma unica o evento a ser removido.
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?mensagem=ID do evento não informado ou inválido.&tipo=warning');
            exit;
        }

        $sucesso = $this->modeloEvento->excluir($id);

        if ($sucesso) {
            header('Location: index.php?mensagem=Evento removido com sucesso.&tipo=success');
        } else {
            header('Location: index.php?mensagem=Erro ao remover o evento.&tipo=danger');
        }
        
        exit;
    }

    private function normalizarDadosEvento($dados)
    {
        return [
            'nome' => isset($dados['nome']) ? trim($dados['nome']) : '',
            'cidade' => isset($dados['cidade']) ? trim($dados['cidade']) : '',
            'data_evento' => isset($dados['data_evento']) ? trim($dados['data_evento']) : '',
            'distancia' => isset($dados['distancia']) ? trim($dados['distancia']) : '',
            'status_evento' => isset($dados['status_evento']) ? trim($dados['status_evento']) : '',
            'observacoes' => isset($dados['observacoes']) ? trim($dados['observacoes']) : ''
        ];
    }

    private function validarDadosEvento($dados, $exigirId = false)
    {
        $erros = [];

        // O servidor não deve confiar só nas validações do navegador.
        if ($exigirId && empty($dados['id'])) {
            $erros[] = 'ID do evento inválido.';
        }

        if ($dados['nome'] === '' || mb_strlen($dados['nome']) > 150) {
            $erros[] = 'Informe um nome de evento com até 150 caracteres.';
        }

        if ($dados['cidade'] === '' || mb_strlen($dados['cidade']) > 100) {
            $erros[] = 'Informe uma cidade com até 100 caracteres.';
        }

        if (!$this->dataEhValida($dados['data_evento'])) {
            $erros[] = 'Informe uma data válida para o evento.';
        }

        if (!in_array($dados['distancia'], $this->distanciasPermitidas, true)) {
            $erros[] = 'Selecione uma distância válida.';
        }

        if (!in_array($dados['status_evento'], $this->statusPermitidos, true)) {
            $erros[] = 'Selecione um status válido.';
        }

        if (mb_strlen($dados['observacoes']) > 1000) {
            $erros[] = 'As observações devem ter no máximo 1000 caracteres.';
        }

        return $erros;
    }

    private function dataEhValida($data)
    {
        $partes = explode('-', $data);

        if (count($partes) !== 3) {
            return false;
        }

        return checkdate((int) $partes[1], (int) $partes[2], (int) $partes[0]);
    }
}
