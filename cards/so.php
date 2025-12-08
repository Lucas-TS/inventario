<?php
include '../includes/conecta_db.php';

// Consulta agrupada por nome completo do SO
$sql = "
    SELECT 
        TRIM(CONCAT_WS(' ', nome, distribuicao, versao)) AS nome,
        COUNT(*) AS quantidade
    FROM assoc_so
    INNER JOIN lista_so ON assoc_so.id_so = lista_so.id
    GROUP BY TRIM(CONCAT_WS(' ', nome, distribuicao, versao))
    ORDER BY quantidade DESC
";

$resultado = $conn->query($sql);

$labels = [];
$valores = [];
$total = 0;

// Gera cores automáticas (HSL)
function gerarCor($i, $total) {
    $hue = ($i * 360 / max(1, $total));
    return "hsl($hue, 70%, 50%)";
}

if ($resultado && $resultado->num_rows > 0) {
    $i = 0;
    $totalRows = $resultado->num_rows;
    while ($linha = $resultado->fetch_assoc()) {
        $labels[] = $linha['nome'];
        $valores[] = intval($linha['quantidade']);
        $total += intval($linha['quantidade']);
        $cores[] = gerarCor($i, $totalRows);
        $i++;
    }
}

$retorno = [
    'tipo' => 'grafico',
    'titulo' => 'Computadores por Sistema Operacional',
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