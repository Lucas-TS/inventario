<?php
include '../includes/conecta_db.php';

// Define o limite de resultados
$limite = 10;

// Somente registros com data de atualização definida
$sql = "SELECT id, hostname, data_atualizacao 
        FROM computadores 
        WHERE ativo = 1 AND data_atualizacao IS NOT NULL 
        ORDER BY data_atualizacao DESC 
        LIMIT ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $limite);
$stmt->execute();

$resultado = $stmt->get_result();
$colunas = ['ID', 'Hostname', 'Última Atualização'];
$linhas = [];

while ($linha = $resultado->fetch_assoc()) {
    // Formata a data
    $dataFormatada = (new DateTime($linha['data_atualizacao']))->format('d/m/Y H:i');

    // Monta a linha com a data formatada
    $linhas[] = [
        $linha['id'],
        $linha['hostname'],
        $dataFormatada
    ];
}

$retorno = [
    'tipo' => 'tabela',
    'titulo' => 'Últimos computadores atualizados',
    'colunas' => $colunas,
    'linhas' => $linhas,
    'nome_tabela' => 'computadores',
    'acoes' => true,
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
