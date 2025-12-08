<?php
include '../includes/conecta_db.php';
header('Content-Type: application/json');

$categorias = [
    'computadores' => ['computadores'],
    'hardwares' => ['lista_processador', 'lista_hd', 'lista_ssd', 'lista_placa_video'],
    'perifericos' => ['lista_monitor'],
    'softwares' => ['lista_office', 'lista_so']
];

$card = $_GET['card'] ?? '';
$tabelas = $categorias[strtolower($card)] ?? [];

$total = 0;

foreach ($tabelas as $tabela) {
    $sql = "SELECT COUNT(*) AS quantidade FROM $tabela WHERE ativo = 1";
    $resultado = $conn->query($sql);
    if ($resultado) {
        $row = $resultado->fetch_assoc();
        $total += intval($row['quantidade']);
    }
}

echo json_encode(['quantidade' => $total]);
?>
