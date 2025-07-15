<?php
include '../includes/conecta_db.php';

// Consulta agrupada apenas para ativos
$sql = "SELECT situacao, COUNT(*) AS quantidade FROM computadores WHERE ativo = 1 GROUP BY situacao";
$resultado = $conn->query($sql);

$situacoes = [];
$total = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $situacoes[] = $linha;
        $total += $linha['quantidade'];
    }
}

// Retorno JSON com total agregado
$retorno = [
    'total' => $total,
    'situacoes' => $situacoes
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>

