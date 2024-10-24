<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$gpu = isset($data["chipset"]) ? $data["chipset"] : null;
$marca = isset($data["marca"]) ? $data["marca"] : null;
$modelo = isset($data["modelo"]) ? $data["modelo"] : null;
$memoria = isset($data["memoria"]) ? $data["memoria"] : null;
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM lista_placa_video WHERE gpu = ? AND marca = ? AND modelo = ? AND memoria = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ssss", $gpu, $marca, $modelo, $memoria);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO lista_placa_video (gpu, marca, modelo, memoria, ativo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssssi", $gpu, $marca, $modelo, $memoria, $ativo);
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