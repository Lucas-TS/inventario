<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);

$dev = isset($data["dev"]) ? $data["dev"] : null;
$nome = isset($data["nome"]) ? $data["nome"] : null;
$ed = isset($data["ed"]) ? $data["ed"] : null;
$versao = isset($data["versao"]) ? $data["versao"] : null;
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM lista_office WHERE dev = ? AND nome = ? AND versao = ? AND edicao = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ssss", $dev, $nome, $versao, $ed);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO lista_office (dev, nome, versao, edicao, ativo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssssi", $dev, $nome, $versao, $ed, $ativo);
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
