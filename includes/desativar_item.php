<?php
header('Content-Type: application/json');
include 'conecta_db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = isset($data["id"]) ? $data["id"] : null;
$tabela = isset($data["tabela"]) ? $data["tabela"] : null;

if ($id && $tabela) {
    try {
        // Verificar se o registro existe na tabela especificada
        $check_sql = "SELECT COUNT(*) FROM $tabela WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt === false) {
            throw new Exception("Erro na preparação da declaração: " . $conn->error);
        }
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count == 1) {
            // Preparar a consulta SQL para desativação
            $deactivate_sql = "UPDATE $tabela SET ativo = 0 WHERE id = ?";
            $deactivate_stmt = $conn->prepare($deactivate_sql);
            if ($deactivate_stmt === false) {
                throw new Exception("Erro na preparação da declaração: " . $conn->error);
            }
            $deactivate_stmt->bind_param("i", $id);

            if ($deactivate_stmt->execute()) {
                echo json_encode(["message" => "Registro desativado com sucesso."]);
            } else {
                throw new Exception("Erro ao desativar o registro: " . $deactivate_stmt->error);
            }
            $deactivate_stmt->close();
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Registro não encontrado na tabela especificada."]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "ID ou tabela não especificados."]);
}

$conn->close();
