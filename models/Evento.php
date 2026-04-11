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
        // Esta consulta busca todos os eventos e aplica uma ordenacao util para a listagem:
        // primeiro por data crescente e, em caso de empate, pelo id mais recente.
        $sql = 'SELECT * FROM eventos_corrida ORDER BY data_evento ASC, id DESC';

        // Como nao ha filtros externos aqui, query() executa o SQL diretamente.
        $comando = $this->conexao->query($sql);

        // fetchAll(PDO::FETCH_ASSOC) devolve um array de linhas usando os nomes das colunas como chaves.
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $sql = 'SELECT * FROM eventos_corrida WHERE id = :id';
        // prepare() e bindValue() evitam concatenar valores na query e deixam a consulta mais segura e organizada.
        $comando = $this->conexao->prepare($sql);
        $comando->bindValue(':id', $id, PDO::PARAM_INT);
        $comando->execute();

        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados)
    {
        // O INSERT grava um novo evento usando parametros nomeados para separar SQL e dados de entrada.
        $sql = 'INSERT INTO eventos_corrida (nome, cidade, data_evento, distancia, status_evento, observacoes)
                VALUES (:nome, :cidade, :data_evento, :distancia, :status_evento, :observacoes)';

        // prepare() monta o comando parametrizado antes de receber os valores reais.
        $comando = $this->conexao->prepare($sql);

        // execute() associa cada placeholder ao valor correspondente e envia o comando ao banco.
        return $comando->execute([
            ':nome' => $dados['nome'],
            ':cidade' => $dados['cidade'],
            ':data_evento' => $dados['data_evento'],
            ':distancia' => $dados['distancia'],
            ':status_evento' => $dados['status_evento'],
            ':observacoes' => $dados['observacoes']
        ]);
    }

    public function atualizar($dados)
    {
        // O UPDATE altera apenas o registro identificado pelo id recebido do formulario de edicao.
        $sql = 'UPDATE eventos_corrida
                SET nome = :nome,
                    cidade = :cidade,
                    data_evento = :data_evento,
                    distancia = :distancia,
                    status_evento = :status_evento,
                    observacoes = :observacoes
                WHERE id = :id';

        $comando = $this->conexao->prepare($sql);

        return $comando->execute([
            ':id' => $dados['id'],
            ':nome' => $dados['nome'],
            ':cidade' => $dados['cidade'],
            ':data_evento' => $dados['data_evento'],
            ':distancia' => $dados['distancia'],
            ':status_evento' => $dados['status_evento'],
            ':observacoes' => $dados['observacoes']
        ]);
    }

    public function excluir($id)
    {
        // O DELETE remove um unico registro com base na chave primaria informada.
        $sql = 'DELETE FROM eventos_corrida WHERE id = :id';

        $comando = $this->conexao->prepare($sql);

        return $comando->execute([
            ':id' => $id
        ]);
    }
}
