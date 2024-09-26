<?php
include 'includes/conecta_db.php';
$params = [];
if (isset($_SESSION['avatar'])) {
   $avatar = $_SESSION['avatar'];
} else {
   $avatar = 'images\avatar.png';
}
session_start();
unset($_SESSION['url']);
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pagina = strtok($url, '?');
$_SESSION['url'] = $url;
if (!isset($_SESSION['username'])) {
   header('Location: ./login.php');
   exit;
}
if (isset($_SESSION['expires_by'])) {
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by) {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
   } else {
      unset($_SESSION['email']);
      unset($_SESSION['fullname']);
      unset($_SESSION['username']);
      unset($_SESSION['avatar']);
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      header('Location: ./login.php');
      exit;
   }
}
$busca = $_GET['busca'] ?? '';
$op = $_GET['op'] ?? '';
$ip = $_GET['ip'] ?? '';
$hn = $_GET['hn'] ?? '';
$mac = $_GET['mac'] ?? '';
$qtde = $_GET['qtde'] ?? '';
$secao = $_GET['secao'] ?? '';
$situacao = $_GET['situacao'] ?? '';
$ativo = $_GET['ativo'] ?? '';
$ordem = $_GET['ordem'] ?? 'id';
$por = $_GET['por'] ?? 'ASC';
$secao_arr = isset($_GET['secao']) ? explode(',', $_GET['secao']) : [];
$situacao_arr = isset($_GET['situacao']) && $_GET['situacao'] !== '' ? explode(',', $_GET['situacao']) : [];
$p = '';
function montarURLget() {
$params = [
   'busca' => $GLOBALS['busca'],
   'op' => $GLOBALS['op'],
   'ip' => $GLOBALS['ip'],
   'hn' => $GLOBALS['hn'],
   'mac' => $GLOBALS['mac'],
   'qtde' => $GLOBALS['qtde'],
   'secao' => $GLOBALS['secao'],
   'situacao' => $GLOBALS['situacao'],
   'ativo' => $GLOBALS['ativo'],
   'ordem' => $GLOBALS['ordem'],
   'por' => $GLOBALS['por'],
   'p' => $GLOBALS['p'],
];
$filtered_params = array_filter($params, function ($value)
{
   return $value !== '' && $value !== null;
});
$GLOBALS['get'] = http_build_query($filtered_params);
}
$check_ativo = 'checked';
$check_inativo = '';
if (isset($_GET['ativo'])) {
   switch ($_GET['ativo']) {
      case "0":
         $check_ativo = '';
         $check_inativo = 'checked';
         break;
      case "1":
         $check_inativo = '';
         break;
      case "2":
         $check_inativo = 'checked';
         break;
   }
}
?>
<!doctype html>
<html>
<head>
   <meta charset="utf-8">
   <title>Desktops - Sistema de Inventário de Computadores</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="css/inventario.css" rel="stylesheet">
   <script src="javascript/jquery.min.js"></script>
   <script src="javascript/jquery-ui.min.js"></script>
   <script src="javascript/jquery.mask.min.js"></script>
   <script src="javascript/panel.min.js"></script>
   <script src="javascript/wwb19.min.js"></script>
   <script src="javascript/load.effect.js"></script>
   <script src="javascript/ocultar.bloco.js"></script>
   <script src="javascript/overlay.js"></script>
</head>
<body>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content" style="visibility:hidden;">
      <div id="bloco" class="bloco">
         <form name="filtro-form" method="post" accept-charset="UTF-8" action="includes/filtro.php" id="filtro-form">
            <input type="hidden" name="url" value="desktops.php">
            <div class="header fim">
               <div id="b-line-header-1" class="b-line" style="flex-basis:100%;">
                  <input id="input-busca" class="input" name="busca" value="<?php echo $busca; ?>" placeholder="Buscar">
               </div>
               <div id="h-spacer"></div>
               <div id="botoes">
                  <div id="b-line-header-2" class="b-line">
                     <button id="enviar" class="flex-center large-button" type="submit"><?php include './images/buscar.svg'; ?></button>
                  </div>
                  <div id="h-spacer"></div>
                  <div id="b-line-header-3" class="b-line">
                     <div id="filtro" class="large-button-inverse large-button flex-center adjust-position svg"><a title="Filtro" href="#" onclick="exibirOverlay('./overlay/filtro_overlay.php')"><?php include './images/filtro.svg'; ?></a></div>
                  </div>
               </div>
            </div>
         </form>
      </div>
      <div id="spacer"></div>
      <?php
      $id_asc = ($por == "ASC" && $ordem == "id") ? "#117095" : "#AAAAAA";
      $id_desc = ($por == "DESC" && $ordem == "id") ? "#117095" : "#AAAAAA";
      $sc_asc = ($por == "ASC" && $ordem == "sigla") ? "#117095" : "#AAAAAA";
      $sc_desc = ($por == "DESC" && $ordem == "sigla") ? "#117095" : "#AAAAAA";
      $op_asc = ($por == "ASC" && $ordem == "operador") ? "#117095" : "#AAAAAA";
      $op_desc = ($por == "DESC" && $ordem == "operador") ? "#117095" : "#AAAAAA";
      $hn_asc = ($por == "ASC" && $ordem == "hostname") ? "#117095" : "#AAAAAA";
      $hn_desc = ($por == "DESC" && $ordem == "hostname") ? "#117095" : "#AAAAAA";
      $ip_asc = ($por == "ASC" && $ordem == "ip") ? "#117095" : "#AAAAAA";
      $ip_desc = ($por == "DESC" && $ordem == "ip") ? "#117095" : "#AAAAAA";
      $mac_asc = ($por == "ASC" && $ordem == "mac") ? "#117095" : "#AAAAAA";
      $mac_desc = ($por == "DESC" && $ordem == "mac") ? "#117095" : "#AAAAAA";
      $sit_asc = ($por == "ASC" && $ordem == "situacao") ? "#117095" : "#AAAAAA";
      $sit_desc = ($por == "DESC" && $ordem == "situacao") ? "#117095" : "#AAAAAA";
      ?>
      <div id="bloco" class="bloco">
         <table id="lista" class="tabela-lista" cellspacing="0" cellpadding="0">
            <thead>
               <tr>
                  <th id="ativo" class="head-lista"></th>
                  <th id="id" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "id"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $id_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "id"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $id_desc; ?>;"></path></a>
                  </svg>ID</div>
                  </th>
                  <th id="sc" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "sigla"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $sc_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "sigla"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $sc_desc; ?>;"></path></a>
                  </svg>Seção</div>
                  </th>
                  <th id="op" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "operador"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $op_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "operador"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $op_desc; ?>;"></path></a>
                  </svg>Operador</div>
                  </th>
                  <th id="hn" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "hostname"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $hn_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "hostname"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $hn_desc; ?>;"></path></a>
                  </svg>Host Name</div>
                  </th>
                  <th id="ip" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "ip"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $ip_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "ip"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $ip_desc; ?>;"></path></a>
                  </svg>IP</div>
                  </th>
                  <th id="mac" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "mac"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $mac_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "mac"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $mac_desc; ?>;"></path></a>
                  </svg>MAC</div>
                  </th>
                  <th id="sit" class="head-lista"><div id="icone" class="ordem">
                  <svg class="icon" fill="#000000" viewBox="0 0 12 24" id="scroll-up-down" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color">
                     <a title="Ordem crescente" href="<?php $por = "ASC"; $ordem = "situacao"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="secondary" d="M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z" style="fill: <?php echo $sit_asc; ?>;"></path></a>
                     <a title="Ordem decrescente" href="<?php $por = "DESC"; $ordem = "situacao"; montarURLget(); echo $pagina . "?" . $get; ?>"><path id="primary" d="m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z" style="fill: <?php echo $sit_desc; ?>;"></path></a>
                  </svg>Situação</div>
                  </th>
                  <th colspan="3" class="head-lista" style="width:80px">Ações</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $ordem = $_GET['ordem'] ?? 'id';
               $por = $_GET['por'] ?? 'ASC';
               $filtro_ativo = "WHERE computadores.ativo = 1 ";
               if (isset($_GET['ativo'])) {
                  if ($_GET['ativo'] == "0") {
                     $filtro_ativo = "WHERE computadores.ativo = 0 ";
                  }
                  if ($_GET['ativo'] == "1") {
                     $filtro_ativo = "WHERE computadores.ativo = 1 ";
                  }
                  if ($_GET['ativo'] == "2") {
                     $filtro_ativo = "WHERE computadores.ativo >= 0  ";
                  }
               }
               if (isset($_GET['qtde']))
               {
                  $qtde = $_GET['qtde'];
               }
               else
               {
                  $qtde = "25";
               }
               $filtro_busca = "";
               if (isset($_GET['busca']) && !empty($_GET['busca']))
               {
                  $filtro_busca = " AND (computadores.id LIKE '%".$_GET['busca']."%' OR computadores.hostname LIKE '%".$_GET['busca']."%' OR computadores.ip LIKE '%".$_GET['busca']."%' OR computadores.mac LIKE '%".$_GET['busca']."%' OR CONCAT(pg.abreviatura,' ',militares.nome_guerra) LIKE '%".$_GET['busca']."%')";
               }
               $filtro_op = "";
               if (isset($_GET['op']) && !empty($_GET['op']))
               {
                  $filtro_op = " AND CONCAT(pg.abreviatura,' ',militares.nome_guerra) LIKE '%".$_GET['op']."%'";
               }
               $filtro_ip = "";
               if (isset($_GET['ip']) && !empty($_GET['ip']))
               {
                  $filtro_ip = " AND computadores.ip LIKE '%".$_GET['ip']."%'";
               }
               $filtro_hn = "";
               if (isset($_GET['hn']) && !empty($_GET['hn']))
               {
                  $filtro_hn = " AND computadores.hostname LIKE '%".$_GET['hn']."%'";
               }
               $filtro_mac = "";
               if (isset($_GET['mac']) && !empty($_GET['mac']))
               {
                  $filtro_mac = " AND computadores.mac LIKE '%".$_GET['mac']."%'";
               }
               $filtro_secao = "";
               if (isset($_GET['secao']) && !empty($_GET['secao']))
               {
                  for ($i = 0; $i < count($secao_arr); $i++) {
                     if ($i === 0) {
                        // Condição para o primeiro elemento
                        $filtro_secao .= " AND (secao.sigla LIKE '%" . $secao_arr[$i] . "%'";
                     } else {
                        // Condição para os demais elementos
                        $filtro_secao .= " OR secao.sigla LIKE '%" . $secao_arr[$i] . "%'";
                     }
                  }
                  $filtro_secao .= ")";
               }
               $filtro_situacao = "";
               if (isset($_GET['situacao']) && $_GET['situacao'] !== '')
               {
                  for ($i = 0; $i < count($situacao_arr); $i++) {
                     if ($i === 0) {
                        // Condição para o primeiro elemento
                        $filtro_situacao .= " AND (computadores.situacao LIKE '%" . $situacao_arr[$i] . "%'";
                     } else {
                        // Condição para os demais elementos
                        $filtro_situacao .= " OR computadores.situacao LIKE '%" . $situacao_arr[$i] . "%'";
                     }
                  }
                  $filtro_situacao .= ")";
               }

               // Identificação da página
               if (!isset($_GET['p']))
               {
                  $atual = 1;
               }
               else
               {
                  $atual = $_GET['p'];
               }
               // Limites dos resultados do SQL
               $inicio = $atual - 1;
               $inicio = $inicio * $qtde;

               // Consulta SQL para selecionar os dados da tabela
               $sql = "SELECT computadores.id, computadores.ativo, computadores.hostname, computadores.ip, computadores.mac, computadores.situacao, secao.sigla, CONCAT(pg.abreviatura,' ',militares.nome_guerra) AS operador FROM computadores
               LEFT JOIN militares ON computadores.id_operador=militares.id
               LEFT JOIN secao ON militares.id_secao=secao.id
               LEFT JOIN pg ON militares.id_pg=pg.id " . $filtro_ativo . $filtro_busca . $filtro_op . $filtro_ip . $filtro_hn . $filtro_mac . $filtro_secao . $filtro_situacao . " ORDER BY " . $ordem . " " . $por;
               $result = $conn->query("$sql LIMIT $inicio,$qtde");
               // echo $sql; exit;
               // função de máscara para MAC
               function mascara($valor, $formato)
               {
                  $retorno = '';
                  $posicao_valor = 0;
                  for ($i = 0; $i <= strlen($formato) - 1; $i++) {
                     if ($formato[$i] == '#') {
                        if (isset($valor[$posicao_valor])) {
                           $retorno .= $valor[$posicao_valor++];
                        }
                     } else {
                        $retorno .= $formato[$i];
                     }
                  }
                  return $retorno;
               }
               if ($result->num_rows > 0) {
                  // Exibe os dados de cada linha
                  while ($row = $result->fetch_assoc()) {
                     if ($row["mac"] != NULL) {
                        $mac_masked = mascara($row["mac"], "##:##:##:##:##:##");
                     } else {
                        $mac_masked = "";
                     }
                     switch ($row["situacao"]) {
                        case "0":
                           $icone_situacao = "images/ok.svg";
                           $texto_situacao = "Em uso";
                           $cor = '#008000';
                           break;
                        case "1":
                           $icone_situacao = "images/return.svg";
                           $texto_situacao = "Devolver";
                           $cor = '#01CF73';
                           break;
                        case "2":
                           $icone_situacao = "images/info.svg";
                           $texto_situacao = "Distribuir";
                           $cor = '#2196F3';
                           break;
                        case "3":
                           $icone_situacao = "images/manut.svg";
                           $texto_situacao = "Manutenção";
                           $cor = '#FF9800';
                           break;
                        case "4":
                           $icone_situacao = "images/espera.svg";
                           $texto_situacao = "Aguardando peças";
                           $cor = '#02B3C0';
                           break;
                        case "5":
                           $icone_situacao = "images/defeito.svg";
                           $texto_situacao = "Defeito";
                           $cor = '#D50000';
                           break;
                        case "6":
                           $icone_situacao = "images/bin.svg";
                           $texto_situacao = "Descarregar";
                           $cor = '#7E57C2';
                           break;
                        default:
                           $icone_situacao = "";
                           $texto_situacao = "";
                           $cor = '#000000';
                           break;
                     }
                     if ($row["ativo"] == "1") {
                        $icone_ativo = 'images/ativo.svg';
                        $title = "Ativo";
                     } else {
                        $icone_ativo = 'images/inativo.svg';
                        $title = "Desativado";
                     }
                     echo '<tr  class="linhas" style="text-align:center;">
                     <td title="' . $title . '" id="icone">';
                     include $icone_ativo;
                     echo '</td>
                     <td id="coluna_id" headers="id">' . $row["id"] . '</td>
                     <td id="coluna_secao" headers="sc">' . $row["sigla"] . '</td>
                     <td id="coluna_operador" headers="op">' . $row["operador"] . '</td>
                     <td id="coluna_host" headers="hn">' . $row["hostname"] . '</td>
                     <td id="coluna_ip" headers="ip">' . $row["ip"] . '</td>
                     <td id="coluna_mac" headers="mac">' . $mac_masked . '</td>
                     <td id="icone" class="situacao" headers="sit">';
                     include $icone_situacao;
                     echo '<span style="color:' . $cor . ';">' . $texto_situacao . "</span>";
                     echo '</td>
                     <td id="icone" style="width: 16px;">' . '<a title="Ver detalhes" href="pc.php?id=' . $row["id"] . '">';
                     include "images/view.svg";
                     echo '</td>
                     <td id="icone" style="width: 16px;">' . '<a title="Editar" href="editar_pc.php?id=' . $row["id"] . '">';
                     include "images/edit.svg";
                     echo '</td>
                     <td id="icone" style="width: 16px;">' . '<a title="Apagar" href="delete.php?tipo=pc&id=' . $row["id"] . '">';
                     include "images/del.svg";
                     echo "</td>
                     </tr>";
                  }
               } else {
                  echo "Nenhum resultado encontrado.";
               }
               ?>
            </tbody>
         </table>
         <div id="paginas" class="div-paginas" style="font-size:15px">
         <?php
         // Calculos da paginação
         $consulta_total = $conn->query($sql);
         $result_total = mysqli_num_rows($consulta_total);
         $total_pag = ceil($result_total / $qtde);
         $anterior = $atual - 1;
         $proxima = $atual + 1;

         if ($atual > 2)
         {
            $p = "1";
            montarURLget();
            echo '<div id="anterior" class="botao-seta"><a href="' . $pagina . '?' . $get . '">';
            include './images/primeira.svg';
            echo '</a></div>';
         }
         if ($atual > 1)
         {
            $p = $anterior;
            montarURLget();
            echo '<div id="anterior" class="botao-seta"><a href="' . $pagina . '?' . $get . '">';
            include './images/anterior.svg';
            echo '</a></div>';
         }
         for ($i = max(1, $atual - 2); $i <= min($total_pag, $atual + 2); $i++)
         {
            if ($i == $atual)
            {
               echo '<div id="atual" class="botao-atual">' . $i . '</div>';
            }
            else
            {
               $p = $i;
               montarURLget();
               echo '<div id="numero" class="botao-paginas"><a href="' . $pagina .  '?' . $get . '">'. $i . '</a></div>';
            }
         }
         if ($atual < $total_pag)
         {
            $p = $proxima;
            montarURLget();
            echo '<div id="proxima" class="botao-seta"><a href="' . $pagina . '?' . $get . '">';
            include './images/proximo.svg';
            echo '</a></div>';
         }
         if ($atual < $total_pag - 1)
         {
            $p = $total_pag;
            montarURLget();
            echo '<div id="proxima" class="botao-seta"><a href="' . $pagina . '?' . $get . '">';
            include './images/ultima.svg';
            echo '</a></div>';
         }
         ?>
         </div>
      </div>
   </div>
   <a href="./add_pc.php" title="Adicionar novo PC"><div id="adicionar" class="balao"><?php include './images/add.svg'; ?></div></a>
   <a href="#" title="Voltar ao topo"><div id="topo" class="topo oculto"><?php include './images/seta.svg'; ?></div></a>
   <div id="overlay" onclick="handleOverlayClick(event);">
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
<script src="javascript/placeholder.js"></script>
<script src="javascript/masks.js"></script>
<script src="javascript/events.js"></script>
<?php
// Fecha a conexão MySQL
$conn->close();
?>
</html>