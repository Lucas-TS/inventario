<?php
include '../includes/conecta_db.php';

// Número de registros que você quer retornar
$limite = 10;

// Consulta SQL para obter os processadores mais usados
// A consulta conta quantas vezes cada processador foi associado a computadores
$sql = "
  SELECT 
    lp.marca,
    lp.modelo,
    COUNT(ap.id_processador) AS quantidade
  FROM assoc_processador ap
  INNER JOIN lista_processador lp ON ap.id_processador = lp.id
  INNER JOIN computadores c ON ap.id_pc = c.id
  WHERE c.ativo = 1
  GROUP BY lp.id, lp.marca, lp.modelo
  ORDER BY quantidade DESC
  LIMIT ?
";

// Prepara e executa a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $limite);
$stmt->execute();

// Obtém o resultado
$resultado = $stmt->get_result();

// Formata as colunas
$colunas = ['Marca', 'Modelo', 'Quantidade'];
$linhas = [];

// Verifica se há resultados e formata cada linha
if ($resultado && $resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $linhas[] = [
            $linha['marca'],
            $linha['modelo'],
            $linha['quantidade']
        ];
    }
}

$retorno = [
    'tipo' => 'tabela',
    'titulo' => 'Processadores em uso',
    'colunas' => $colunas,
    'linhas' => $linhas,
    'nome_tabela' => 'lista_processador'
];

header('Content-Type: application/json');
echo json_encode($retorno);
?>
