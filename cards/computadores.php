<?php
include '../includes/conecta_db.php';

// Tipos esperados
$tiposEsperados = [
    0 => 'Desktop',
    1 => 'Notebook',
    2 => 'Servidor'
];

// Inicializa todos com zero
$tipos = [];
foreach ($tiposEsperados as $codigo => $nome) {
    $tipos[$codigo] = ['tipo' => $codigo, 'quantidade' => 0];
}

// Consulta agrupada apenas para ativos
$sql = "SELECT tipo, COUNT(*) AS quantidade FROM computadores WHERE ativo = 1 GROUP BY tipo";
$resultado = $conn->query($sql);

$total = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $codigo = intval($linha['tipo']);
        $quantidade = intval($linha['quantidade']);

        if (array_key_exists($codigo, $tipos)) {
            $tipos[$codigo]['quantidade'] = $quantidade;
            $total += $quantidade;
        }
    }
}

// Retorno JSON com total agregado
$retorno = [
    'total' => $total,
    'tipos' => array_values($tipos) // Reindexa como lista
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
