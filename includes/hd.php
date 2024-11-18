<?php
include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );

$tabela = 'lista_hd';

if ( $data[ 'funcao' ] == 'inserir' ) {
    $tamanho = isset( $data[ 'tamanho' ] ) ? $data[ 'tamanho' ] : null;
    $ativo = 1;
    // Campo INT ( ativo )

    // Verificar se o registro já existe
    $check_sql = "SELECT COUNT(*) FROM $tabela WHERE tamanho = ?";
    $check_stmt = $conn->prepare( $check_sql );
    if ( $check_stmt === false ) {
        die( 'Erro na preparação da declaração: ' . $conn->error );
    }
    $check_stmt->bind_param( 's', $tamanho );
    $check_stmt->execute();
    $check_stmt->bind_result( $count );
    $check_stmt->fetch();
    $check_stmt->close();

    if ( $count > 0 ) {
        http_response_code( 409 );
        // HTTP 409 Conflict
        echo 'Registro já existe.';
    } else {
        // Preparar a consulta SQL para inserção
        $sql = "INSERT INTO $tabela (tamanho, ativo) VALUES (?, ?)";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'si', $tamanho, $ativo );
        // Executar a declaração
        if ( $stmt->execute() ) {
            echo 'Dados inseridos com sucesso!';
        } else {
            echo 'Erro ao inserir os dados: ' . $stmt->error;
        }
        // Exibir os dados capturados e registrar erros no log do servidor
        error_log( 'Erro ao inserir os dados: ' . $stmt->error );
        // Fechar a declaração e a conexão
        $stmt->close();
    }
} elseif ( $data[ 'funcao' ] == 'buscar' ) {
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
} elseif ( $data[ 'funcao' ] == 'editar' ) {

    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    $tamanho = isset( $data[ 'tamanho' ] ) ? $data[ 'tamanho' ] : null;
    $ativo = isset( $data[ 'ativo' ] ) ? $data[ 'ativo' ] : 1;

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
        // Verificar se $ativo é 0 e se o id está na tabela assoc_hd
        if ( $ativo == 0 ) {
            $hd_sql = 'SELECT COUNT(*) FROM assoc_hd WHERE id_hd = ?';
            $hd_stmt = $conn->prepare( $hd_sql );
            $hd_stmt->bind_param( 'i', $id );
            $hd_stmt->execute();
            $hd_stmt->bind_result( $hd_count );
            $hd_stmt->fetch();
            $hd_stmt->close();

            if ( $hd_count > 0 ) {
                $ativo = 1;
                $mensagem_sucesso = 'Registro atualizado, mas o status ativo foi mantido devido a este HD estar vinculado a um ou mais computadores.';
            } else {
                $mensagem_sucesso = 'Registro atualizado com sucesso!';
            }
        } else {
            $mensagem_sucesso = 'Registro atualizado com sucesso!';
        }

        // Preparar a consulta SQL para atualização
        $sql = "UPDATE $tabela SET tamanho = ?, ativo = ? WHERE id = ?";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'sii', $tamanho, $ativo, $id );
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