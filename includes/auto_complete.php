<?php
include 'conecta_db.php';

$q = isset($_GET['q']) ? $_GET['q'] : null;
$n = isset($_GET['n']) ? $_GET['n'] : null;
$mm = isset($_GET['mm']) ? $_GET['mm'] : null;
$fp = isset($_GET['fp']) ? $_GET['fp'] : null;
$fm = isset($_GET['fm']) ? $_GET['fm'] : null;
$so = isset($_GET['so']) ? $_GET['so'] : null;

// SQL para processador
if (isset($_GET['n']) && $_GET['n'] == 'processador-desktop')
{
    $sql = "SELECT id, memoria, CONCAT(marca, ' ', modelo) AS lista FROM lista_processador WHERE seguimento LIKE 'Desktop' AND ativo = '1' AND CONCAT(marca, ' ', modelo) LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
}

// SQL para operador
if (isset($_GET['n']) && $_GET['n'] == 'op')
{
    $sql = "SELECT militares.id, CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) AS lista FROM militares LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id WHERE CONCAT(pg.abreviatura, ' ', militares.nome_guerra, ' - ', secao.sigla) LIKE '%$q%' AND militares.ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para placa de vídeo
if (isset($_GET['n']) && $_GET['n'] == 'gpu-pv')
{
    $sql = "SELECT DISTINCT gpu AS lista FROM lista_placa_video WHERE gpu LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'marca-pv')
{
    $sql = "SELECT DISTINCT marca AS lista FROM lista_placa_video WHERE marca LIKE '%$q%' AND gpu LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'modelo-pv')
{
    $sql = "SELECT DISTINCT modelo AS lista FROM lista_placa_video WHERE modelo LIKE '%$q%' AND CONCAT(gpu, ' ', marca) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && $_GET['n'] == 'mem-pv')
{
    $sql = "SELECT id, memoria AS lista FROM lista_placa_video WHERE memoria LIKE '%$q%' AND CONCAT(gpu, ' ', marca, ' ', modelo) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para sistema operacional
if (isset($_GET['n']) && ($_GET['n'] == 'ver-win' || $_GET['n'] == 'distro-linux'))
{
    if ($mm == "Windows") {
        $sql = "SELECT DISTINCT versao AS lista FROM lista_so WHERE versao LIKE '%$q%' AND nome LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
    if ($mm == "Linux") {
        $sql = "SELECT DISTINCT distribuicao AS lista FROM lista_so WHERE distribuicao LIKE '%$q%' AND nome LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
}
if (isset($_GET['n']) && ($_GET['n'] == 'ed-win' || $_GET['n'] == 'ver-linux'))
{
    if (str_contains($mm, 'Windows ')) {
        $sql = "SELECT DISTINCT edicao AS lista FROM lista_so WHERE edicao LIKE '%$q%' AND CONCAT(nome, ' ', versao) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
    if (str_contains($mm, 'Linux ')) {
        $sql = "SELECT DISTINCT versao AS lista FROM lista_so WHERE versao LIKE '%$q%' AND CONCAT(nome, ' ', distribuicao) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
}
if (isset($_GET['n']) && $_GET['n'] == 'if-linux')
{
    if (str_contains($mm, 'Linux ')) {
        $sql = "SELECT DISTINCT edicao AS lista FROM lista_so WHERE edicao LIKE '%$q%' AND CONCAT(nome, ' ', distribuicao, ' ', versao) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
}
if (isset($_GET['so']))
{
    if (strpos($so, "Windows ") === 0)
    {
        $sql = "SELECT id, arquitetura FROM lista_so WHERE CONCAT(nome, ' ', versao, ' ', edicao) = '$so' AND ativo = '1'";
    }
    elseif (strpos($so, "Linux ") === 0)
    {
        $sql = "SELECT id, arquitetura FROM lista_so WHERE CONCAT(nome, ' ', distribuicao, ' ', versao, ' ', edicao) = '$so' AND ativo = '1'";
    }
    $result = $conn->query($sql);
    $dados = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dados[$row['arquitetura']] = $row['id'];
        }
    }
    echo json_encode($dados);
    $conn->close();
    exit;
}

// SQL para office
if (isset($_GET['n']) && ($_GET['n'] == 'nome-free' || $_GET['n'] == 'ver-ms'))
{
    if ($mm == 'Office') {
        $sql = "SELECT DISTINCT versao AS lista FROM lista_office WHERE versao LIKE '%$q%' AND nome LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
    if ($mm == 'Free') {
        $sql = "SELECT DISTINCT nome AS lista FROM lista_office WHERE nome LIKE '%$q%' AND nome NOT LIKE 'Office' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
}
if (isset($_GET['n']) && ($_GET['n'] == 'ver-free' || $_GET['n'] == 'ed-ms'))
{
    if (strpos($mm, 'Office ') === 0) {
        $sql = "SELECT id, edicao AS lista FROM lista_office WHERE edicao LIKE '%$q%' AND CONCAT(nome, ' ', versao) LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    } else {
        $sql = "SELECT id, versao AS lista FROM lista_office WHERE versao LIKE '%$q%' AND nome LIKE '$mm' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
    }
}

// SQL para HD
if (isset($_GET['n']) && strpos($n, 'tam-hd-') === 0) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, tamanho AS lista FROM lista_hd WHERE tamanho LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para SSD
if (isset($_GET['n']) && strpos($n, 'tam-ssd-') === 0) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, tamanho AS lista FROM lista_ssd WHERE tamanho LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para monitor
if (isset($_GET['n']) && strpos($n, 'marca-monitor-') === 0) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, marca AS lista FROM lista_monitor WHERE marca LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}
if (isset($_GET['n']) && strpos($n, 'modelo-monitor-') === 0) {
    preg_match_all('!\d+!', $n, $a);
    $id_campo = $a[0][0];
    $sql = "SELECT DISTINCT id, marca, modelo AS lista FROM lista_monitor WHERE marca LIKE '$mm' AND modelo LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para ficha do processador
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

// SQL para ficha do monitor
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

// SQL para iGPU add processador
if (isset($_GET['n']) && $_GET['n'] == 'modelo-igpu-proc')
{
    $sql = "SELECT DISTINCT igpu AS lista FROM lista_processador WHERE igpu LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para socket add processador
if (isset($_GET['n']) && $_GET['n'] == 'skt-proc')
{
    $sql = "SELECT DISTINCT socket AS lista FROM lista_processador WHERE socket LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para chipset add placa de vídeo
if (isset($_GET['n']) && $_GET['n'] == 'chipset-add-pv')
{
    $sql = "SELECT DISTINCT gpu AS lista FROM lista_placa_video WHERE gpu LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para marca add placa de vídeo
if (isset($_GET['n']) && $_GET['n'] == 'marca-add-pv')
{
    $sql = "SELECT DISTINCT marca AS lista FROM lista_placa_video WHERE marca LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// SQL para modelo add placa de vídeo
if (isset($_GET['n']) && $_GET['n'] == 'modelo-add-pv')
{
    $sql = "SELECT DISTINCT modelo AS lista FROM lista_placa_video WHERE modelo LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

if (isset($_GET['n']) && $_GET['n'] == 'pg-add-mil')
{
    $sql = "SELECT id, CONCAT(abreviatura, ' - ', pg) AS lista FROM pg WHERE CONCAT(abreviatura, ' - ', pg) LIKE '%$q%' ORDER BY lista ASC LIMIT 5";
}

if (isset($_GET['n']) && $_GET['n'] == 'sec-add-mil')
{
    $sql = "SELECT id, CONCAT(sigla, ' - ', nome) AS lista FROM secao WHERE CONCAT(sigla, ' - ', nome) LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

if (isset($_GET['n']) && $_GET['n'] == 'marca-add-mon')
{
    $sql = "SELECT DISTINCT marca AS lista FROM lista_monitor WHERE marca LIKE '%$q%' AND ativo = '1' ORDER BY lista ASC LIMIT 5";
}

// Execução do SQL
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    $i = "0";
    //Abertura do loop de sugestões
    while($row = $result->fetch_assoc())
    {
        //Sugestões para processador
        if ($n == 'processador-desktop')
        {
            $memoria = $row['memoria'];
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ',\'' . $n . '\',' . $row['id'] . '); suggestionsMem(\'' . $memoria . '\'); fichaProcessador(\'' . $row['lista'] . '\');">' . $row['lista'] . "</p>";
        }

        //Sugestões para marca do monitor
        elseif (strpos($n, 'marca-monitor-') !== false)
        {
            echo '<p id="p' . $i . '" class="optMarca" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . $row['id'] . '); mostrarModelo(' . $id_campo . ');">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para modelo do monitor
        elseif (strpos($n, 'modelo-monitor-') !== false)
        {
            echo '<p id="p' . $i . '" class="optMarca" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . $row['id'] . '); fichaMonitor(\'' . $row['marca'] . ' ' . $row['lista'] . '\',' . $id_campo . ');">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para versão do Windows ou distrubuição do Linux
        elseif ($n == 'ver-win' || $n == 'distro-linux')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); mostrarCampo2(\'' . $mm . ' ' . $row['lista'] . '\')">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para versão do Linux
        elseif ($n == 'ver-linux')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); mostrarCampo3(\'' . $mm . ' ' . $row['lista'] . '\',)">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para edição do Windows
        elseif ($n == 'if-linux' || $n == 'ed-win')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); mostrarArq(\'' . $row['lista'] . '\')">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para nome do office gratuito ou para versão do Office
        elseif ($n == 'nome-free' || $n == 'ver-ms')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); liberarCampo2(\'' . $mm . '\')">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para versão do office gratuito ou para edição do Office
        elseif ($n == 'ver-free' || $n == 'ed-ms')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); passarIdOffice(\'' . $row['id'] . '\')">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para chipset da placa de video
        elseif ($n == 'gpu-pv')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); liberarCampo2Pv()">' . $row['lista'] . "</p>";
        }
        
        //Sugestões para marca da placa de video
        elseif ($n == 'marca-pv')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); liberarCampo3Pv()">' . $row['lista'] . "</p>";
        }

        //Sugestões para marca da placa de video
        elseif ($n == 'modelo-pv')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . '); liberarCampo4Pv()">' . $row['lista'] . "</p>";
        }

        //Sugestões para marca da iGPU
        elseif ($n == 'modelo-igpu-proc' || $n == 'skt-proc' || $n == 'marca-add-pv' || $n == 'modelo-add-pv' || $n == 'chipset-add-pv' || $n == 'marca-add-mon')
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i . ', \'' . $n . '\', ' . '\'\'' . ')">' . $row['lista'] . "</p>";
        }

        //Sugestões para outros
        else
        {
            echo '<p id="p' . $i . '" onclick="passarValor(' . $i. ', \'' . $n . '\', ' . $row['id'] . ')">' . $row['lista'] . "</p>";
        }
        $i++;
    }
}
else
{
    //Mensagem quando a consulta for vazia
    echo "<p>Nenhuma sugestão encontrada</p>";
}
$conn->close();
?>