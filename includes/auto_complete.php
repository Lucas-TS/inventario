<?php
include 'conecta_db.php';

$q = isset($_GET['q']) ? $_GET['q'] : null;
$n = isset($_GET['n']) ? $_GET['n'] : null;
$fp = isset($_GET['fp']) ? $_GET['fp'] : null;
if (isset($_GET['n']) && $_GET['n'] == 'processador')
{
    $sql = "SELECT id, memoria, CONCAT(marca, ' ', modelo) AS lista FROM lista_processador WHERE CONCAT(marca, ' ', modelo) LIKE '%$q%' LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'op')
{
    $sql = "SELECT militares.id, CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) AS lista FROM militares LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id WHERE CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) LIKE '%$q%' LIMIT 5";
}
if (isset($_GET['fp']))
{
    $sql = "SELECT * FROM lista_processador WHERE CONCAT(marca, ' ', modelo) = '$fp'";
    $result = $conn->query($sql);
    $dados = array();
    if ($result->num_rows > 0) {
        $dados = $result->fetch_assoc();
    }
    echo json_encode($dados);
    $conn->close();
    exit;
}
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    $i = "0";
    while($row = $result->fetch_assoc())
    {
        if ($n == 'processador')
        {
            $memoria = $row['memoria'];
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ", " . $n . ", " . $row['id'] . '); suggestionsMem(\'' . $memoria . '\'); fichaProcessador(\'' . $row['lista'] . '\');">' . $row['lista'] . "</p>";
        }
        else
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ", " . $n . ", " . $row['id'] . ')">' . $row['lista'] . "</p>";
        }
        $i++;
    }
}
else
{
    echo "Nenhuma sugestão encontrada";
}
$conn->close();
?>