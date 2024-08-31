<?php
// Configurações de conexão com o banco de dados
$servername = "127.0.0.1";
$username = "inventario";
$password = "t3rr4d3n1ngu3m";
$dbname = "inventario";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}