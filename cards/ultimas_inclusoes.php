<?php
include '../includes/conecta_db.php';

// Número de registros que você quer retornar
$limite = 10;

$sql = "SELECT id, hostname, data_inclusao FROM computadores WHERE ativo = 1 ORDER BY data_inclusao DESC LIMIT ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $limite);
$stmt->execute();

$resultado = $stmt->get_result();
$colunas = ['ID', 'Hostname', 'Inclusão'];
$linhas = [];

while ($linha = $resultado->fetch_assoc()) {
    // Formata a data
    $dataFormatada = (new DateTime($linha['data_inclusao']))->format('d/m/Y H:i');

    // Monta a linha com a data formatada
    $linhas[] = [
        $linha['id'],
        $linha['hostname'],
        $dataFormatada
    ];
}


$retorno = [
    'tipo' => 'tabela',
    'titulo' => 'Últimos computadores incluídos',
    'colunas' => $colunas,
    'linhas' => $linhas,
    'nome_tabela' => 'computadores',
    'acoes' => true,
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
