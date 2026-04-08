<?php
require_once 'config/database.php';

class Evento
{
    private $conexao;

    public function __construct()
    {
        $bancoDeDados = new Database();
        $this->conexao = $bancoDeDados->connect();
    }

    public function listarTodos()
    {
        // TODO: criar um SELECT para buscar todos os registros da tabela eventos_corrida.
        // Dica: ordenar por data_evento ASC e id DESC.
        $sql = 'SELECT * FROM eventos_corrida ORDER BY data_evento ASC, id DESC';

        // TODO: executar a consulta.
        $comando = $this->conexao->query($sql);

        // TODO: retornar os resultados com fetchAll(PDO::FETCH_ASSOC).
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = 'SELECT * FROM eventos_corrida WHERE id = :id';
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        $comando->execute();

        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados)
    {
        // TODO: criar um INSERT com os campos:
        // nome, cidade, data_evento, distancia, status_evento, observacoes

        // TODO: preparar a consulta.

        // TODO: executar enviando os dados do array $dados.
    }

    public function atualizar($dados)
    {
        // TODO opcional:
        // implementar o UPDATE do evento.
    }

    public function excluir($id)
    {
        // TODO opcional:
        // implementar o DELETE do evento.
    }
}
