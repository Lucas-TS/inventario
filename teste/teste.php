<?php
echo 'OP = ' . $_GET['op'] . ' | ID: ' . $_GET['hidden-op'];
echo "<br>";
echo 'PROC = ' . $_GET['processador'] . ' | ID ' . $_GET['hidden-processador'];
echo "<br>";
echo 'MEM = ' . $_GET['qtde-mem'] . " GB - " . $_GET['tipo-mem'];
echo "<br>";

$dsk = 1;

while (true) {
    $tipoDsk = isset($_GET["tipo-dsk-$dsk"]) ? $_GET["tipo-dsk-$dsk"] : null;
    if (!$tipoDsk) break; // Sai do loop se não houver mais parâmetros

    if ($tipoDsk === 'HD') {
        $tamHd = isset($_GET["tam-hd-$dsk"]) ? $_GET["tam-hd-$dsk"] : null;
        $tipoHd = isset($_GET["tipo-hd-$dsk"]) ? $_GET["tipo-hd-$dsk"] : null;
        $saudeHd = isset($_GET["saude-hd-$dsk"]) ? $_GET["saude-hd-$dsk"] : null;
        $hiddenHd = isset($_GET["hidden-tam-hd-$dsk"]) ? $_GET["hidden-tam-hd-$dsk"] : null;
        echo "HD $dsk: Tamanho: $tamHd | Tipo: $tipoHd | Saúde: $saudeHd% | ID: $hiddenHd<br>";
    } elseif ($tipoDsk === 'SSD') {
        $tamSsd = isset($_GET["tam-ssd-$dsk"]) ? $_GET["tam-ssd-$dsk"] : null;
        $tipoSsd = isset($_GET["tipo-ssd-$dsk"]) ? $_GET["tipo-ssd-$dsk"] : null;
        $saudeSsd = isset($_GET["saude-ssd-$dsk"]) ? $_GET["saude-ssd-$dsk"] : null;
        $hiddenSsd = isset($_GET["hidden-tam-ssd-$dsk"]) ? $_GET["hidden-tam-ssd-$dsk"] : null;
        echo "SSD $dsk: Tamanho: $tamSsd | Tipo: $tipoSsd | Saúde: $saudeSsd% | ID: $hiddenSsd<br>";
    }

    $dsk++; // Incrementa o índice para o próximo conjunto de parâmetros
}

$mon = 1;

while (true) {
    $idMonitor = isset($_GET["hidden-modelo-monitor-$mon"]) ? $_GET["hidden-modelo-monitor-$mon"] : null;
    if (!$idMonitor) break; // Sai do loop se não houver mais parâmetros
    $marcaMon = isset($_GET["marca-monitor-$mon"]) ? $_GET["marca-monitor-$mon"] : null;
    $modeloMon = isset($_GET["modelo-monitor-$mon"]) ? $_GET["modelo-monitor-$mon"] : null;
    $conMon = isset($_GET["con-monitor-$mon"]) ? $_GET["con-monitor-$mon"] : null;
    echo "Monitor $mon: Marca: $marcaMon | Modelo: $modeloMon | Conexão: $conMon | ID: $idMonitor<br>";
    $mon++; // Incrementa o índice para o próximo conjunto de parâmetros
}


if (isset($_GET['so']) && $_GET['so'] == "Windows") {
    echo 'SO = ' . $_GET['so'] . " " . $_GET['ver-so'] . " " . $_GET['ed-so'] . " " . $_GET['arq-so'] . " | Serial: " . $_GET['serial-so'] . " | Usuário: " . $_GET['user-so'] . " | Senha: " . $_GET['pw-so'] . " | ID:" . $_GET['hidden-so'] . "<br>";
}
if (isset($_GET['so']) && $_GET['so'] == "Linux") {
    echo 'SO = ' . $_GET['so'] . " " . $_GET['distro-so'] . " " . $_GET['ver-so'] . " " . $_GET['if-so'] . " " . $_GET['arq-so'] . " | Usuário:" . $_GET['user-so'] . " | Senha:" . $_GET['pw-so'] . " | ID:" . $_GET['hidden-so'] . "<br>";
}

if (isset($_GET['office']) && $_GET['office'] == "Office") {
    echo 'Office = Microsoft Office ' . $_GET['ver-office'] . " " . $_GET['ed-office'] . " | Serial: " . $_GET['serial-office'] . " | ID:" . $_GET['hidden-office'] . "<br>";
}
if (isset($_GET['office']) && $_GET['office'] == "Free") {
    echo 'Office = ' . $_GET['nome-office'] . " " . $_GET['ver-office'] . " | ID:" . $_GET['hidden-office'] . "<br>";
}

if (isset($_GET['av']) && $_GET['av'] == "1") {
    echo 'Antivirus = Sim | ID: ' . $_GET['av'] . "<br>";
}
if (isset($_GET['av']) && $_GET['av'] == "0") {
    echo 'Antivirus = Não | ID: ' . $_GET['av'] . "<br>";
}
?>