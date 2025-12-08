<?php
include '../includes/conecta_db.php';

$mapa = [
    'Sim' => ['cor' => '#008000', 'quantidade' => 0],
    'Não' => ['cor' => '#FF0000', 'quantidade' => 0]
];

$total = 0;

$sql = "
    SELECT antivirus, COUNT(*) AS quantidade
    FROM computadores
    WHERE ativo = 1
    GROUP BY antivirus
";

$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $texto = $linha['antivirus'] == 1 ? 'Sim' : 'Não';
        $mapa[$texto]['quantidade'] = intval($linha['quantidade']);
        $total += intval($linha['quantidade']);
    }
}

$labels = [];
$valores = [];
$cores = [];
foreach ($mapa as $nome => $info) {
    $labels[] = $nome;
    $valores[] = $info['quantidade'];
    $cores[] = $info['cor'];
}

$retorno = [
    'tipo' => 'grafico',
    'titulo' => 'Computadores com Antivírus Instalado',
    'grafico' => [
        'tipo' => 'doughnut',
        'labels' => $labels,
        'valores' => $valores,
        'cores' => $cores,
        'total' => $total
    ]
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>