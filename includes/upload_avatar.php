<?php
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $dataURL = $data['dataURL'];
    $fileName = $data['fileName'];
    $dir = '../images/avatares/';

    // Decodifica o dataURL para binário
    list($type, $dataURL) = explode(';', $dataURL);
    list(, $dataURL) = explode(',', $dataURL);
    $dataURL = base64_decode($dataURL);

    // Salva o arquivo
    file_put_contents($dir . $fileName, $dataURL);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>