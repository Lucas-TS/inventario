<?php
include '../includes/conecta_db.php';

$sql = "
    SELECT antivirus, COUNT(*) AS quantidade
    FROM computadores
    WHERE ativo = 1
    GROUP BY antivirus
";

$resultado = $conn->query($sql);

$mapa = [
    'Sim' => 0,
    'Não' => 0
];

$total = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $texto = $linha['antivirus'] == 1 ? 'Sim' : 'Não';
        $mapa[$texto] = (int)$linha['quantidade'];
        $total += $linha['quantidade'];
    }
}

$sistemas = [];
foreach ($mapa as $nome => $quantidade) {
    $sistemas[] = [
        'nome' => $nome,
        'quantidade' => $quantidade
    ];
}

$retorno = [
    'total' => $total,
    'sistemas' => $sistemas
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
