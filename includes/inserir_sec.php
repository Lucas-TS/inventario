<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$sigla = isset($data["sigla"]) ? $data["sigla"] : null;
$nome = isset($data["nome"]) ? $data["nome"] : null;
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM secao WHERE nome = ? OR sigla = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ss", $nome, $sigla);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO secao (nome, sigla, ativo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssi", $nome, $sigla, $ativo);
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
