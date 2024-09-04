<?php
echo 'OP = ' . $_GET['hidden-op'];
echo "<br>";
echo 'PROC = ' . $_GET['hidden-processador'];
echo "<br>";
echo 'MEM = ' . $_GET['qtde-mem'] . " " . $_GET['tipo-mem'];
echo "<br>";

$n = 1;

while (true) {
    $tipoDsk = isset($_GET["tipo-dsk-$n"]) ? $_GET["tipo-dsk-$n"] : null;
    if (!$tipoDsk) break; // Sai do loop se não houver mais parâmetros

    if ($tipoDsk === 'HD') {
        $tamHd = isset($_GET["tam-hd-$n"]) ? $_GET["tam-hd-$n"] : null;
        $tipoHd = isset($_GET["tipo-hd-$n"]) ? $_GET["tipo-hd-$n"] : null;
        $saudeHd = isset($_GET["saude-hd-$n"]) ? $_GET["saude-hd-$n"] : null;
        echo "HD $n: Tamanho - $tamHd, Tipo - $tipoHd, Saúde - $saudeHd<br>";
    } elseif ($tipoDsk === 'SSD') {
        $tamSsd = isset($_GET["tam-ssd-$n"]) ? $_GET["tam-ssd-$n"] : null;
        $tipoSsd = isset($_GET["tipo-ssd-$n"]) ? $_GET["tipo-ssd-$n"] : null;
        $saudeSsd = isset($_GET["saude-ssd-$n"]) ? $_GET["saude-ssd-$n"] : null;
        echo "SSD $n: Tamanho - $tamSsd, Tipo - $tipoSsd, Saúde - $saudeSsd<br>";
    }

    $n++; // Incrementa o índice para o próximo conjunto de parâmetros
}
?>