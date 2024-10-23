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
            // Preparar a consulta SQL para exclusão
            $delete_sql = "DELETE FROM $tabela WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            if ($delete_stmt === false) {
                throw new Exception("Erro na preparação da declaração: " . $conn->error);
            }
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                echo json_encode(["message" => "Registro apagado com sucesso."]);
            } else {
                throw new Exception("Erro ao apagar o registro: " . $delete_stmt->error);
            }
            $delete_stmt->close();
        } else {
            throw new Exception("Registro não encontrado ou múltiplos registros encontrados.");
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