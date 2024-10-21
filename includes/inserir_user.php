<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$nc = isset($data["nc"]) ? $data["nc"] : null;
$email = isset($data["email"]) ? $data["email"] : null;
$user = isset($data["user"]) ? $data["user"] : null;
$pw = isset($data["pw"]) ? $data["pw"] : null;
$avatar = isset($data["avatar"]) ? $data["avatar"] : null;
$grupo = isset($data["grupo"]) ? $data["grupo"] : null;
$crypt_pw = md5($pw);
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM users WHERE username = ? AND fullname = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ss", $user, $nc);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO users (username, fullname, `password`, email, grupo, avatar, ativo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssssisi", $user, $nc, $crypt_pw, $email, $grupo, $avatar, $ativo);
    // Executar a declaração
    if ($stmt->execute()) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir os dados: " . $stmt->error;
    }
    // Exibir os dados capturados e registrar erros no log do servidor
    error_log("Erro ao inserir os dados: " . $stmt->error);
    // Fechar a declaração e a conexão
    $stmt->close();
}

$conn->close();
?>