<?php
include '../includes/conecta_db.php';

// Agrupa por nome formatado dinamicamente (ignora NULLs e versões irrelevantes)
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

$sistemas = [];
$total = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $sistemas[] = [
            'nome' => $linha['nome'],
            'quantidade' => (int)$linha['quantidade']
        ];
        $total += $linha['quantidade'];
    }
}

$retorno = [
    'total' => $total,
    'sistemas' => $sistemas
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
