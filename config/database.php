<?php
// Configura a conexão com o banco usando PDO.
// A ideia é deixar tudo centralizado em um único arquivo.

class Database
{
    private $host = 'localhost';
    private $nomeBanco = 'mvc_eventos';
    private $usuario = 'root';
    private $senha = '';

    public function connect()
    {
        try {
            $conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->nomeBanco};charset=utf8",
                $this->usuario,
                $this->senha
            );

            // Com esse modo de erro ativo, falhas de conexao ou SQL geram excecoes e ficam mais faceis de diagnosticar.
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexao;
        } catch (PDOException $erro) {
            die('Erro na conexão com o banco de dados: ' . $erro->getMessage());
        }
    }
}
