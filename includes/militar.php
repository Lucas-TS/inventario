<?php

include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );

$tabela = 'militares';

if ( $data[ 'funcao' ] == 'inserir' ) {
    $nc = isset( $data[ 'nc' ] ) ? $data[ 'nc' ] : null;
    $pg = isset( $data[ 'pg' ] ) ? $data[ 'pg' ] : null;
    $ng = isset( $data[ 'ng' ] ) ? $data[ 'ng' ] : null;
    $sec = isset( $data[ 'sec' ] ) ? $data[ 'sec' ] : null;
    $ativo = 1;

    // Verificar se o registro já existe
    $check_sql = "SELECT COUNT(*) FROM $tabela WHERE nome_completo = ? AND nome_guerra = ?";
    $check_stmt = $conn->prepare( $check_sql );
    if ( $check_stmt === false ) {
        die( 'Erro na preparação da declaração: ' . $conn->error );
    }
    $check_stmt->bind_param( 'ss', $nc, $ng );
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
        $sql = "INSERT INTO $tabela (nome_completo, nome_guerra, id_pg, id_secao, ativo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'ssiii', $nc, $ng, $pg, $sec, $ativo );
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
}
elseif ($data['funcao'] == 'buscar') {
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        // Verificar se o registro existe na tabela especificada
        $check_sql = "SELECT COUNT(*) FROM $tabela WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt === false) {
            throw new Exception('Erro na preparação da declaração: ' . $conn->error);
        }

        $check_stmt->bind_param('i', $id);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count == 1) {
            $select_sql = "SELECT militares.id, militares.nome_completo, militares.nome_guerra, militares.id_pg, militares.id_secao, CONCAT(pg.abreviatura, ' - ', pg.pg) AS lista_pg, CONCAT(secao.sigla, ' - ', secao.nome) AS lista_secao, militares.ativo FROM $tabela LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id WHERE militares.id = ?";
            $select_stmt = $conn->prepare($select_sql);
            if ($select_stmt === false) {
                throw new Exception('Erro na preparação da declaração: ' . $conn->error);
            }
            $select_stmt->bind_param('i', $id);
            if ($select_stmt->execute()) {
                $result = $select_stmt->get_result();
                $data = $result->fetch_assoc();
                echo json_encode($data); // Retornar os dados como JSON
            } else {
                throw new Exception('Erro ao buscar o registro: ' . $select_stmt->error);
            }
            $select_stmt->close();
        } else {
            throw new Exception('Registro não encontrado ou múltiplos registros encontrados.');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
elseif ( $data[ 'funcao' ] == 'editar' ) {    
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;    
    $nc = isset( $data[ 'nc' ] ) ? $data[ 'nc' ] : null;    
    $pg = isset( $data[ 'pg' ] ) ? $data[ 'pg' ] : null;    
    $ng = isset( $data[ 'ng' ] ) ? $data[ 'ng' ] : null;    
    $sec = isset( $data[ 'sec' ] ) ? $data[ 'sec' ] : null;    
    $ativo = isset( $data[ 'ativo' ] ) ? $data[ 'ativo' ] : null;

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

    if ($count == 1) {
        // Verificar se $ativo é 0 e se o id está na tabela computadores
        if ($ativo == 0) {
            $comp_sql = "SELECT COUNT(*) FROM computadores WHERE id_operador = ?";
            $comp_stmt = $conn->prepare($comp_sql);
            $comp_stmt->bind_param('i', $id);
            $comp_stmt->execute();
            $comp_stmt->bind_result($comp_count);
            $comp_stmt->fetch();
            $comp_stmt->close();

            if ($comp_count > 0) {
                $ativo = 1;
                $mensagem_sucesso = 'Registro atualizado, mas o status ativo foi mantido devido a computadores vinculados ao militar.';
            } else {
                $mensagem_sucesso = 'Registro atualizado com sucesso!';
            }
        } else {
            $mensagem_sucesso = 'Registro atualizado com sucesso!';
        }

        // Preparar a consulta SQL para atualização
        $sql = "UPDATE $tabela SET nome_completo = ?, nome_guerra = ?, id_pg = ?, id_secao = ?, ativo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na preparação da declaração: ' . $conn->error);
        }
        // Vincular os parâmetros
        $stmt->bind_param('ssiiii', $nc, $ng, $pg, $sec, $ativo, $id);
        // Executar a declaração
        if ($stmt->execute()) {
            echo json_encode(['mensagem' => $mensagem_sucesso]);
        } else {
            echo 'Erro ao atualizar os dados: ' . $stmt->error;
            // Registrar erros no log do servidor
            error_log('Erro ao atualizar os dados: ' . $stmt->error);
        }
        // Fechar a declaração e a conexão
        $stmt->close();
    } else {
        throw new Exception('Registro não encontrado ou múltiplos registros encontrados.');
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID ou tabela não especificados.']);
}

$conn->close();

?>