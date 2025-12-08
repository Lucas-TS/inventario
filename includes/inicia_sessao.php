<?php
session_start();

define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 300); // 5 minutos

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts']     = 0;
    $_SESSION['first_attempt_time'] = time();
}

if ($_SESSION['login_attempts'] >= MAX_LOGIN_ATTEMPTS
    && (time() - $_SESSION['first_attempt_time']) < LOCKOUT_TIME) {
    header('Location: ../login.php?error=locked');
    exit;
}

if (time() - $_SESSION['first_attempt_time'] >= LOCKOUT_TIME) {
    unset($_SESSION['login_attempts'], $_SESSION['first_attempt_time']);
}

if (isset($_POST['form_name']) && $_POST['form_name'] === 'loginform') {

    $success_page = isset($_SESSION['url']) ? $_SESSION['url'] : '../index.php';
    $error_page   = '../login.php';
    include 'conecta_db.php';

    $username_input   = trim($_POST['username']);
    $entered_password = $_POST['password'];
    $session_timeout  = 900;

    // Função de erro
    function redirectError($type) {
        // Armazena o tipo de erro na sessão (flash)
        $_SESSION['flash_error'] = $type;
        // Redireciona sem parâmetro na URL
        header('Location: ../login.php');
        exit;
    }


    // Conexão
    $db = new mysqli($servername, $username, $password, $dbname);
    if ($db->connect_error) {
        error_log('Conexão falhou: ' . $db->connect_error);
        redirectError('system');
    }

    $stmt = $db->prepare("SELECT id, username, password, email, fullname, cpf, grupo, ativo, avatar
                          FROM users WHERE username = ? OR email = ? OR cpf = ?");
    if (!$stmt) {
        error_log('Erro prepare: ' . $db->error);
        redirectError('system');
    }

    $stmt->bind_param('sss', $username_input, $username_input, $username_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($data = $result->fetch_assoc()) {
        if (password_verify($entered_password, $data['password'])
            && $data['ativo'] != 0) {
            
            // Sucesso: limpa tentativas
            unset($_SESSION['login_attempts'], $_SESSION['first_attempt_time']);
            
            session_regenerate_id(true);
            $_SESSION['id']            = $data['id'];
            $_SESSION['username']      = $data['username'];
            $_SESSION['email']         = $data['email'];
            $_SESSION['fullname']      = $data['fullname'];
            $_SESSION['cpf']           = $data['cpf'];
            $_SESSION['grupo']         = $data['grupo'];
            $_SESSION['avatar']        = $data['avatar']
                                         ? "images/avatares/{$data['avatar']}"
                                         : 'images/avatar.png';
            $_SESSION['expires_by']    = time() + $session_timeout;
            $_SESSION['expires_timeout'] = $session_timeout;

            // Proteção de sessão
            $_SESSION['ip']           = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent']   = $_SERVER['HTTP_USER_AGENT'];

            // Lembre-se do usuário
            $rememberme = isset($_POST['rememberme']) ? 1 : 0;
            if (isset($_POST['rememberme'])) {
                setcookie('remember_username', $username_input, [
                'expires' => time() + 3600 * 24 * 30, // 30 dias
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Strict'
                ]);
            } else {
                // Se o usuário desmarcar a opção, remove o cookie
                setcookie('remember_username', '', time() - 3600, '/');
            }

            header('Location: ' . $success_page);
            exit;
        }
    }

    // Falha de credenciais
    $_SESSION['login_attempts']++;
    if (!isset($_SESSION['first_attempt_time'])) {
        $_SESSION['first_attempt_time'] = time();
    }
    redirectError('credentials');
}
?>
