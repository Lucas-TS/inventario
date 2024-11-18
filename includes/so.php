<?php
include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );

$tabela = 'lista_so';

if ( $data[ 'funcao' ] == 'inserir' ) {
    $dev = isset( $data[ 'dev' ] ) ? $data[ 'dev' ] : null;
    $nome = isset( $data[ 'nome' ] ) ? $data[ 'nome' ] : null;
    $distro = isset( $data[ 'distro' ] ) ? $data[ 'distro' ] : null;
    $ed = isset( $data[ 'ed' ] ) ? $data[ 'ed' ] : null;
    $versao = isset( $data[ 'versao' ] ) ? $data[ 'versao' ] : null;
    $arq = isset( $data[ 'arq' ] ) ? $data[ 'arq' ] : null;
    $ativo = 1;
    // Campo INT ( ativo )

    // Verificar se o registro já existe
    $check_sql = "SELECT COUNT(*) FROM $tabela WHERE dev = ? AND nome = ? AND distribuicao = ? AND versao = ? AND edicao = ? AND arquitetura = ?";
    $check_stmt = $conn->prepare( $check_sql );
    if ( $check_stmt === false ) {
        die( 'Erro na preparação da declaração: ' . $conn->error );
    }
    $check_stmt->bind_param( 'ssssss', $dev, $nome, $distro, $versao, $ed, $arq );
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
        $sql = "INSERT INTO $tabela (dev, nome, distribuicao, versao, edicao, arquitetura, ativo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'ssssssi', $dev, $nome, $distro, $versao, $ed, $arq, $ativo );
        // Executar a declaração
        if ( $stmt->execute() ) {
            echo 'Dados inseridos com sucesso!';
        } else {
            echo 'Erro ao inserir os dados: ' . $stmt->error;
        }
        // Registrar erros no log do servidor
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
    $nome = isset( $data[ 'nome' ] ) ? $data[ 'nome' ] : null;
    $dev = isset( $data[ 'dev' ] ) ? $data[ 'dev' ] : null;
    $distro = isset( $data[ 'distro' ] ) ? $data[ 'distro' ] : null;
    $ed = isset( $data[ 'edicao' ] ) ? $data[ 'edicao' ] : null;
    $versao = isset( $data[ 'versao' ] ) ? $data[ 'versao' ] : null;
    $arq =  isset( $data[ 'arq' ] ) ? $data[ 'arq' ] : null;
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
        // Verificar se $ativo é 0 e se o id está na tabela assoc_so
        if ( $ativo == 0 ) {
            $so_sql = 'SELECT COUNT(*) FROM assoc_so WHERE id_so = ?';
            $so_stmt = $conn->prepare( $so_sql );
            $so_stmt->bind_param( 'i', $id );
            $so_stmt->execute();
            $so_stmt->bind_result( $so_count );
            $so_stmt->fetch();
            $so_stmt->close();

            if ( $so_count > 0 ) {
                $ativo = 1;
                $mensagem_sucesso = 'Registro atualizado, mas o status ativo foi mantido devido a este sistema operacional estar vinculado a um ou mais computadores.';
            } else {
                $mensagem_sucesso = 'Registro atualizado com sucesso!';
            }
        } else {
            $mensagem_sucesso = 'Registro atualizado com sucesso!';
        }

        // Preparar a consulta SQL para atualização
        $sql = "UPDATE $tabela SET nome = ?, dev = ?, distribuicao = ?, versao = ?, edicao = ?, arquitetura = ?, ativo = ? WHERE id = ?";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'ssssssii', $nome, $dev, $distro, $versao, $ed, $arq, $ativo, $id );
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