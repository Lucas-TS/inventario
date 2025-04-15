<?php
// Verifica se há dados no array $_POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Faz um loop através dos dados do POST e imprime cada chave e valor
    foreach ($_POST as $key => $value) {
        echo 'Chave: ' . htmlspecialchars($key) . ' - Valor: ' . htmlspecialchars($value) . '<br>';
    }
} else {
    echo 'Não há dados recebidos via POST.';
}
?>
