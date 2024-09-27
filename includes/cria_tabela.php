<?php
include 'conecta_db.php';

// Array de substituição para os nomes das colunas
$substituicoes = [
    'id' => 'ID',
    'geracao' => 'Geração',
    'pcores' => 'P-Cores',
    'ecores' => 'E-Cores',
    'igpu' => 'iGPU',
    'memoria' => 'Memória'
    // Adicione mais substituições conforme necessário
];

// Função para formatar os nomes das colunas
function formatarNomeColuna($nome) {
    global $substituicoes;
    if (array_key_exists($nome, $substituicoes)) {
        return $substituicoes[$nome];
    } else {
        return ucfirst($nome);
    }
}

// Função para exibir dados da tabela
function exibirTabela($conn, $nomeTabela) {
    $sql = "SELECT * FROM $nomeTabela";
    $result = $conn->query($sql);

    $dados = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row;
        }
    }

    // Formatar os nomes das colunas
    if (!empty($dados)) {
        $colunas = array_keys($dados[0]);
        $colunasFormatadas = array_map('formatarNomeColuna', $colunas);
        $dadosFormatados = array_map(function($linha) use ($colunas, $colunasFormatadas) {
            return array_combine($colunasFormatadas, array_values($linha));
        }, $dados);
    }

    echo json_encode($dadosFormatados);
}

// Recebe o nome da tabela via GET ou POST
$nomeTabela = $_GET['tabela'] ?? null;

// Chama a função para exibir a tabela
exibirTabela($conn, $nomeTabela);

// Fecha a conexão
$conn->close();
?>