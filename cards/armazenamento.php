<?php
include '../includes/conecta_db.php';

// Configurações visuais do gráfico
$tipos = [
    'NVME' => ['cor' => '#800080'],   // Roxo
    'M.2' => ['cor' => '#0017CB'],    // Azul
    'SATA' => ['cor' => '#01CF73'],   // Amarelo
    'HD' => ['cor' => '#FF0000']      // Vermelho
];

$valores = [
    'NVME' => 0,
    'M.2' => 0,
    'SATA' => 0,
    'HD' => 0
];

$total = 0;

// Consulta todos os computadores ativos
$sql_pc = "SELECT id FROM computadores WHERE ativo = 1";
$resultado_pc = $conn->query($sql_pc);

if ($resultado_pc && $resultado_pc->num_rows > 0) {
    while ($pc = $resultado_pc->fetch_assoc()) {
        $id_pc = $pc['id'];
        $principal = 'HD'; // valor padrão

        // Consulta SSDs associados ao computador, ordenando por prioridade
        $sql_ssd = "SELECT tipo FROM assoc_ssd WHERE id_pc = ? ORDER BY 
            CASE tipo 
                WHEN 'NVME' THEN 1
                WHEN 'M.2' THEN 2
                WHEN 'SATA' THEN 3
                ELSE 4
            END LIMIT 1";
        $stmt_ssd = $conn->prepare($sql_ssd);
        $stmt_ssd->bind_param("i", $id_pc);
        $stmt_ssd->execute();
        $stmt_ssd->bind_result($tipo_ssd);
        if ($stmt_ssd->fetch()) {
            $principal = $tipo_ssd;
        } else {
            // Se não tem SSD, verifica se há HD
            $sql_hd = "SELECT id FROM assoc_hd WHERE id_pc = ? LIMIT 1";
            $stmt_hd = $conn->prepare($sql_hd);
            $stmt_hd->bind_param("i", $id_pc);
            $stmt_hd->execute();
            $stmt_hd->store_result();
            if ($stmt_hd->num_rows === 0) {
                continue; // pula PCs sem armazenamento
            }
            $stmt_hd->close();
        }
        $stmt_ssd->close();

        // Incrementa o valor do tipo identificado
        if (isset($valores[$principal])) {
            $valores[$principal]++;
            $total++;
        }
    }
}

// Prepara labels e cores para o gráfico
$labels = [];
$cores = [];
$dados = [];

foreach ($tipos as $nome => $info) {
    $labels[] = $nome;
    $cores[] = $info['cor'];
    $dados[] = $valores[$nome]; // respeita a mesma ordem!
}


$retorno = [
    'tipo' => 'grafico',
    'titulo' => 'Tipo de armazenamento principal',
    'grafico' => [
        'tipo' => 'doughnut',
        'labels' => $labels,
        'valores' => array_values($valores),
        'cores' => $cores,
        'total' => $total
    ]
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
