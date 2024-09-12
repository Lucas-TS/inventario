<?php
include 'conecta_db.php';

$id_op = isset($_GET["hidden-op"]) ? $_GET["hidden-op"] : null; //Campo INT (id_operador)
$lacre = isset($_GET["lacre"]) ? $_GET["lacre"] : null; //Campo INT (lacre)
$marca = isset($_GET["marca"]) ? $_GET["marca"] : null; //Campo VARCHAR (marca)
$modelo = isset($_GET["modelo"]) ? $_GET["modelo"] : null; //Campo VARCHAR (modelo)
$garantia = isset($_GET["garantia"]) ? $_GET["garantia"] : null; //Campo INT (garantia)
$qtde_mem = isset($_GET['qtde-mem']) ? $_GET['qtde-mem'] : null; //Campo INT (tam_mem)
$tipo_mem = isset($_GET['tipo-mem']) ? $_GET['tipo-mem'] : null; //Campo VARCHAR (tipo_mem)
$user_so = isset($_GET['user-so']) ? $_GET['user-so'] : null; //Campo VARCHAR (usuario)
$pw_so = isset($_GET['pw-so']) ? $_GET['pw-so'] : null; //Campo VARCHAR (senha)
if (isset($_GET['licenca'])) {
    if ($_GET['licenca'] == 'serial') {
        $serial_so = $_GET['serial-so'];
    } else {
        $serial_so = $_GET['licenca'];
    }
}
//$serial_so = isset($_GET['serial-so']) ? $_GET['serial-so'] : null; //Campo VARCHAR (licenca_so)
$serial_office = isset($_GET['serial-office']) ? $_GET['serial-office'] : null;  //Campo VARCHAR (licenca_office)
$av = isset($_GET['av']) ? $_GET['av'] : null; //Campo TINYINT (antivirus)
$hn = isset($_GET['hn']) ? $_GET['hn'] : null; //Campo VARCHAR (hostname)
$rede = isset($_GET['rede']) ? $_GET['rede'] : null; //Campo TINYINT (rede)
$mac = isset($_GET['mac']) ? str_replace(':', '', $_GET['mac']) : null;
$situacao = 2; //Campo INT (situacao)
$ativo = 1; //Campo INT (ativo)

session_start();
$usuario = $_SESSION['id']; //Campo INT (id_inclusao)

date_default_timezone_set('America/Sao_Paulo');
$data_inclusao = date('Y-m-d H:i:s'); // Campo DATETIME (data_inclusao)

// Preparar a consulta SQL usando prepared statements
$stmt = $conn->prepare("INSERT INTO computadores (id_operador, lacre, marca, modelo, garantia, tam_mem, tipo_mem, antivirus, rede, mac, hostname, licenca_so, licenca_office, usuario, senha, data_inclusao, id_inclusao, situacao, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind dos parâmetros
$stmt->bind_param("iissiisiissssssssii", $id_op, $lacre, $marca, $modelo, $garantia, $qtde_mem, $tipo_mem, $av, $rede, $mac, $hn, $serial_so, $serial_office, $user_so, $pw_so, $data_inclusao, $usuario, $situacao, $ativo);

// Executar a consulta
$stmt->execute();

// Obter o ID do registro inserido
$id_pc = $conn->insert_id;

$stmt->close();

// Associação do processador
$id_processador = isset($_GET["hidden-processador"]) ? $_GET["hidden-processador"] : null;

$stmt2 = $conn->prepare("INSERT INTO assoc_processador (id_pc, id_processador) VALUES (?, ?)");
$stmt2->bind_param("ii", $id_pc, $id_processador);
$stmt2->execute();
$stmt2->close();

// Associação da placa de víceo
$id_pv = isset($_GET['hidden-pv']) ? $_GET['hidden-pv'] : null;
$stmt3 = $conn->prepare("INSERT INTO assoc_placa_video (id_pc, id_placa_video) VALUES (?, ?)");
$stmt3->bind_param("ii", $id_pc, $id_pv);
$stmt3->execute();
$stmt3->close();

// Associação do SO
$id_so = isset($_GET['hidden-so']) ? $_GET['hidden-so'] : null;
$stmt4 = $conn->prepare("INSERT INTO assoc_so (id_pc, id_so) VALUES (?, ?)");
$stmt4->bind_param("ii", $id_pc, $id_so);
$stmt4->execute();
$stmt4->close();

// Associação do Office
$id_office = isset($_GET['hidden-office']) ? $_GET['hidden-office'] : null;
$stmt5 = $conn->prepare("INSERT INTO assoc_office (id_pc, id_office) VALUES (?, ?)");
$stmt5->bind_param("ii", $id_pc, $id_office);
$stmt5->execute();
$stmt5->close();

// Associação dos armazenamentos
$dsk = 1;

while (true) {
    $tipoDsk = isset($_GET["tipo-dsk-$dsk"]) ? $_GET["tipo-dsk-$dsk"] : null;
    if (!$tipoDsk) break;

    if ($tipoDsk === 'HD') {
        $tabela_dsk = 'assoc_hd';
        $coluna_dsk = 'id_hd';
        $tipo_dsk = isset($_GET["tipo-hd-$dsk"]) ? $_GET["tipo-hd-$dsk"] : null;
        $saude_dsk = isset($_GET["saude-hd-$dsk"]) ? $_GET["saude-hd-$dsk"] : null;
        $id_dsk = isset($_GET["hidden-tam-hd-$dsk"]) ? $_GET["hidden-tam-hd-$dsk"] : null;
    } elseif ($tipoDsk === 'SSD') {
        $tabela_dsk = 'assoc_ssd';
        $coluna_dsk = 'id_ssd';
        $tipo_dsk = isset($_GET["tipo-ssd-$dsk"]) ? $_GET["tipo-ssd-$dsk"] : null;
        $saude_dsk = isset($_GET["saude-ssd-$dsk"]) ? $_GET["saude-ssd-$dsk"] : null;
        $id_dsk = isset($_GET["hidden-tam-ssd-$dsk"]) ? $_GET["hidden-tam-ssd-$dsk"] : null;
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
    $id_monitor = isset($_GET["hidden-modelo-monitor-$mon"]) ? $_GET["hidden-modelo-monitor-$mon"] : null;
    if (!$id_monitor) break;

    $con_monitor = isset($_GET["con-monitor-$mon"]) ? $_GET["con-monitor-$mon"] : null;

    $stmt7 = $conn->prepare("INSERT INTO assoc_monitor (id_pc, id_monitor, conexao) VALUES (?, ?, ?)");
    $stmt7->bind_param("iis", $id_pc, $id_monitor, $con_monitor);
    $stmt7->execute();
    $stmt7->close();

    $mon++;
}

header('Location: ../desktops.php')
?>