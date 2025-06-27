<?php
include 'conecta_db.php';

$data = json_decode( file_get_contents( 'php://input' ), true );

if ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'buscar_pc' ) {
    $tabela = 'computadores';
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
            /*$select_sql = "SELECT $tabela.*, CONCAT (pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) AS op, users_add.fullname AS fullname_add, users_updt.fullname AS fullname_updt FROM $tabela 
            LEFT JOIN militares ON $tabela.id_operador = militares.id
            LEFT JOIN pg ON militares.id_pg = pg.id
            LEFT JOIN secao ON militares.id_secao = secao.id
            LEFT JOIN users AS users_add ON $tabela.id_inclusao = users_add.id 
            LEFT JOIN users AS users_updt ON $tabela.id_atualizacao = users_updt.id 
            WHERE $tabela.id = ?";*/
            $select_sql = "SELECT $tabela.*, DATE_FORMAT(computadores.data_atualizacao, '%d/%m/%Y às %H:%i') AS data_atualizacao, DATE_FORMAT(computadores.data_inclusao, '%d/%m/%Y às %H:%i') AS data_inclusao, CONCAT (secao.sigla, ' - ', secao.nome) AS op, users_add.fullname AS fullname_add, users_updt.fullname AS fullname_updt FROM $tabela 
            LEFT JOIN secao ON $tabela.id_operador = secao.id
            LEFT JOIN users AS users_add ON $tabela.id_inclusao = users_add.id 
            LEFT JOIN users AS users_updt ON $tabela.id_atualizacao = users_updt.id 
            WHERE $tabela.id = ?";
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
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'proc' ) {
    $tabela = 'assoc_processador';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_processador, lista_processador.* FROM $tabela 
            LEFT JOIN lista_processador ON $tabela.id_processador = lista_processador.id
            WHERE $tabela.id_pc = ?";
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

    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'hd' ) {
    $tabela = 'assoc_hd';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;

    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_hd, $tabela.tipo, $tabela.saude, lista_hd.* FROM $tabela 
        LEFT JOIN lista_hd ON $tabela.id_hd = lista_hd.id
        WHERE $tabela.id_pc = ?";
        $select_stmt = $conn->prepare( $select_sql );
        if ( $select_stmt === false ) {
            throw new Exception( 'Erro na preparação da declaração: ' . $conn->error );
        }
        $select_stmt->bind_param( 'i', $id );
        if ( $select_stmt->execute() ) {
            $result = $select_stmt->get_result();
            $data = [];
            while ( $row = $result->fetch_assoc() ) {
                $data[] = $row;
                // Adiciona cada linha ao array $data
            }
            echo json_encode( $data );
            // Retorna todos os dados como JSON
        } else {
            throw new Exception( 'Erro ao buscar o registro: ' . $select_stmt->error );
        }
        $select_stmt->close();
    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'ssd' ) {
    $tabela = 'assoc_ssd';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;

    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_ssd, $tabela.tipo, $tabela.saude, lista_ssd.* FROM $tabela 
        LEFT JOIN lista_ssd ON $tabela.id_ssd = lista_ssd.id
        WHERE $tabela.id_pc = ?";
        $select_stmt = $conn->prepare( $select_sql );
        if ( $select_stmt === false ) {
            throw new Exception( 'Erro na preparação da declaração: ' . $conn->error );
        }
        $select_stmt->bind_param( 'i', $id );
        if ( $select_stmt->execute() ) {
            $result = $select_stmt->get_result();
            $data = [];
            while ( $row = $result->fetch_assoc() ) {
                $data[] = $row;
                // Adiciona cada linha ao array $data
            }
            echo json_encode( $data );
            // Retorna todos os dados como JSON
        } else {
            throw new Exception( 'Erro ao buscar o registro: ' . $select_stmt->error );
        }
        $select_stmt->close();
    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'pv' ) {
    $tabela = 'assoc_placa_video';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_placa_video, lista_placa_video.* FROM $tabela 
            LEFT JOIN lista_placa_video ON $tabela.id_placa_video = lista_placa_video.id
            WHERE $tabela.id_pc = ?";
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

    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'monitor' ) {
    $tabela = 'assoc_monitor';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;

    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_monitor, $tabela.conexao, lista_monitor.* FROM $tabela 
        LEFT JOIN lista_monitor ON $tabela.id_monitor = lista_monitor.id
        WHERE $tabela.id_pc = ?";
        $select_stmt = $conn->prepare( $select_sql );
        if ( $select_stmt === false ) {
            throw new Exception( 'Erro na preparação da declaração: ' . $conn->error );
        }
        $select_stmt->bind_param( 'i', $id );
        if ( $select_stmt->execute() ) {
            $result = $select_stmt->get_result();
            $data = [];
            while ( $row = $result->fetch_assoc() ) {
                $data[] = $row;
                // Adiciona cada linha ao array $data
            }
            echo json_encode( $data );
            // Retorna todos os dados como JSON
        } else {
            throw new Exception( 'Erro ao buscar o registro: ' . $select_stmt->error );
        }
        $select_stmt->close();
    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'so' ) {
    $tabela = 'assoc_so';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_so, lista_so.* FROM $tabela 
            LEFT JOIN lista_so ON $tabela.id_so = lista_so.id
            WHERE $tabela.id_pc = ?";
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

    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
} elseif ( isset( $data[ 'funcao' ] ) && $data[ 'funcao' ] == 'office' ) {
    $tabela = 'assoc_office';
    $id = isset( $data[ 'id' ] ) ? $data[ 'id' ] : null;
    try {
        $select_sql = "SELECT $tabela.id AS id_assoc, $tabela.id_pc, $tabela.id_office, lista_office.* FROM $tabela 
            LEFT JOIN lista_office ON $tabela.id_office = lista_office.id
            WHERE $tabela.id_pc = ?";
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

    } catch ( Exception $e ) {
        http_response_code( 500 );
        echo json_encode( [ 'error' => $e->getMessage() ] );
    }
}