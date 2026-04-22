<?php
require_once 'helpers/auth.php';

class AuthController
{
    public function mostrarLogin()
    {
        $mensagem = isset($_GET['mensagem']) ? $_GET['mensagem'] : '';
        $tipoMensagem = isset($_GET['tipo']) ? $_GET['tipo'] : 'info';

        require 'views/auth/login.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?acao=login');
            exit;
        }

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

        if (!credenciaisValidas($email, $senha)) {
            header('Location: index.php?acao=login&mensagem=Credenciais inválidas.&tipo=danger');
            exit;
        }

        $usuario = montarUsuarioDeExemplo($email);

        // Após validar as credenciais, o usuário é salvo na sessão para permanecer autenticado.
        registrarUsuarioNaSessao($usuario);

        header('Location: index.php?mensagem=Login realizado com sucesso.&tipo=success');
        exit;
    }

    public function logout()
    {
        // O logout remove os dados da sessão e encerra a autenticação atual.
        logoutUsuario();

        header('Location: index.php?acao=login&mensagem=Logout realizado com sucesso.&tipo=success');
        exit;
    }
}
