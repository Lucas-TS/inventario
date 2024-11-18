<?php
include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );

$tabela = 'lista_monitor';

if ( $data[ 'funcao' ] == 'inserir' ) {
    $marca = isset( $data[ 'marca' ] ) ? $data[ 'marca' ] : null;
    $modelo = isset( $data[ 'modelo' ] ) ? $data[ 'modelo' ] : null;
    $tela = isset( $data[ 'tela' ] ) ? $data[ 'tela' ] : null;
    $res = isset( $data[ 'res' ] ) ? $data[ 'res' ] : null;
    $hdmi = !empty( $data[ 'hdmi' ] ) ? $data[ 'hdmi' ] : null;
    $dp = !empty( $data[ 'dp' ] ) ? $data[ 'dp' ] : null;
    $dvi = !empty( $data[ 'dvi' ] ) ? $data[ 'dvi' ] : null;
    $vga = !empty( $data[ 'vga' ] ) ? $data[ 'vga' ] : null;
    $usb = !empty( $data[ 'usb' ] ) ? $data[ 'usb' ] : null;
    $p2 = !empty( $data[ 'p2' ] ) ? $data[ 'p2' ] : null;
    $ativo = 1;
    // Campo INT ( ativo )

    // Verificar se o registro já existe
    $check_sql = "SELECT COUNT(*) FROM $tabela WHERE marca = ? AND modelo = ? AND tamanho_tela = ? AND resolucao = ?";
    $check_stmt = $conn->prepare( $check_sql );
    if ( $check_stmt === false ) {
        die( 'Erro na preparação da declaração: ' . $conn->error );
    }
    $check_stmt->bind_param( 'ssis', $marca, $modelo, $tela, $res );
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
        $sql = "INSERT INTO $tabela (marca, modelo, tamanho_tela, resolucao, hdmi, dp, dvi, vga, usb, p2, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'ssisiiiiiii', $marca, $modelo, $tela, $res, $hdmi, $dp, $dvi, $vga, $usb, $p2, $ativo );
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
} elseif ($data['funcao'] == 'buscar') {
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
            $select_sql = "SELECT * FROM $tabela WHERE id = ?";
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
} elseif ( $data[ 'funcao' ] == 'editar' ) {

    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    $marca = isset( $data[ 'marca' ] ) ? $data[ 'marca' ] : null;
    $modelo = isset( $data[ 'modelo' ] ) ? $data[ 'modelo' ] : null;
    $tela = isset( $data[ 'tela' ] ) ? $data[ 'tela' ] : null;
    $res = isset( $data[ 'res' ] ) ? $data[ 'res' ] : null;
    $hdmi = !empty( $data[ 'hdmi' ] ) ? $data[ 'hdmi' ] : null;
    $dp = !empty( $data[ 'dp' ] ) ? $data[ 'dp' ] : null;
    $dvi = !empty( $data[ 'dvi' ] ) ? $data[ 'dvi' ] : null;
    $vga = !empty( $data[ 'vga' ] ) ? $data[ 'vga' ] : null;
    $usb = !empty( $data[ 'usb' ] ) ? $data[ 'usb' ] : null;
    $p2 = !empty( $data[ 'p2' ] ) ? $data[ 'p2' ] : null;
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
        // Verificar se $ativo é 0 e se o id está na tabela assoc_monitor
        if ( $ativo == 0 ) {
            $mon_sql = 'SELECT COUNT(*) FROM assoc_monitor WHERE id_monitor = ?';
            $mon_stmt = $conn->prepare( $mon_sql );
            $mon_stmt->bind_param( 'i', $id );
            $mon_stmt->execute();
            $mon_stmt->bind_result( $mon_count );
            $mon_stmt->fetch();
            $mon_stmt->close();

            if ( $mon_count > 0 ) {
                $ativo = 1;
                $mensagem_sucesso = 'Registro atualizado, mas o status ativo foi mantido devido a este monitor estar vinculado a um ou mais computadores.';
            } else {
                $mensagem_sucesso = 'Registro atualizado com sucesso!';
            }
        } else {
            $mensagem_sucesso = 'Registro atualizado com sucesso!';
        }

        // Preparar a consulta SQL para atualização
        $sql = "UPDATE $tabela SET marca = ?, modelo = ?, tamanho_tela = ?, resolucao = ?, hdmi = ?, dp = ?, dvi = ?, vga = ?, usb = ?, p2 = ?, ativo = ? WHERE id = ?";
        $stmt = $conn->prepare( $sql );
        if ( $stmt === false ) {
            die( 'Erro na preparação da declaração: ' . $conn->error );
        }
        // Vincular os parâmetros
        $stmt->bind_param( 'ssisiiiiiiii', $marca, $modelo, $tela, $res, $hdmi, $dp, $dvi, $vga, $usb, $p2, $ativo, $id );
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