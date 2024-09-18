<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);

$gpu = isset($data["chipset"]) ? $data["chipset"] : null;
$marca = isset($data["marca"]) ? $data["marca"] : null;
$modelo = isset($data["modelo"]) ? $data["modelo"] : null;
$memoria = isset($data["memoria"]) ? $data["memoria"] : null;
$ativo = 1; // Campo INT (ativo)

// Preparar a consulta SQL
$sql = "INSERT INTO lista_processador (gpu, marca, modelo, memoria, ativo) VALUES (?, ?, ?, ?, ?)";

// Preparar a declaração
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Vincular os parâmetros
$stmt->bind_param("ssssi", $chipset, $marca, $modelo, $memoria, $ativo);

// Executar a declaração
if ($stmt->execute()) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir os dados: " . $stmt->error;
}
// Exibir os dados capturados


// Registrar erros no log do servidor
error_log("Erro ao inserir os dados: " . $stmt->error);
// Fechar a declaração e a conexão
$stmt->close();
$conn->close();
?>