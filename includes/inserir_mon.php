<?php
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$marca = isset($data["marca"]) ? $data["marca"] : null;
$modelo = isset($data["modelo"]) ? $data["modelo"] : null;
$tamanho = isset($data["tamanho"]) ? $data["tamanho"] : null;
$res = isset($data["res"]) ? $data["res"] : null;
$hdmi = isset($data["hdmi"]) ? $data["hdmi"] : null;
$dp = isset($data["dp"]) ? $data["dp"] : null;
$dvi = isset($data["dvi"]) ? $data["dvi"] : null;
$vga = isset($data["vga"]) ? $data["vga"] : null;
$usb = isset($data["usb"]) ? $data["usb"] : null;
$p2 = isset($data["p2"]) ? $data["p2"] : null;
$ativo = 1; // Campo INT (ativo)

// Verificar se o registro já existe
$check_sql = "SELECT COUNT(*) FROM lista_monitor WHERE marca = ? AND modelo = ? AND tamanho_tela = ? AND resolucao = ?";
$check_stmt = $conn->prepare($check_sql);
if ($check_stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$check_stmt->bind_param("ssis", $marca, $modelo, $tamanho, $res);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    http_response_code(409); // HTTP 409 Conflict
    echo "Registro já existe.";
} else {
    // Preparar a consulta SQL para inserção
    $sql = "INSERT INTO lista_monitor (marca, modelo, tamanho_tela, resolucao, hdmi, dp, dvi, vga, usb, p2, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }
    // Vincular os parâmetros
    $stmt->bind_param("ssisiiiiiii", $marca, $modelo, $tamanho, $res, $hdmi, $dp, $dvi, $vga, $usb, $p2, $ativo);
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