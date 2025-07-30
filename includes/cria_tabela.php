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
    'mac_wifi' => 'MAC Wi-Fi',
    'rede' => 'Rede',
    'wifi' => 'Wi-Fi',
    'tamanho_tela' => 'Tela'
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
function exibirTabela($conn, $nomeTabela, $tipo) {
    if ($nomeTabela == 'militares')
    {
        $sql = "SELECT militares.ativo, militares.id, militares.nome_completo,pg.abreviatura AS pg, militares.nome_guerra, secao.sigla AS secao  FROM $nomeTabela AS militares LEFT JOIN pg ON militares.id_pg = pg.id LEFT JOIN secao ON militares.id_secao = secao.id";
    }
    elseif ($nomeTabela == 'users')
    {
        $sql = "SELECT ativo, id, username, fullname, email, grupo FROM $nomeTabela";
    }
    elseif ($nomeTabela == 'computadores' && $tipo == '0')
    {
        /*$sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao, CONCAT(pg.abreviatura,' ',militares.nome_guerra) AS operador, computadores.lacre, computadores.marca, computadores.modelo, computadores.garantia, CONCAT(computadores.tam_mem, 'GB ',computadores.tipo_mem) AS memoria, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao FROM $nomeTabela
        LEFT JOIN militares ON computadores.id_operador=militares.id
        LEFT JOIN secao ON militares.id_secao=secao.id
        LEFT JOIN pg ON militares.id_pg=pg.id
        WHERE computadores.tipo=0";*/
        
        $sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao,
        CASE WHEN lista_so.dev = 'Microsoft' THEN CONCAT(lista_so.nome, ' ', lista_so.versao, ' ', lista_so.edicao)
        ELSE CONCAT(lista_so.distribuicao, ' ', lista_so.versao)
        END AS SO,
        computadores.marca, computadores.modelo,
        CONCAT(lista_processador.marca, ' ', lista_processador.modelo) AS Processador,
        CONCAT(computadores.tam_mem, 'GB ', computadores.tipo_mem) AS memoria,
        CONCAT(lista_placa_video.gpu) AS GPU,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_ssd.tamanho, assoc_ssd.saude, ROW_NUMBER() OVER (ORDER BY assoc_ssd.id) AS rn FROM assoc_ssd JOIN lista_ssd ON assoc_ssd.id_ssd = lista_ssd.id WHERE assoc_ssd.id_pc = computadores.id) t), '-') AS SSD,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_hd.tamanho, assoc_hd.saude, ROW_NUMBER() OVER (ORDER BY assoc_hd.id) AS rn FROM assoc_hd JOIN lista_hd ON assoc_hd.id_hd = lista_hd.id WHERE assoc_hd.id_pc = computadores.id) t), '-') AS HD,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(marca, ' ', modelo, ' (', conexao, ')') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_monitor.marca, lista_monitor.modelo, assoc_monitor.conexao, ROW_NUMBER() OVER (ORDER BY assoc_monitor.id) AS rn FROM assoc_monitor JOIN lista_monitor ON assoc_monitor.id_monitor = lista_monitor.id WHERE assoc_monitor.id_pc = computadores.id) t), '-') AS Monitor,
        CONCAT(lista_office.nome, ' ', lista_office.versao, ' ', lista_office.edicao) AS Office,
        computadores.antivirus, computadores.rede, computadores.hostname, computadores.rede, computadores.mac, computadores.wifi, computadores.mac_wifi, computadores.ip, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao
        FROM $nomeTabela
        LEFT JOIN secao ON computadores.id_operador=secao.id
        LEFT JOIN assoc_processador ON computadores.id=assoc_processador.id_pc
        LEFT JOIN lista_processador ON assoc_processador.id_processador=lista_processador.id
        LEFT JOIN assoc_placa_video ON computadores.id=assoc_placa_video.id_pc
        LEFT JOIN lista_placa_video ON assoc_placa_video.id_placa_video=lista_placa_video.id
        LEFT JOIN assoc_so ON computadores.id=assoc_so.id_pc
        LEFT JOIN lista_so ON assoc_so.id_so=lista_so.id
        LEFT JOIN assoc_ssd ON computadores.id=assoc_ssd.id_pc
        LEFT JOIN lista_ssd ON assoc_ssd.id_ssd=lista_ssd.id
        LEFT JOIN assoc_hd ON computadores.id=assoc_hd.id_pc
        LEFT JOIN lista_hd ON assoc_hd.id_hd=lista_hd.id
        LEFT JOIN assoc_office ON computadores.id=assoc_office.id_pc
        LEFT JOIN lista_office ON assoc_office.id_office=lista_office.id
        LEFT JOIN assoc_monitor ON computadores.id=assoc_monitor.id_pc
        LEFT JOIN lista_monitor ON assoc_monitor.id_monitor=lista_monitor.id
        WHERE computadores.tipo=0
        GROUP BY computadores.id, secao.sigla, computadores.marca, computadores.modelo, lista_processador.marca, lista_processador.modelo, computadores.tam_mem, computadores.tipo_mem, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao";
    }
    elseif ($nomeTabela == 'computadores' && $tipo == '1')
    {
        /*$sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao, CONCAT(pg.abreviatura,' ',militares.nome_guerra) AS operador, computadores.lacre, computadores.marca, computadores.modelo, computadores.garantia, CONCAT(computadores.tam_mem, 'GB ',computadores.tipo_mem) AS memoria, computadores.tela, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao FROM $nomeTabela
        LEFT JOIN militares ON computadores.id_operador=militares.id
        LEFT JOIN secao ON militares.id_secao=secao.id
        LEFT JOIN pg ON militares.id_pg=pg.id
        WHERE computadores.tipo=1";*/
        $sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao,
        CASE WHEN lista_so.dev = 'Microsoft' THEN CONCAT(lista_so.nome, ' ', lista_so.versao, ' ', lista_so.edicao)
        ELSE CONCAT(lista_so.distribuicao, ' ', lista_so.versao)
        END AS SO,
        computadores.marca, computadores.modelo,
        CONCAT(lista_processador.marca, ' ', lista_processador.modelo) AS Processador,
        CONCAT(computadores.tam_mem, 'GB ', computadores.tipo_mem) AS memoria,
        CONCAT(lista_placa_video.gpu) AS GPU,
        CONCAT(lista_processador.marca, ' ', lista_processador.modelo) AS Processador,
        CONCAT(computadores.tam_mem, 'GB ', computadores.tipo_mem) AS memoria,
        CONCAT(lista_placa_video.gpu) AS GPU,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_ssd.tamanho, assoc_ssd.saude, ROW_NUMBER() OVER (ORDER BY assoc_ssd.id) AS rn FROM assoc_ssd JOIN lista_ssd ON assoc_ssd.id_ssd = lista_ssd.id WHERE assoc_ssd.id_pc = computadores.id) t), '-') AS SSD,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_hd.tamanho, assoc_hd.saude, ROW_NUMBER() OVER (ORDER BY assoc_hd.id) AS rn FROM assoc_hd JOIN lista_hd ON assoc_hd.id_hd = lista_hd.id WHERE assoc_hd.id_pc = computadores.id) t), '-') AS HD,
        CONCAT(computadores.tela, '\"') AS Tela,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(marca, ' ', modelo, ' (', conexao, ')') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_monitor.marca, lista_monitor.modelo, assoc_monitor.conexao, ROW_NUMBER() OVER (ORDER BY assoc_monitor.id) AS rn FROM assoc_monitor JOIN lista_monitor ON assoc_monitor.id_monitor = lista_monitor.id WHERE assoc_monitor.id_pc = computadores.id) t), '-') AS Monitor,
        CONCAT(lista_office.nome, ' ', lista_office.versao, ' ', lista_office.edicao) AS Office,
        computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.wifi, computadores.mac_wifi, computadores.ip, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao
        FROM $nomeTabela
        LEFT JOIN secao ON computadores.id_operador=secao.id
        LEFT JOIN assoc_processador ON computadores.id=assoc_processador.id_pc
        LEFT JOIN lista_processador ON assoc_processador.id_processador=lista_processador.id
        LEFT JOIN assoc_placa_video ON computadores.id=assoc_placa_video.id_pc
        LEFT JOIN lista_placa_video ON assoc_placa_video.id_placa_video=lista_placa_video.id
        LEFT JOIN assoc_so ON computadores.id=assoc_so.id_pc
        LEFT JOIN lista_so ON assoc_so.id_so=lista_so.id
        LEFT JOIN assoc_ssd ON computadores.id=assoc_ssd.id_pc
        LEFT JOIN lista_ssd ON assoc_ssd.id_ssd=lista_ssd.id
        LEFT JOIN assoc_hd ON computadores.id=assoc_hd.id_pc
        LEFT JOIN lista_hd ON assoc_hd.id_hd=lista_hd.id
        LEFT JOIN assoc_office ON computadores.id=assoc_office.id_pc
        LEFT JOIN lista_office ON assoc_office.id_office=lista_office.id
        LEFT JOIN assoc_monitor ON computadores.id=assoc_monitor.id_pc
        LEFT JOIN lista_monitor ON assoc_monitor.id_monitor=lista_monitor.id
        WHERE computadores.tipo=1
        GROUP BY computadores.id, secao.sigla, computadores.marca, computadores.modelo, lista_processador.marca, lista_processador.modelo, computadores.tam_mem, computadores.tipo_mem, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao";
    }
    elseif ($nomeTabela == 'computadores' && $tipo == '2')
    {
        /*$sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao, CONCAT(pg.abreviatura,' ',militares.nome_guerra) AS operador, computadores.lacre, computadores.marca, computadores.modelo, computadores.garantia, CONCAT(computadores.tam_mem, 'GB ',computadores.tipo_mem) AS memoria, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao FROM $nomeTabela
        LEFT JOIN militares ON computadores.id_operador=militares.id
        LEFT JOIN secao ON militares.id_secao=secao.id
        LEFT JOIN pg ON militares.id_pg=pg.id
        WHERE computadores.tipo=2";*/
        $sql = "SELECT computadores.ativo, computadores.id, secao.sigla AS secao,
        CASE WHEN lista_so.dev = 'Microsoft' THEN CONCAT(lista_so.nome, ' ', lista_so.versao, ' ', lista_so.edicao)
        ELSE CONCAT(lista_so.distribuicao, ' ', lista_so.versao)
        END AS SO,
        computadores.marca, computadores.modelo,
        CONCAT(lista_processador.marca, ' ', lista_processador.modelo) AS Processador,
        CONCAT(computadores.tam_mem, 'GB ', computadores.tipo_mem) AS memoria,
        CONCAT(lista_placa_video.gpu) AS GPU,
        CONCAT(lista_processador.marca, ' ', lista_processador.modelo) AS Processador,
        CONCAT(computadores.tam_mem, 'GB ', computadores.tipo_mem) AS memoria,
        CONCAT(lista_placa_video.gpu) AS GPU,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_ssd.tamanho, assoc_ssd.saude, ROW_NUMBER() OVER (ORDER BY assoc_ssd.id) AS rn FROM assoc_ssd JOIN lista_ssd ON assoc_ssd.id_ssd = lista_ssd.id WHERE assoc_ssd.id_pc = computadores.id) t), '-') AS SSD,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(tamanho, ' (', saude, '%)') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_hd.tamanho, assoc_hd.saude, ROW_NUMBER() OVER (ORDER BY assoc_hd.id) AS rn FROM assoc_hd JOIN lista_hd ON assoc_hd.id_hd = lista_hd.id WHERE assoc_hd.id_pc = computadores.id) t), '-') AS HD,
        COALESCE((SELECT GROUP_CONCAT(CONCAT(marca, ' ', modelo, ' (', conexao, ')') ORDER BY rn SEPARATOR '\n') FROM (SELECT lista_monitor.marca, lista_monitor.modelo, assoc_monitor.conexao, ROW_NUMBER() OVER (ORDER BY assoc_monitor.id) AS rn FROM assoc_monitor JOIN lista_monitor ON assoc_monitor.id_monitor = lista_monitor.id WHERE assoc_monitor.id_pc = computadores.id) t), '-') AS Monitor,
        computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.wifi, computadores.mac_wifi, computadores.ip, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao
        FROM $nomeTabela
        LEFT JOIN secao ON computadores.id_operador=secao.id
        LEFT JOIN assoc_processador ON computadores.id=assoc_processador.id_pc
        LEFT JOIN lista_processador ON assoc_processador.id_processador=lista_processador.id
        LEFT JOIN assoc_placa_video ON computadores.id=assoc_placa_video.id_pc
        LEFT JOIN lista_placa_video ON assoc_placa_video.id_placa_video=lista_placa_video.id
        LEFT JOIN assoc_so ON computadores.id=assoc_so.id_pc
        LEFT JOIN lista_so ON assoc_so.id_so=lista_so.id
        LEFT JOIN assoc_ssd ON computadores.id=assoc_ssd.id_pc
        LEFT JOIN lista_ssd ON assoc_ssd.id_ssd=lista_ssd.id
        LEFT JOIN assoc_hd ON computadores.id=assoc_hd.id_pc
        LEFT JOIN lista_hd ON assoc_hd.id_hd=lista_hd.id
        LEFT JOIN assoc_office ON computadores.id=assoc_office.id_pc
        LEFT JOIN lista_office ON assoc_office.id_office=lista_office.id
        LEFT JOIN assoc_monitor ON computadores.id=assoc_monitor.id_pc
        LEFT JOIN lista_monitor ON assoc_monitor.id_monitor=lista_monitor.id
        WHERE computadores.tipo=2
        GROUP BY computadores.id, secao.sigla, computadores.marca, computadores.modelo, lista_processador.marca, lista_processador.modelo, computadores.tam_mem, computadores.tipo_mem, computadores.antivirus, computadores.rede, computadores.hostname, computadores.ip, computadores.mac, computadores.lacre, computadores.garantia, computadores.data_inclusao, computadores.data_atualizacao, computadores.situacao";
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
$tipo = $_GET['tipo'] ?? null;

// Chama a função para exibir a tabela
exibirTabela($conn, $nomeTabela, $tipo);

// Fecha a conexão
$conn->close();
?>