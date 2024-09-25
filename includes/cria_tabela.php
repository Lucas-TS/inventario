<?php
include 'conecta_db.php';

// Array de mapeamento para substituição dos nomes das colunas
$colunaMapeamento = [
    'id' => 'ID',
    'igpu' => 'iGPU',
    'geracao' => 'Geração',
    'pcores' => 'P-Cores',
    'ecores' => 'E-Cores'
];

// Função para formatar o nome da coluna
function formatarNomeColuna($nomeColuna, $mapeamento) {
    if (array_key_exists($nomeColuna, $mapeamento)) {
        return $mapeamento[$nomeColuna];
    } else {
        return ucfirst($nomeColuna);
    }
}

// Função para exibir dados da tabela com paginação
function exibirTabela($conn, $nomeTabela, $pagina, $limite, $mapeamento) {
    $offset = ($pagina - 1) * $limite;
    $sql = "SELECT * FROM $nomeTabela LIMIT $limite OFFSET $offset";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='tabela-lista'><tr>";

        // Exibe os cabeçalhos das colunas
        $fieldinfoArray = [];
        while ($fieldinfo = $result->fetch_field()) {
            $nomeFormatado = formatarNomeColuna($fieldinfo->name, $mapeamento);
            echo "<th>" . $nomeFormatado . "</th>";
            $fieldinfoArray[] = $fieldinfo->name;
        }
        echo "</tr>";

        // Adiciona inputs de filtro
        echo "<tr>";
        foreach ($fieldinfoArray as $fieldname) {
            echo "<th><input class='input busca' type='text' onkeyup='filtrarTabela()'></th>";
        }
        echo "</tr>";

        // Exibe os dados das linhas
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo '<div id="resultados"><label for="limite">Resultados por página:</label>';
        echo '<select id="limite" name="limite" onchange="carregarTabela(\'' . $nomeTabela . '\', 1, this.value)">';
        echo '<option value="2"' . ($limite == 2 ? ' selected' : '') . '>2</option>';
        echo '<option value="5"' . ($limite == 5 ? ' selected' : '') . '>5</option>';
        echo '<option value="10"' . ($limite == 10 ? ' selected' : '') . '>10</option>';
        echo '<option value="20"' . ($limite == 20 ? ' selected' : '') . '>20</option>';
        echo '</select></div>';

        // Paginação
        $sqlTotal = "SELECT COUNT(*) as total FROM $nomeTabela";
        $resultTotal = $conn->query($sqlTotal);
        $total = $resultTotal->fetch_assoc()['total'];
        $totalPaginas = ceil($total / $limite);

        echo "<div id='paginacao'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "<a href='#' onclick='carregarTabela(\"$nomeTabela\", $i, $limite)'>$i</a> ";
        }
        echo "</div>";
    } else {
        echo "0 resultados";
    }
}

// Recebe o nome da tabela, a página e o limite via GET
$nomeTabela = $_GET['tabela'] ?? 'nome_da_tabela_padrao';
$pagina = $_GET['pagina'] ?? 1;
$limite = $_GET['limite'] ?? 2; // Número de registros por página

// Chama a função para exibir a tabela
exibirTabela($conn, $nomeTabela, $pagina, $limite, $colunaMapeamento);

// Fecha a conexão
$conn->close();
?>
