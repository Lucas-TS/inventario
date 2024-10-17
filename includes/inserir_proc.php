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

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM lista_processador WHERE marca = ? AND modelo = ? AND geracao = ? AND socket = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ssis", $marca, $modelo, $geracao, $socket);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO lista_processador (marca, modelo, geracao, socket, seguimento, clock, turbo, pcores, ecores, threads, memoria, igpu, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
    // Registrar erros no log do servidor
    error_log("Erro ao inserir os dados: " . $stmt->error);
    // Fechar a declaração e a conexão
    $stmt->close();
}

$conn->close();
?>