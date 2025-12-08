<?php
include 'conecta_db.php';

$id_pc = isset($_POST['id-edit-pc']) ? $_POST['id-edit-pc'] : null; //Campo INT (id)
if ($id_pc === null) {
    die("ID do computador não fornecido.");
}
$ativo = isset($_POST['ativo-edit-pc']) ? 1 : 0;

$sql = "SELECT tipo FROM computadores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pc);
$stmt->execute();
$stmt->bind_result($tipo);
$stmt->fetch();
$stmt->close();

$id_op = isset($_POST["hidden-op"]) && $_POST["hidden-op"] !== "" ? $_POST["hidden-op"] : null;
$lacre = isset($_POST["lacre"]) ? $_POST["lacre"] : null; //Campo INT (lacre)
$marca = isset($_POST["marca"]) ? $_POST["marca"] : null; //Campo VARCHAR (marca)
$modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : null; //Campo VARCHAR (modelo)
$garantia = isset($_POST["garantia"]) ? $_POST["garantia"] : null; //Campo INT (garantia)
$qtde_mem = isset($_POST['qtde-mem']) ? $_POST['qtde-mem'] : null; //Campo INT (tam_mem)
$tipo_mem = isset($_POST['tipo-mem']) ? $_POST['tipo-mem'] : null; //Campo VARCHAR (tipo_mem)
$tela = isset($_POST['tela']) ? $_POST['tela'] : null; //Campo VARCHAR (tela)
$av = isset($_POST['av']) ? $_POST['av'] : null; //Campo TINYINT (antivirus)
$user_so = isset($_POST['user-so']) ? $_POST['user-so'] : null; //Campo VARCHAR (usuario)
$pw_so = isset($_POST['pw-so']) ? $_POST['pw-so'] : null; //Campo VARCHAR (senha)
if (isset($_POST['licenca'])) {
    if ($_POST['licenca'] == 'serial') {
        $serial_so = $_POST['serial-so'];
    } else {
        $serial_so = $_POST['licenca'];
    }
}
else {
    $serial_so = null; //Campo VARCHAR (licenca_so)
}
if (isset($_POST['licenca-office'])) {
    if ($_POST['licenca-office'] == 'serial') {
        $serial_office = $_POST['serial-office'];
    } else {
        $serial_office = $_POST['licenca-office'];
    }
}
else {
    $serial_office = null; //Campo VARCHAR (licenca_office)
}
$hn = isset($_POST['hn']) ? $_POST['hn'] : null; //Campo VARCHAR (hostname)
$rede = isset($_POST['rede']) ? $_POST['rede'] : null; //Campo TINYINT (rede)
$mac = isset($_POST['mac']) ? strtoupper(str_replace(':', '', $_POST['mac'])) : null;
$wifi = isset($_POST['wifi']) ? $_POST['wifi'] : null; //Campo TINYINT (wifi)
$macwifi = isset($_POST['mac-wifi']) ? strtoupper(str_replace(':', '', $_POST['mac-wifi'])) : null;
$observacao = isset($_POST['obs']) ? $_POST['obs'] : null;
$situacao = isset($_POST['hidden-situacao']) ? str_replace(':', '', $_POST['hidden-situacao']) : null; //Campo INT (situacao)

$sql = "UPDATE computadores SET ativo = ?, id_operador = ?, lacre = ?, marca = ?, modelo = ?, garantia = ?, tam_mem = ?, tipo_mem = ?, tela = ?, antivirus = ?, usuario = ?, senha = ?, licenca_so = ?, licenca_office = ?, hostname = ?, rede = ?, mac = ?, wifi = ?, mac_wifi = ?, observacao = ?, situacao = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro na preparação da declaração do computador: " . $conn->error);
}
$stmt->bind_param("iiissiississsssisissii", $ativo, $id_op, $lacre, $marca, $modelo, $garantia, $qtde_mem, $tipo_mem, $tela, $av, $user_so, $pw_so, $serial_so, $serial_office, $hn, $rede, $mac, $wifi, $macwifi, $observacao, $situacao, $id_pc);
$stmt->execute();
if ($stmt->error) {
    die("Erro ao atualizar o computador: " . $stmt->error);
}
$stmt->close();

// Atualização do processador
$id_processador = isset($_POST["hidden-processador-desktop"]) ? $_POST["hidden-processador-desktop"] :
    (isset($_POST["hidden-processador-note"]) ? $_POST["hidden-processador-note"] :
    (isset($_POST["hidden-processador-server"]) ? $_POST["hidden-processador-server"] : null));

$id_assoc_processador = isset($_POST["hidden-id-assoc-processador-desktop"]) ? $_POST["hidden-id-assoc-processador-desktop"] :
    (isset($_POST["hidden-id-assoc-processador-note"]) ? $_POST["hidden-id-assoc-processador-note"] :
    (isset($_POST["hidden-id-assoc-processador-server"]) ? $_POST["hidden-id-assoc-processador-server"] : null));

if ($id_assoc_processador) {
    // Verifica se a associação realmente existe
    $sql_check = "SELECT id FROM assoc_processador WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_assoc_processador);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Atualiza associação existente
        $sql_proc = "UPDATE assoc_processador SET id_processador = ? WHERE id = ?";
        $stmt_proc = $conn->prepare($sql_proc);
        if ($stmt_proc === false) {
            die("Erro na preparação do UPDATE: " . $conn->error);
        }
        $stmt_proc->bind_param("ii", $id_processador, $id_assoc_processador);
        $stmt_proc->execute();
        if ($stmt_proc->error) {
            die("Erro ao atualizar o processador: " . $stmt_proc->error);
        }
        $stmt_proc->close();
    } else {
        // Se o ID foi passado mas não encontrado, faz uma nova associação
        if ($id_pc !== null && $id_processador !== null) {
            $sql_insert = "INSERT INTO assoc_processador (id_pc, id_processador) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $id_pc, $id_processador);
            $stmt_insert->execute();
            if ($stmt_insert->error) {
                die("Erro ao inserir nova associação: " . $stmt_insert->error);
            }
            $stmt_insert->close();
        }
    }

    $stmt_check->close();
} elseif ($id_pc !== null && $id_processador !== null) {
    // Se não foi passado nenhum ID de associação, cria uma nova
    $sql_insert = "INSERT INTO assoc_processador (id_pc, id_processador) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $id_pc, $id_processador);
    $stmt_insert->execute();
    if ($stmt_insert->error) {
        die("Erro ao inserir associação: " . $stmt_insert->error);
    }
    $stmt_insert->close();
}


// 1) Carrega todas as associações existentes
$existing = [
  'HD'  => [],  // id_assoc_hd => row
  'SSD' => []   // id_assoc_ssd => row
];

$sql = "
  SELECT id, 'HD'  AS tipo, id_hd  AS id_dsk
    FROM assoc_hd WHERE id_pc = ?
  UNION ALL
  SELECT id, 'SSD' AS tipo, id_ssd AS id_dsk
    FROM assoc_ssd WHERE id_pc = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_pc, $id_pc);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $existing[$row['tipo']][$row['id']] = $row;
}
$stmt->close();

// 2) Itera pelos discos do formulário
$dsk = 1;
$processed_ids = [
  'HD'  => [],
  'SSD' => []
];

while ( isset($_POST["tipo-dsk-$dsk"]) ) {
  $tipoDsk = $_POST["tipo-dsk-$dsk"];    // "HD" ou "SSD"
  if (!in_array($tipoDsk, ['HD','SSD'])) {
    $dsk++; 
    continue;
  }

  // Campos genéricos por tipo
  if ($tipoDsk === 'HD') {
    $tabela   = 'assoc_hd';
    $col_dsk  = 'id_hd';
    $tipo_val = $_POST["tipo-hd-$dsk"]   ?? null;
    $saude    = $_POST["saude-hd-$dsk"]  ?? null;
    $id_dsk   = $_POST["hidden-tam-hd-$dsk"]      ?? null;
    $id_assoc = $_POST["hidden-id-assoc-hd-$dsk"] ?? null;
  } else {
    $tabela   = 'assoc_ssd';
    $col_dsk  = 'id_ssd';
    $tipo_val = $_POST["tipo-ssd-$dsk"]  ?? null;
    $saude    = $_POST["saude-ssd-$dsk"] ?? null;
    $id_dsk   = $_POST["hidden-tam-ssd-$dsk"]      ?? null;
    $id_assoc = $_POST["hidden-id-assoc-ssd-$dsk"] ?? null;
  }

  // Se veio id_assoc e está cadastrado para esse PC -> UPDATE
  if ($id_assoc 
      && array_key_exists($id_assoc, $existing[$tipoDsk])) {
    $sql = "UPDATE $tabela
              SET $col_dsk = ?, tipo = ?, saude = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "issi",
      $id_dsk, $tipo_val, $saude, $id_assoc
    );
    $stmt->execute();
    $stmt->close();

    $processed_ids[$tipoDsk][] = $id_assoc;
  }
  // Senão -> INSERT
  else {
    $sql = "INSERT INTO $tabela
              (id_pc, $col_dsk, tipo, saude)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "iisi",
      $id_pc, $id_dsk, $tipo_val, $saude
    );
    $stmt->execute();
    // pega o id gerado para excluir corretamente (opcional)
    $newId = $stmt->insert_id;
    $stmt->close();

    $processed_ids[$tipoDsk][] = $newId;
  }

  $dsk++;
}

// 3) Apaga associações que ficaram “órfãs”
foreach (['HD','SSD'] as $tp) {
  $tabela  = ($tp === 'HD' ? 'assoc_hd' : 'assoc_ssd');
  $idsUse  = $processed_ids[$tp];
  $idsIn   = $idsUse ? implode(',', $idsUse) : '0';
  $sqlDel  = "
    DELETE FROM $tabela
     WHERE id_pc = ?
       AND id NOT IN ($idsIn)
  ";
  $stmt = $conn->prepare($sqlDel);
  $stmt->bind_param("i", $id_pc);
  $stmt->execute();
  $stmt->close();
}

// Atualização dos monitores
// Obtendo todas as associações de monitor para esse computador
$monitores_atual = [];
$sql_get_monitores = "SELECT id, id_monitor FROM assoc_monitor WHERE id_pc = ?";
$stmt_get_monitores = $conn->prepare($sql_get_monitores);
$stmt_get_monitores->bind_param("i", $id_pc);
$stmt_get_monitores->execute();
$result = $stmt_get_monitores->get_result();
while ($row = $result->fetch_assoc()) {
    $monitores_atual[$row['id_monitor']] = $row['id']; // Mapeia id_monitor para id de associação
}
$stmt_get_monitores->close();

// Captura os monitores recebidos via formulário
$monitores_novos = [];
$mon = 1;
while (isset($_POST["hidden-modelo-monitor-$mon"])) {
    $id_monitor = $_POST["hidden-modelo-monitor-$mon"];
    $con_monitor = $_POST["con-monitor-$mon"] ?? null;
    $monitores_novos[$id_monitor] = $con_monitor;
    $mon++;
}

// 🔹 **Verificação e Ação**
foreach ($monitores_novos as $id_monitor => $con_monitor) {
    if (isset($monitores_atual[$id_monitor])) {
        // Atualizar monitor existente
        $id_assoc_monitor = $monitores_atual[$id_monitor];
        $sql_update = "UPDATE assoc_monitor SET conexao = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $con_monitor, $id_assoc_monitor);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        // Inserir novo monitor
        $sql_insert = "INSERT INTO assoc_monitor (id_pc, id_monitor, conexao) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iis", $id_pc, $id_monitor, $con_monitor);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
}

// Remover monitores que não foram enviados via formulário
$monitores_para_excluir = array_diff_key($monitores_atual, $monitores_novos);
foreach ($monitores_para_excluir as $id_assoc_monitor) {
    $sql_delete = "DELETE FROM assoc_monitor WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_assoc_monitor);
    $stmt_delete->execute();
    $stmt_delete->close();
}

// Atuualização da placa de vídeo
// Capturar estado de 'pv' do formulário
$pv_status = $_POST['pv'] ?? null;

// Se 'pv' for 'on', remover todas as associações de placa de vídeo
if ($pv_status === 'on') {
    $sql_delete_all_pv = "DELETE FROM assoc_placa_video WHERE id_pc = ?";
    $stmt_delete_all_pv = $conn->prepare($sql_delete_all_pv);
    if ($stmt_delete_all_pv === false) {
        die("Erro na preparação da exclusão de todas as placas de vídeo: " . $conn->error);
    }
    $stmt_delete_all_pv->bind_param("i", $id_pc);
    $stmt_delete_all_pv->execute();
    $stmt_delete_all_pv->close();
} elseif ($pv_status === 'off') {
    // Identificar qual dos dois campos está presente
    $id_pv = $_POST['hidden-mem-pv'] ?? $_POST['hidden-mem-pv-nb'] ?? null;
    $id_assoc_pv = $_POST['hidden-id-assoc-pv'] ?? null;

    if ($id_pv !== null) {
        // Capturar quantidade de associações existentes
        $sql_chk_pv = "SELECT COUNT(*) FROM assoc_placa_video WHERE id_pc = ?";
        $stmt_chk_pv = $conn->prepare($sql_chk_pv);
        if ($stmt_chk_pv === false) {
            die("Erro na preparação da verificação da placa de vídeo: " . $conn->error);
        }
        $stmt_chk_pv->bind_param("i", $id_pc);
        $stmt_chk_pv->execute();
        $stmt_chk_pv->bind_result($num_rows);
        $stmt_chk_pv->fetch();
        $stmt_chk_pv->close();

        if ($num_rows > 1) {
            // Apaga todas antes de inserir a nova
            $sql_delete_pv = "DELETE FROM assoc_placa_video WHERE id_pc = ?";
            $stmt_delete_pv = $conn->prepare($sql_delete_pv);
            if ($stmt_delete_pv === false) {
                die("Erro na preparação da exclusão da placa de vídeo: " . $conn->error);
            }
            $stmt_delete_pv->bind_param("i", $id_pc);
            $stmt_delete_pv->execute();
            $stmt_delete_pv->close();
        }

        if ($num_rows == 1) {
            // Atualizar associação existente
            if ($id_assoc_pv !== null) {
                $sql_update = "UPDATE assoc_placa_video SET id_placa_video = ? WHERE id = ? AND id_pc = ?";
                $stmt_update = $conn->prepare($sql_update);
                if ($stmt_update === false) {
                    die("Erro na preparação do UPDATE da placa de vídeo: " . $conn->error);
                }
                $stmt_update->bind_param("iii", $id_pv, $id_assoc_pv, $id_pc);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                die("Erro: ID de associação da placa de vídeo não foi fornecido.");
            }
        } else {
            // Inserir nova associação
            $sql_insert = "INSERT INTO assoc_placa_video (id_pc, id_placa_video) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            if ($stmt_insert === false) {
                die("Erro na preparação da inserção da placa de vídeo: " . $conn->error);
            }
            $stmt_insert->bind_param("ii", $id_pc, $id_pv);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
    }
}


// Atualização do Sistema Operacional
$id_so = isset($_POST["hidden-so"]) ? $_POST["hidden-so"] : null;
$id_assoc_so = isset($_POST["hidden-id-assoc-so"]) ? $_POST["hidden-id-assoc-so"] : null;
$sql_so = "UPDATE assoc_so SET id_so = ? WHERE id = ?";
$stmt_so = $conn->prepare($sql_so);
if ($stmt_so === false) {
    die("Erro na preparação da declaração do SO: " . $conn->error);
}
$stmt_so->bind_param("ii", $id_so, $id_assoc_so);
$stmt_so->execute();
if ($stmt_so->error) {
    die("Erro ao atualizar o SO: " . $stmt_so->error);
}
$stmt_so->close();

// Atualização do Office
$id_office = isset($_POST["hidden-office"]) ? $_POST["hidden-office"] : null;
$id_assoc_office = isset($_POST["hidden-id-assoc-office"]) ? $_POST["hidden-id-assoc-office"] : null;
if ($id_assoc_office === null || $id_assoc_office === '') {
    $sql_office = "INSERT INTO assoc_office (id_pc, id_office) VALUES (?, ?)";
    $stmt_office = $conn->prepare($sql_office);
    if ($stmt_office === false) {
        die("Erro na preparação da inserção do Office: " . $conn->error);
    }
    $stmt_office->bind_param("ii", $id_pc, $id_office);
    $stmt_office->execute();
} else {
    $sql_office = "UPDATE assoc_office SET id_office = ? WHERE id = ?";
    $stmt_office = $conn->prepare($sql_office);
    if ($stmt_office === false) {
        die("Erro na preparação da declaração do Oficce: " . $conn->error);
    }
    $stmt_office->bind_param("ii", $id_office, $id_assoc_office);
    $stmt_office->execute();
}
if ($stmt_office->error) {
    die("Erro ao atualizar o Office: " . $stmt_office->error);
}
$stmt_office->close();

session_start();
$usuario = $_SESSION['id']; //Campo INT (id_atualizacao)
echo "ID do usuário: " . $usuario; // Debugging line
echo "<br>";

date_default_timezone_set('America/Sao_Paulo');
$data_atualizacao = date('Y-m-d H:i:s'); // Campo DATETIME (data_atualizacao)
echo "Data de inclusão: " . $data_atualizacao; // Debugging line

$sql = "UPDATE computadores SET id_atualizacao = ?, data_atualizacao = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}
$stmt->bind_param("isi", $usuario, $data_atualizacao, $id_pc);
$stmt->execute();
$stmt->close();

$sql = "SELECT tipo FROM computadores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pc);
$stmt->execute();
$stmt->bind_result($tipo);
$stmt->fetch();
$stmt->close();

if ($tipo == 1) {
    header('Location: ../lista.php?tabela=notebooks');
}
elseif ($tipo == 0) {
    header('Location: ../lista.php?tabela=computadores');
}
else {
    header('Location: ../index.php');
}
?>
