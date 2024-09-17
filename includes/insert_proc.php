<?php
include 'conecta_db.php';

$marca = isset($_POST["marca"]) ? $_POST["marca"] : null; //Campo VARCHAR (marca)
$modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : null; //Campo VARCHAR (modelo)
$geracao = isset($_POST["geracao"]) ? $_POST["geracao"] : null; //Campo INT (geracao)
$socket = isset($_POST["socket"]) ? $_POST["socket"] : null; //Campo VARCHAR (socket)
$seguimento = isset($_POST["seguimento"]) ? $_POST["seguimento"] : null; //Campo VARCHAR (seguimento)
$pcores = isset($_POST['pcores']) ? $_POST['pcores'] : null; //Campo INT (pcores)
$ecores = isset($_POST['ecores']) ? $_POST['ecores'] : null; //Campo INT (ecores)
$threads = isset($_POST['threads']) ? $_POST['threads'] : null; //Campo INT (threads)
$clock = isset($_POST['clock']) ? $_POST['clock'] : null; //Campo VARCHAR (clock)
$turbo = isset($_POST['turbo']) ? $_POST['turbo'] : null;  //Campo VARCHAR (turbo)
$memoria = isset($_POST['memoria']) ? $_POST['memoria'] : null; //Campo VARCHAR (memoria)
$igpu = isset($_POST['igpu']) ? $_POST['igpu'] : null; //Campo VARCHAR (igpu)
$ativo = 1; //Campo INT (ativo)

// Capturar os dados do formulário
$marca = isset($_POST["marca"]) ? $_POST["marca"] : null; // Campo VARCHAR (marca)
$modelo = isset($_POST["modelo"]) ? $_POST["modelo"] : null; // Campo VARCHAR (modelo)
$geracao = isset($_POST["geracao"]) ? $_POST["geracao"] : null; // Campo INT (geracao)
$socket = isset($_POST["socket"]) ? $_POST["socket"] : null; // Campo VARCHAR (socket)
$seguimento = isset($_POST["seguimento"]) ? $_POST["seguimento"] : null; // Campo VARCHAR (seguimento)
$pcores = isset($_POST['pcores']) ? $_POST['pcores'] : null; // Campo INT (pcores)
$ecores = isset($_POST['ecores']) ? $_POST['ecores'] : null; // Campo INT (ecores)
$threads = isset($_POST['threads']) ? $_POST['threads'] : null; // Campo INT (threads)
$clock = isset($_POST['clock']) ? $_POST['clock'] : null; // Campo VARCHAR (clock)
$turbo = isset($_POST['turbo']) ? $_POST['turbo'] : null; // Campo VARCHAR (turbo)
$memoria = isset($_POST['memoria']) ? $_POST['memoria'] : null; // Campo VARCHAR (memoria)
$igpu = isset($_POST['igpu']) ? $_POST['igpu'] : null; // Campo VARCHAR (igpu)
$ativo = 1; // Campo INT (ativo)

try {
    // Preparar a consulta SQL
    $stmt = $pdo->prepare('INSERT INTO lista_processador (marca, modelo, geracao, socket, seguimento, pcores, ecores, threads, clock, turbo, memoria, igpu, ativo) VALUES (:marca, :modelo, :geracao, :socket, :seguimento, :pcores, :ecores, :threads, :clock, :turbo, :memoria, :igpu, :ativo)');
    
    // Executar a consulta com os dados capturados
    $stmt->execute([
        ':marca' => $marca,
        ':modelo' => $modelo,
        ':geracao' => $geracao,
        ':socket' => $socket,
        ':seguimento' => $seguimento,
        ':pcores' => $pcores,
        ':ecores' => $ecores,
        ':threads' => $threads,
        ':clock' => $clock,
        ':turbo' => $turbo,
        ':memoria' => $memoria,
        ':igpu' => $igpu,
        ':ativo' => $ativo
    ]);

    echo "Dados inseridos com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

?>