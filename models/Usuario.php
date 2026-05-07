<?php
require_once 'config/database.php';

class Usuario
{
    private $conexao;

    public function __construct()
    {
        $bancoDeDados = new Database();
        $this->conexao = $bancoDeDados->connect();
    }

    public function buscarPorEmail($email)
    {
        $sql = 'SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1';

        // O e-mail é recebido do formulário, então a busca usa parâmetro nomeado para evitar SQL Injection.
        $comando = $this->conexao->prepare($sql);
        $comando->execute([
            ':email' => $email
        ]);

        return $comando->fetch(PDO::FETCH_ASSOC);
    }
}
