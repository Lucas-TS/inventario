<?php
session_start();

if (isset($_POST['form_name']) && $_POST['form_name'] === 'loginform') {
    $success_page = isset($_SESSION['url']) ? $_SESSION['url'] : '../index.php';
    $error_page = '../login.php';
    include 'conecta_db.php'; // Inclui configurações de conexão
    $mysql_table = 'users';
    $entered_password = $_POST['password'];
    $found = false;
    $db_email = '';
    $db_fullname = '';
    $db_username = '';
    $session_timeout = 3600;

    // Conexão com o banco de dados
    $db = new mysqli($servername, $username, $password, $dbname);
    if ($db->connect_error) {
        die('Falha ao conectar ao banco de dados: ' . $db->connect_error);
    }

    $sql = "SELECT * FROM $mysql_table WHERE username = ?";
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        die('Erro na preparação da declaração: ' . $db->error);
    }

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($data = $result->fetch_assoc()) {
        $db_password_hash = $data['password'];
        if (password_verify($entered_password, $db_password_hash) && $data['ativo'] !== 0) {
            $found = true;
            $db_email = $data['email'];
            $db_fullname = $data['fullname'];
            $db_username = $data['username'];
            $db_grupo = $data['grupo'];
            $db_id = $data['id'];
            $avatar = $data['avatar'] != NULL ? "images/avatares/{$data['avatar']}" : 'images/avatar.png';
        }
    }

    $stmt->close();
    $db->close();

    if ($found === false) {
        header('Location: ' . $error_page);
        exit;
    } else {
        session_regenerate_id(true);
        $_SESSION['email'] = $db_email;
        $_SESSION['fullname'] = $db_fullname;
        $_SESSION['username'] = $db_username;
        $_SESSION['id'] = $db_id;
        $_SESSION['grupo'] = $db_grupo;
        $_SESSION['avatar'] = $avatar;
        $_SESSION['expires_by'] = time() + $session_timeout;
        $_SESSION['expires_timeout'] = $session_timeout;

        if (isset($_POST['rememberme'])) {
            $token = bin2hex(random_bytes(16));
            setcookie('auth_token', $token, time() + 3600 * 24 * 30, '/');

            // Armazene o token no banco de dados
            $db = new mysqli($servername, $username, $password, $dbname);
            $sql = "UPDATE $mysql_table SET auth_token = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            if ($stmt === false) {
                die('Erro na preparação da declaração: ' . $db->error);
            }
            $stmt->bind_param('si', $token, $db_id);
            $stmt->execute();
            $stmt->close();
            $db->close();
        }

        header('Location: ' . $success_page);
        exit;
    }
}
?>
