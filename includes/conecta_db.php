<?php
// Configurações de conexão com o banco de dados
$servername = "127.0.0.1";
$username = "inventario";
$password = "3s@o24";
$dbname = "inventario";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se a tabela existe
if (isset($_POST['funcao']) && $_POST['funcao'] === 'teste' && isset($_POST['tabela'])) {
    $nomeTabela = $_POST['tabela'];
    $sql = "SHOW TABLES LIKE '$nomeTabela'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
    $conn->close();
    exit;
}