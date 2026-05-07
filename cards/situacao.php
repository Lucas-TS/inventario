<?php
include '../includes/conecta_db.php';

// Situações e cores (ajuste conforme seu sistema)
$situacoes = [
    0 => ['texto' => 'Em uso', 'cor' => '#008000'],
    1 => ['texto' => 'Distribuir', 'cor' => '#2196F3'],
    2 => ['texto' => 'Aguardando peças', 'cor' => '#FF9800'],
    3 => ['texto' => 'Descarregar', 'cor' => '#7E57C2'],
    4 => ['texto' => 'Bloqueado', 'cor' => '#FF0000'],
    5 => ['texto' => 'Disponivel', 'cor' => '#01CF73'],
    6 => ['texto' => 'Cautelado', 'cor' => '#888888'],
];

// Inicializa todas as situações com zero
$valores = array_fill(0, count($situacoes), 0);
$total = 0;

$sql = "SELECT situacao, COUNT(*) AS quantidade FROM computadores WHERE ativo = 1 GROUP BY situacao";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $codigo = intval($linha['situacao']);
        if (isset($valores[$codigo])) {
            $valores[$codigo] = intval($linha['quantidade']);
            $total += intval($linha['quantidade']);
        }
    }
}

$labels = [];
$cores = [];
foreach ($situacoes as $codigo => $info) {
    $labels[] = $info['texto'];
    $cores[] = $info['cor'];
}

$retorno = [
    'tipo' => 'grafico',
    'titulo' => 'Computadores por situação',
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