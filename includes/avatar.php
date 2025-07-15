<?php
include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );
$tabela = 'users';

// Função buscar
if ( $data[ 'funcao' ] === 'buscar' ) {
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        // Verificar se o registro existe na tabela especificada
        $check_sql = "SELECT COUNT(*) FROM $tabela WHERE id = ?";
        $check_stmt = $conn->prepare( $check_sql );
        if ( $check_stmt === false ) {
            throw new Exception( 'Erro na preparação da declaração: ' . $conn->error );
        }
        $check_stmt->bind_param( 'i', $id );
        $check_stmt->execute();
        $check_stmt->bind_result( $count );
        $check_stmt->fetch();
        $check_stmt->close();
        if ( $count == 1 ) {
            $select_sql = "SELECT * FROM $tabela WHERE id = ?";
            $select_stmt = $conn->prepare( $select_sql );
            if ( $select_stmt === false ) {
                throw new Exception( 'Erro na preparação da declaração: ' . $conn->error );
            }
            $select_stmt->bind_param( 'i', $id );
            if ( $select_stmt->execute() ) {
                $result = $select_stmt->get_result();
                $data = $result->fetch_assoc();
                echo json_encode( $data );
                // Retornar os dados como JSON
            } else {
                throw new Exception( 'Erro ao buscar o registro: ' . $select_stmt->error );
            }
            $select_stmt->close();
        } else {
            throw new Exception( 'Registro não encontrado ou múltiplos registros encontrados.' );
        }
    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
}
// Função editar
elseif ( $data[ 'funcao' ] === 'editar' ) {
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    $nc = isset( $data[ 'nc' ] ) ? $data[ 'nc' ] : null;
    $email = isset( $data[ 'email' ] ) ? $data[ 'email' ] : null;
    $pw = isset( $data[ 'pw' ] ) ? $data[ 'pw' ] : null;
    $avatar = isset( $data[ 'avatar' ] ) ? $data[ 'avatar' ] : null;

    // Verificar se o registro já existe
    $check_sql = "SELECT COUNT(*) FROM $tabela WHERE id = ?";
    $check_stmt = $conn->prepare( $check_sql );
    if ( $check_stmt === false ) {
        die( 'Erro na preparação da declaração: ' . $conn->error );
    }
    $check_stmt->bind_param( 'i', $id );
    $check_stmt->execute();
    $check_stmt->bind_result( $count );
    $check_stmt->fetch();
    $check_stmt->close();

    if ( $count == 1 ) {
        $mensagem_sucesso = 'Perfil atualizado com sucesso!';
        if ( !empty( $pw ) ) {
            // Preparar a consulta SQL para atualização com senha
            $crypt_pw = password_hash( $pw, PASSWORD_DEFAULT );
            $sql = "UPDATE $tabela SET fullname = ?, email = ?, avatar = ?, `password` = ? WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            if ( $stmt === false ) {
                die( 'Erro na preparação da declaração: ' . $conn->error );
            }
            // Vincular os parâmetros
            $stmt->bind_param( 'ssssi', $nc, $email, $avatar, $crypt_pw, $id );
        } else {
            // Preparar a consulta SQL para atualização sem senha
            $sql = "UPDATE $tabela SET fullname = ?, email = ?, avatar = ? WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            if ( $stmt === false ) {
                die( 'Erro na preparação da declaração: ' . $conn->error );
            }
            // Vincular os parâmetros
            $stmt->bind_param( 'sssi', $nc, $email, $avatar, $id );
        }
        // Executar a declaração
        if ( $stmt->execute() ) {
            echo json_encode( [ 'mensagem' => $mensagem_sucesso ] );
        } else {
            echo 'Erro ao atualizar os dados: ' . $stmt->error;
            // Registrar erros no log do servidor
            error_log( 'Erro ao atualizar os dados: ' . $stmt->error );
        }
        // Fechar a declaração e a conexão
        $stmt->close();
    } else {
        throw new Exception( 'Registro não encontrado ou múltiplos registros encontrados.' );
    }
} else {
    http_response_code( 400 );
    echo json_encode( [ 'error' => 'ID ou tabela não especificados.' ] );
}

$conn->close();
?>