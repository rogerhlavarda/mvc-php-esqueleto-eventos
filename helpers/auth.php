<?php

function iniciarSessao()
{
    // A sessão precisa existir antes de qualquer leitura ou gravação em $_SESSION.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function usuarioEstaAutenticado()
{
    iniciarSessao();

    // Se existir um usuário salvo na sessão, o login continua válido entre as páginas.
    return isset($_SESSION['usuario']);
}

function obterUsuarioAutenticado()
{
    iniciarSessao();

    // Retorna os dados do usuário logado ou null quando não houver autenticação ativa.
    return $_SESSION['usuario'] ?? null;
}

function exigirAutenticacao()
{
    if (!usuarioEstaAutenticado()) {
        header('Location: index.php?acao=login&mensagem=Faça login para acessar esta área.&tipo=warning');
        exit;
    }
}

function gerarTokenCsrf()
{
    iniciarSessao();

    // O token identifica que o formulário foi gerado pela própria aplicação.
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarTokenCsrf($token)
{
    iniciarSessao();

    // hash_equals() evita comparações inseguras entre o valor recebido e o valor salvo na sessão.
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function exigirTokenCsrf($token)
{
    if (!validarTokenCsrf($token)) {
        header('Location: index.php?mensagem=Token de segurança inválido. Recarregue a página e tente novamente.&tipo=danger');
        exit;
    }
}

function montarSessaoUsuario(array $usuario)
{
    return [
        'id' => $usuario['id'],
        'nome' => $usuario['nome'],
        'email' => $usuario['email']
    ];
}

function registrarUsuarioNaSessao(array $usuario)
{
    iniciarSessao();

    // Regenera o identificador da sessão no momento do login para evitar reaproveitamento indevido.
    session_regenerate_id(true);

    // Guarda apenas os dados necessários para reconhecer o usuário nas próximas requisições.
    $_SESSION['usuario'] = $usuario;
}

function logoutUsuario()
{
    iniciarSessao();

    // Remove os dados da sessão da memória atual.
    $_SESSION = [];

    // Remove o cookie da sessão no navegador para encerrar a identificação do usuário.
    if (ini_get('session.use_cookies')) {
        $parametros = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametros['path'],
            $parametros['domain'],
            $parametros['secure'],
            $parametros['httponly']
        );
    }

    // Destrói a sessão no servidor para finalizar o logout por completo.
    session_destroy();
}
