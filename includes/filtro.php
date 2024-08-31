<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pagina = $_POST['url'];
    $params = [
        'busca' => $_POST['busca'],
        'op' => $_POST['op'],
        'ip' => $_POST['ip'],
        'hn' => $_POST['hn'],
        'mac' => $_POST['mac'],
        'qtde' => $_POST['qtde'],
        'secao' => isset($_POST['secao']) ? implode(',', $_POST['secao']) : '',
        'situacao' => isset($_POST['situacao']) ? implode(',', $_POST['situacao']) : '',
        'ordem' => $_POST['ordem'],
        'por' => $_POST['por'],
    ];

    // Lógica para o parâmetro "ativo"
    if (isset($_POST['ativo']) && !isset($_POST['inativo'])) {
        $params['ativo'] = '1';
    } elseif (!isset($_POST['ativo']) && isset($_POST['inativo'])) {
        $params['ativo'] = '0';
    } elseif (isset($_POST['ativo']) && isset($_POST['inativo'])) {
        $params['ativo'] = '2';
    }

    // Remove parâmetros vazios
    $filtered_params = array_filter($params, function ($value) {
        return $value !== '' && $value !== null;
    });

    $get = http_build_query($filtered_params);
    header('Location: ../' . $pagina . ($get ? '?' . $get : ''));
}
?>