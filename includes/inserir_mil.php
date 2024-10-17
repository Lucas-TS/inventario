<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$nc = isset($data["nc"]) ? $data["nc"] : null;
$pg = isset($data["pg"]) ? $data["pg"] : null;
$ng = isset($data["ng"]) ? $data["ng"] : null;
$sec = isset($data["sec"]) ? $data["sec"] : null;
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM militares WHERE nome_completo = ? AND nome_guerra = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ssii", $nc, $ng, $pg, $sec);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO militares (nome_completo, nome_guerra, id_pg, id_secao, ativo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssiii", $nc, $ng, $pg, $sec, $ativo);
    // Executar a declaração
    if ($stmt->execute()) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir os dados: " . $stmt->error;
    }
    // Registrar erros no log do servidor
    error_log("Erro ao inserir os dados: " . $stmt->error);
    // Fechar a declaração e a conexão
    $stmt->close();
}

$conn->close();
?>