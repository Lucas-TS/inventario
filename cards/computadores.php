<?php
include '../includes/conecta_db.php';

$tipos = [
    0 => ['nome' => 'Desktop', 'cor' => '#0017CB'],
    1 => ['nome' => 'Notebook', 'cor' => '#008000'],
    2 => ['nome' => 'Servidor', 'cor' => '#FF9800']
];

// Inicializa todos com zero
$valores = [0, 0, 0];
$total = 0;

$sql = "SELECT tipo, COUNT(*) AS quantidade FROM computadores WHERE ativo = 1 GROUP BY tipo";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $codigo = intval($linha['tipo']);
        if (isset($valores[$codigo])) {
            $valores[$codigo] = intval($linha['quantidade']);
            $total += intval($linha['quantidade']);
        }
    }
}

$labels = [];
$cores = [];
foreach ($tipos as $codigo => $info) {
    $labels[] = $info['nome'];
    $cores[] = $info['cor'];
}

$retorno = [
    'tipo' => 'grafico',
    'titulo' => 'Distribuição por Tipo de Computador',
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