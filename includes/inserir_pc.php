<?php
include 'conecta_db.php';

$tipo = isset($_POST["hidden-tipo"]) ? $_POST["hidden-tipo"] : null; //Campo INT (tipo)
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
$serial_office = isset($_POST['serial-office']) ? $_POST['serial-office'] : null;  //Campo VARCHAR (licenca_office)
$hn = isset($_POST['hn']) ? $_POST['hn'] : null; //Campo VARCHAR (hostname)
$rede = isset($_POST['rede']) ? $_POST['rede'] : null; //Campo TINYINT (rede)
$mac = isset($_POST['mac']) ? str_replace(':', '', $_POST['mac']) : null;
$wifi = isset($_POST['wifi']) ? $_POST['wifi'] : null; //Campo TINYINT (wifi)
$macwifi = isset($_POST['mac_wifi']) ? str_replace(':', '', $_POST['mac_wifi']) : null;
$observacao = isset($_POST['obs']) ? str_replace(':', '', $_POST['obs']) : null;
$situacao = isset($_POST['hidden-situacao']) ? str_replace(':', '', $_POST['hidden-situacao']) : null; //Campo INT (situacao)
$ativo = 1; //Campo INT (ativo)

session_start();
$usuario = $_SESSION['id']; //Campo INT (id_inclusao)

date_default_timezone_set('America/Sao_Paulo');
$data_inclusao = date('Y-m-d H:i:s'); // Campo DATETIME (data_inclusao)

// Preparar a consulta SQL usando prepared statements
$stmt = $conn->prepare("INSERT INTO computadores (tipo, id_operador, lacre, marca, modelo, garantia, tam_mem, tipo_mem, tela, antivirus, rede, mac, wifi, mac_wifi, hostname, licenca_so, licenca_office, usuario, senha, data_inclusao, id_inclusao, situacao, observacao, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind dos parâmetros
$stmt->bind_param("iiissiissiisissssssssisi", $tipo, $id_op, $lacre, $marca, $modelo, $garantia, $qtde_mem, $tipo_mem, $tela, $av, $rede, $mac, $wifi, $macwifi, $hn, $serial_so, $serial_office, $user_so, $pw_so, $data_inclusao, $usuario, $situacao, $observacao, $ativo);

// Executar a consulta
$stmt->execute();

// Obter o ID do registro inserido
$id_pc = $conn->insert_id;

$stmt->close();

// Associação do processador
$id_processador = isset($_POST["hidden-processador-desktop"]) ? $_POST["hidden-processador-desktop"] : (isset($_POST["hidden-processador-note"]) ? $_POST["hidden-processador-note"] : null);

$stmt2 = $conn->prepare("INSERT INTO assoc_processador (id_pc, id_processador) VALUES (?, ?)");
$stmt2->bind_param("ii", $id_pc, $id_processador);
$stmt2->execute();
$stmt2->close();

// Associação da placa de víceo
if (!empty($_POST['hidden-mem-pv'])) {
    $id_pv = !empty($_POST['hidden-mem-pv']) ? $_POST['hidden-mem-pv'] : null;
    $stmt3 = $conn->prepare("INSERT INTO assoc_placa_video (id_pc, id_placa_video) VALUES (?, ?)");
    $stmt3->bind_param("ii", $id_pc, $id_pv);
    $stmt3->execute();
    $stmt3->close();
}

if (!empty($_POST['hidden-mem-pv-nb'])) {
    $id_pv = !empty($_POST['hidden-mem-pv-nb']) ? $_POST['hidden-mem-pv-nb'] : null;
    $stmt3 = $conn->prepare("INSERT INTO assoc_placa_video (id_pc, id_placa_video) VALUES (?, ?)");
    $stmt3->bind_param("ii", $id_pc, $id_pv);
    $stmt3->execute();
    $stmt3->close();
}

// Associação do SO
$id_so = isset($_POST['hidden-so']) ? $_POST['hidden-so'] : null;
$stmt4 = $conn->prepare("INSERT INTO assoc_so (id_pc, id_so) VALUES (?, ?)");
$stmt4->bind_param("ii", $id_pc, $id_so);
$stmt4->execute();
$stmt4->close();

// Associação do Office
$id_office = isset($_POST['hidden-office']) ? $_POST['hidden-office'] : null;
$stmt5 = $conn->prepare("INSERT INTO assoc_office (id_pc, id_office) VALUES (?, ?)");
$stmt5->bind_param("ii", $id_pc, $id_office);
$stmt5->execute();
$stmt5->close();

// Associação dos armazenamentos
$dsk = 1;

while (true) {
    $tipoDsk = isset($_POST["tipo-dsk-$dsk"]) ? $_POST["tipo-dsk-$dsk"] : null;
    if (!$tipoDsk) break;

    if ($tipoDsk === 'HD') {
        $tabela_dsk = 'assoc_hd';
        $coluna_dsk = 'id_hd';
        $tipo_dsk = isset($_POST["tipo-hd-$dsk"]) ? $_POST["tipo-hd-$dsk"] : null;
        $saude_dsk = isset($_POST["saude-hd-$dsk"]) ? $_POST["saude-hd-$dsk"] : null;
        $id_dsk = isset($_POST["hidden-tam-hd-$dsk"]) ? $_POST["hidden-tam-hd-$dsk"] : null;
    } elseif ($tipoDsk === 'SSD') {
        $tabela_dsk = 'assoc_ssd';
        $coluna_dsk = 'id_ssd';
        $tipo_dsk = isset($_POST["tipo-ssd-$dsk"]) ? $_POST["tipo-ssd-$dsk"] : null;
        $saude_dsk = isset($_POST["saude-ssd-$dsk"]) ? $_POST["saude-ssd-$dsk"] : null;
        $id_dsk = isset($_POST["hidden-tam-ssd-$dsk"]) ? $_POST["hidden-tam-ssd-$dsk"] : null;
    }

    $stmt6 = $conn->prepare("INSERT INTO $tabela_dsk (id_pc, $coluna_dsk, tipo, saude) VALUES (?, ?, ?, ?)");
    $stmt6->bind_param("iisi", $id_pc, $id_dsk, $tipo_dsk, $saude_dsk);
    $stmt6->execute();
    $stmt6->close();

    $dsk++;
}

// Associação dos monitores
$mon = 1;

while (true) {
    $id_monitor = isset($_POST["hidden-modelo-monitor-$mon"]) ? $_POST["hidden-modelo-monitor-$mon"] : null;
    if (!$id_monitor) break;

    $con_monitor = isset($_POST["con-monitor-$mon"]) ? $_POST["con-monitor-$mon"] : null;

    $stmt7 = $conn->prepare("INSERT INTO assoc_monitor (id_pc, id_monitor, conexao) VALUES (?, ?, ?)");
    $stmt7->bind_param("iis", $id_pc, $id_monitor, $con_monitor);
    $stmt7->execute();
    $stmt7->close();

    $mon++;
}

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