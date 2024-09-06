<?php
include 'conecta_db.php';

$q = isset($_GET['q']) ? $_GET['q'] : null;
$n = isset($_GET['n']) ? $_GET['n'] : null;
$mm = isset($_GET['mm']) ? $_GET['mm'] : null;
$fp = isset($_GET['fp']) ? $_GET['fp'] : null;
$fm = isset($_GET['fm']) ? $_GET['fm'] : null;
if (isset($_GET['n']) && $_GET['n'] == 'processador')
{
    $sql = "SELECT id, memoria, CONCAT(marca, ' ', modelo) AS lista FROM lista_processador WHERE CONCAT(marca, ' ', modelo) LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'op')
{
    $sql = "SELECT militares.id, CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) AS lista FROM militares LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id WHERE CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'ver-win' || $_GET['n'] == 'distro-linux')
{
    if ($mm == "Windows") {
        $sql = "SELECT DISTINCT versao AS lista FROM lista_so WHERE versao LIKE '%$q%' AND nome LIKE '$mm' ORDER BY lista ASC LIMIT 5";
    }
    if ($mm == "Linux") {
        $sql = "SELECT DISTINCT distribuicao AS lista FROM lista_so WHERE distribuicao LIKE '%$q%' AND nome LIKE '$mm' ORDER BY lista ASC LIMIT 5";
    }
}
if (isset($_GET['n']) && $_GET['n'] == 'ed-win' || $_GET['n'] == 'ver-linux')
{
    if (str_contains($mm, 'Windows ')) {
        $sql = "SELECT DISTINCT edicao AS lista FROM lista_so WHERE edicao LIKE '%$q%' AND CONCAT(nome, ' ', versao) LIKE '$mm' ORDER BY lista ASC LIMIT 5";
    }
    if (str_contains($mm, 'Linux ')) {
        $sql = "SELECT DISTINCT versao AS lista FROM lista_so WHERE versao LIKE '%$q%' AND CONCAT(nome, ' ', distribuicao) LIKE '$mm' ORDER BY lista ASC LIMIT 5";
    }
}

if (isset($_GET['n']) && strpos($n, 'marca-monitor-') !== false) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, marca AS lista FROM lista_monitor WHERE marca LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && strpos($n, 'modelo-monitor-') !== false) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, marca, modelo AS lista FROM lista_monitor WHERE marca LIKE '$mm' AND modelo LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
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
if (isset($_GET['fm']))
{
    $sql = "SELECT * FROM lista_monitor WHERE CONCAT(marca, ' ', modelo) = '$fm'";
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
        elseif (strpos($n, 'marca-monitor-') !== false)
        {
            echo '<p id="p' . $i . '" class="optMarca" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . $row['id'] . '); mostrarModelo(' . $id_campo . ');">' . $row['lista'] . "</p>";
        }
        elseif (strpos($n, 'modelo-monitor-') !== false)
        {
            echo '<p id="p' . $i . '" class="optMarca" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . $row['id'] . '); fichaMonitor(\'' . $row['marca'] . ' ' . $row['lista'] . '\',' . $id_campo . ');">' . $row['lista'] . "</p>";
        }
        elseif ($n == 'ver-win' || $n == 'distro-linux')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); mostrarCampo2(\'' . $mm . ' ' . $row['lista'] . '\')">' . $row['lista'] . "</p>";
        }
        elseif ($n == 'ed-win' || $n == 'ver-linux')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); mostrarCampo2(\'' . $mm . ' ' . $row['lista'] . '\',)">' . $row['lista'] . "</p>";
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
    echo "<p>Nenhuma sugestão encontrada</p>";
}
$conn->close();
?>