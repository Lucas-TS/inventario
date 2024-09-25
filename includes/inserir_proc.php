<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);

$marca = isset($data["marca"]) ? $data["marca"] : null;
$modelo = isset($data["modelo"]) ? $data["modelo"] : null;
$geracao = !empty($data["geracao"]) ? $data["geracao"] : null;
$socket = isset($data["socket"]) ? $data["socket"] : null;
$seguimento = isset($data["seguimento"]) ? $data["seguimento"] : null;
$pcores = isset($data['pcores']) ? $data['pcores'] : null;
$ecores = !empty($data['ecores']) ? $data['ecores'] : null; // Verificar se está vazio
$threads = isset($data['threads']) ? $data['threads'] : null;
$clock = isset($data['clock']) ? $data['clock'] : null;
$turbo = !empty($data['turbo']) ? $data['turbo'] : null; // Verificar se está vazio
$memoria = isset($data['memoria']) ? $data['memoria'] : null;
$igpu = !empty($data['igpu']) ? $data['igpu'] : null; // Verificar se está vazio
$ativo = 1; // Campo INT (ativo)

// Preparar a consulta SQL
$sql = "INSERT INTO lista_processador (marca, modelo, geracao, socket, seguimento, clock, turbo, pcores, ecores, threads, memoria, igpu, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar a declaração
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}

// Vincular os parâmetros
$stmt->bind_param("ssissssiiissi", $marca, $modelo, $geracao, $socket, $seguimento, $clock, $turbo, $pcores, $ecores, $threads, $memoria, $igpu, $ativo);

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