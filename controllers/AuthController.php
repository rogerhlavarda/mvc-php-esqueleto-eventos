<?php
require_once 'helpers/auth.php';
require_once 'models/Usuario.php';

class AuthController
{
    private $modeloUsuario;

    public function __construct()
    {
        $this->modeloUsuario = new Usuario();
    }

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

        exigirTokenCsrf($_POST['csrf_token'] ?? '');

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

        // O login valida formato antes de consultar o banco para evitar entradas obviamente inválidas.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
            header('Location: index.php?acao=login&mensagem=Informe um e-mail válido e uma senha.&tipo=warning');
            exit;
        }

        $usuario = $this->modeloUsuario->buscarPorEmail($email);

        // password_verify() compara a senha digitada com o hash salvo no banco.
        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            header('Location: index.php?acao=login&mensagem=Credenciais inválidas.&tipo=danger');
            exit;
        }

        // Apenas dados necessários ficam na sessão; o hash da senha não precisa ser guardado.
        registrarUsuarioNaSessao(montarSessaoUsuario($usuario));

        header('Location: index.php?mensagem=Login realizado com sucesso.&tipo=success');
        exit;
    }

    public function logout()
    {
        exigirTokenCsrf($_POST['csrf_token'] ?? '');

        // O logout remove os dados da sessão e encerra a autenticação atual.
        logoutUsuario();

        header('Location: index.php?acao=login&mensagem=Logout realizado com sucesso.&tipo=success');
        exit;
    }
}
