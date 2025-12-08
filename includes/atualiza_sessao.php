<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include 'conecta_db.php';

$tabela = 'users';
$found = false;

// Certifique-se de pegar os dados do POST
$data = json_decode(file_get_contents('php://input'), true);

$db_username = isset($data['username']) ? $data['username'] : null;
$db_fullname = isset($data['fullname']) ? $data['fullname'] : null;
$db_email = isset($data['email']) ? $data['email'] : null;
$db_id = isset($data['id']) ? $data['id'] : null;

$session_timeout = 900;
$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die('Failed to connect to database server!<br>' . $db->connect_error);
}

// Usando prepared statements para evitar injeção SQL
$sql = "SELECT * FROM $tabela WHERE id = ? AND username = ? AND fullname = ? AND email = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('isss', $db_id, $db_username, $db_fullname, $db_email);
$stmt->execute();
$result = $stmt->get_result();

if ($banco = $result->fetch_array(MYSQLI_ASSOC)) {
    $found = true;
    $db_email = $banco['email'];
    $db_fullname = $banco['fullname'];
    $db_cpf = $banco['cpf'];
    $db_username = $banco['username'];
    $db_grupo = $banco['grupo'];
    $db_id = $banco['id'];
    if ($banco['avatar'] != NULL) {
        $avatar = "images/avatares/{$banco['avatar']}";
    } else {
        $avatar = 'images/avatar.png';
    }
}

$stmt->close();
$db->close();

session_regenerate_id(true); // Regenera o ID da sessão

$_SESSION['email'] = $db_email;
$_SESSION['fullname'] = $db_fullname;
$_SESSION['cpf'] = $db_cpf;
$_SESSION['username'] = $db_username;
$_SESSION['id'] = $db_id;
$_SESSION['grupo'] = $db_grupo;
$_SESSION['avatar'] = $avatar;
$_SESSION['expires_by'] = time() + $session_timeout;
$_SESSION['expires_timeout'] = $session_timeout;

// Adicione uma resposta JSON
header('Content-Type: application/json');
if ($found) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}
?>