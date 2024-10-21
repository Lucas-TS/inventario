<?php
include 'conecta_db.php';

// Array de substituição para os nomes das colunas
$substituicoes = [
    'id' => 'ID',
    'geracao' => 'Geração',
    'pcores' => 'P-Cores',
    'ecores' => 'E-Cores',
    'igpu' => 'iGPU',
    'memoria' => 'Memória',
    'gpu' => 'GPU',
    'dev' => 'Desenvolvedor',
    'versao' => 'Versão',
    'edicao' => 'Edição',
    'distribuicao' => 'Distribuição',
    'pg' => 'Posto/Grad',
    'secao' => 'Seção',
    'nome_completo' => 'Nome Completo',
    'fullname' => 'Nome Completo',
    'username' => 'Usuário',
    'email' => 'E-mail',
    'nome_guerra' => 'Nome de Guerra',
    'dp' => 'DP',
    'hdmi' => 'HDMI',
    'vga' => 'VGA',
    'dvi' => 'DVI',
    'usb' => 'USB',
    'resolucao' => 'Resolução',
    'data_inclusao' => 'Inclusão',
    'data_atualizacao' => 'Atualizado',
    'situacao' => 'Situação',
    'ip' => 'IP',
    'mac' => 'MAC',
    'tamanho_tela' => 'Tamanho da Tela'
    // Adicione mais substituições conforme necessário
];

// Função para formatar os nomes das colunas
function formatarNomeColuna($nome) {
    global $substituicoes;
    if (array_key_exists($nome, $substituicoes)) {
        return $substituicoes[$nome];
    } else {
        return ucfirst($nome);
    }
}

// Função para exibir dados da tabela
function exibirTabela($conn, $nomeTabela) {
    if ($nomeTabela == 'militares')
    {
        $sql = "SELECT militares.ativo, militares.id, militares.nome_completo,pg.abreviatura AS pg, militares.nome_guerra, secao.sigla AS secao  FROM $nomeTabela AS militares LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id";
    }
    elseif ($nomeTabela == 'users')
    {
        $sql = "SELECT ativo, id, username, fullname, email, grupo FROM $nomeTabela";
    }
    elseif ($nomeTabela == 'computadores')
    {
        $sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao, CONCAT(pg.abreviatura,' ',militares.nome_guerra) AS operador, computadores.lacre, computadores.marca, computadores.modelo, computadores.garantia, CONCAT(computadores.tam_mem, 'GB ',computadores.tipo_mem) AS memoria, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao FROM $nomeTabela
        LEFT JOIN militares ON computadores.id_operador=militares.id
        LEFT JOIN secao ON militares.id_secao=secao.id
        LEFT JOIN pg ON militares.id_pg=pg.id ";
    }
    else
    {
        $sql = "SELECT * FROM $nomeTabela";
    }
    $result = $conn->query($sql);

    $dados = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row;
        }
    }

    // Formatar os nomes das colunas
    if (!empty($dados)) {
        $colunas = array_keys($dados[0]);
        $colunasFormatadas = array_map('formatarNomeColuna', $colunas);
        $dadosFormatados = array_map(function($linha) use ($colunas, $colunasFormatadas) {
            return array_combine($colunasFormatadas, array_values($linha));
        }, $dados);
    }

    echo json_encode($dadosFormatados);
}

// Recebe o nome da tabela via GET ou POST
$nomeTabela = $_GET['tabela'] ?? null;

// Chama a função para exibir a tabela
exibirTabela($conn, $nomeTabela);

// Fecha a conexão
$conn->close();
?>