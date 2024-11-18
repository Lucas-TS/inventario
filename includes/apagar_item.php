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
            if ($tabela == 'users') {
                // Buscar avatar antes de excluir o registro
                $avatar_sql = "SELECT avatar FROM $tabela WHERE id = ?";
                $avatar_stmt = $conn->prepare($avatar_sql);
                $avatar_stmt->bind_param("i", $id);
                $avatar_stmt->execute();
                $avatar_stmt->bind_result($avatar);
                $avatar_stmt->fetch();
                $avatar_stmt->close();
            }

            // Preparar a consulta SQL para exclusão
            $delete_sql = "DELETE FROM $tabela WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            if ($delete_stmt === false) {
                throw new Exception("Erro na preparação da declaração: " . $conn->error);
            }
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                if ($tabela == 'users' && $avatar) {
                    $caminho = '../images/avatares/' . $avatar;
                    error_log("Tentando apagar o arquivo: $caminho"); // Log de diagnóstico

                    if (file_exists($caminho)) {
                        if (unlink($caminho)) {
                            echo json_encode(["message" => "Registro e avatar apagados com sucesso."]);
                        } else {
                            echo json_encode(["message" => "Registro apagado, mas erro ao apagar o avatar."]);
                            error_log("Erro ao apagar o arquivo: $caminho"); // Log de erro
                        }
                    } else {
                        echo json_encode(["message" => "Registro apagado, mas avatar não encontrado."]);
                        error_log("Arquivo não encontrado: $caminho"); // Log de erro
                    }
                } else {
                    echo json_encode(["message" => "Registro apagado com sucesso."]);
                }
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
