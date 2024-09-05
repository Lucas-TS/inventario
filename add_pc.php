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
   <script src="javascript/fichas.js"></script>
</head>
<body>
   <?php include 'includes/logout_overlay.html' ?>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content" style="visibility:hidden;">
      <form name="add-pc" id="add-pc" method="get" accept-charset="UTF-8" action="teste/teste.php">
         <div id="bloco">
            <div id="base-pc">
               <div class="header">
                  <span>Adicionar Computador</span>
               </div>
               <div id="linha-1" class="linha">
                  <div id="h-line-1" class="h-line">Informações básicas:</div>
                  <div id="b-line-1" class="b-line"><label class="label" for="op">Operador:</label><input id="op" name="op" type="text" class="input box" placeholder="Digite um nome" required style="width:250px"></div>
                  <input id="hidden-op" name="hidden-op" type="hidden" value="">
                  <div id="suggestions-op" class="suggestions-box op"></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-2"class="b-line"><label class="label" for="marca">Marca:</label><input id="marca" name="marca" type="text" class="input" placeholder="Digite uma marca (Opcional)" style="width:250px"></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-3"class="b-line"><label class="label" for="modelo">Modelo:</label><input id="modelo" name="modelo" type="text" class="input" placeholder="Digite um modelo (Opcional)" style="width:250px"></div>
               </div>
               <div id="linha-2" class="linha">
                  <div id="h-line-2" class="h-line">Processador:</div>
                  <div id="b-line-proc-1"class="b-line"><label class="label" for="processador">Modelo:</label><input id="processador" class="input box" type="text" name="processador" class="input" placeholder="Escolha um modelo na lista" required onkeyup="verificarTecla(event)"></div>
                  <input id="hidden-processador" name="hidden-processador" type="hidden" value="">
                  <div id="suggestions-processador" class="suggestions-box processador"></div>
                  <div id="adicionarProc"><a title="Adicionar novo processador" href="#"><?php include './images/add.svg'; ?></a></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-proc-2"class="b-line">
                     <table id="fichaProc" class="fichaProc">
                        <tr><td>&nbsp;</td></tr><tr><td><span>Escolha um modelo para carregar a ficha técnica</span></td></tr>
                     </table>
                  </div>
               </div>
               <div id="linha-3" class="linha">
                  <div id="h-line-3" class="h-line">Memória RAM:</div>
                  <div id="b-line-mem-1"class="b-line"><label class="label" for="qtde-mem-1">Quantidade:</label>
                     <button title="Diminuir" type="button" id="menos" class="menos" disabled onclick="less(this, 'mem')"><?php include './images/menos.svg'; ?></button>
                     <input type="text" name="qtde-mem" class="qtde-mem input" value="1" style="width:59px;text-align:center;"><span style="color:#AAAAAA">&nbsp;GB</span>
                     <button title="Aumentar" type="button" id="mais" class="mais" onclick="more(this, 'mem')"><?php include './images/add.svg'; ?></button>
                  </div>
                  <div id="h-spacer"></div>
                  <div id="b-line-mem-2" class="b-line"><label class="label" for="tipo-mem">Tipo:</label><input id="tipo-mem" class="input" type="text" name="tipo-mem" placeholder="Escolha um tipo" required readonly style="width:190px"></div>
                  <div id="suggestions-tipo-mem" class="suggestions-box tipo-mem">
                     <p>DDR5</p>
                     <p>DDR4</p>
                     <p>DDR3</p>
                     <p>DDR2</p>
                     <p>DDR</p>
                  </div>
               </div>
               <div id="linha-4" class="linha">
                  <div id="h-line-4" class="h-line">Armazenamento:</div>
                     <div id="armazenamentos-container">
                        <!-- Armazenamentos serão adicionados aqui -->
                     </div>
                  <div id="h-line-5" class="h-line"><div id="adicionarDsk"><a title="Adicionar armazenamento" href="#" onclick="adicionarArmazenamento()"><?php include './images/add.svg'; ?></a></div></div>
               </div>
               <div id="linha-5" class="linha">
               <div id="h-line-6" class="h-line">Monitor:</div>
                     <div id="monitores-container">
                        <!-- Monitores serão adicionados aqui -->
                     </div>
                  <div id="h-line-7" class="h-line"><div id="adicionarMonitor"><a title="Adicionar monitor" href="#" onclick="adicionarMonitor()"><?php include './images/add.svg'; ?></a></div></div>
               </div>
               <div id="linha-6" class="linha">
                  <div id="h-line-8" class="h-line">Sistema Operacional:</div>
                  <div id="b-line-so-1" class="b-line">
                     <span class="label">Família:</span>
                     <input type="radio" id="win" name="so" class="radio so-check" value="Windows" onclick="formularioSO(this.value)">
                     <label for="win"><span></span>Windows</label>
                     <input type="radio" id="linux" name="so" class="radio so-check" value="Linux" onclick="formularioSO(this.value)">
                     <label for="linux"><span></span>Linux</label>
                  </div>
                  <div id="formulario-so-1" class="formulario">
                  </div>
                  <div id="h-spacer"></div>
               </div>
               <div id="linha-8" class="linha">
               <div id="h-line-9" class="h-line">Pacote Office:</div>
               <div id="b-line-office-1" class="b-line">
                     <input type="radio" id="ms" name="office" class="radio" value="1">
                     <label for="ms"><span></span>Microsoft Office</label>
                     <input type="radio" id="free" name="office" class="radio" value="0">
                     <label for="free"><span></span>Gratuito</label>
                  </div>
               </div>
               <div id="linha-9" class="linha">
               <div id="h-line-10" class="h-line">Antivírus:</div>
               <div id="b-line-av-1" class="b-line">
                     <input type="radio" id="av-sim" name="av" class="radio" value="1">
                     <label for="av-sim"><span></span>Sim</label>
                     <input type="radio" id="av-nao" name="av" class="radio" value="0">
                     <label for="av-nao"><span></span>Não</label>
                  </div>
               </div>
               <div id="linha-10" class="linha">

               </div>
               <div id="linha-11" class="linha">
                  
               </div>
               <div id="linha-12" class="linha">
                  
               </div>
               <div id="linha-13" class="linha">
                  <button type="submit">TESTE</button>
               </div>
            </div>
         </div>
      </form> 
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
<script src="javascript/suggestions.js"></script>
<script src="javascript/more.less.js"></script>
<script src="javascript/load.svg.js"></script>
<script src="javascript/add.dsk.js"></script>
<script src="javascript/add.monitor.js"></script>
<script src="javascript/placeholder.js"></script>
<script src="javascript/formulario.so.js"></script>
<script src="javascript/events.js"></script>
<script src="javascript/masks.js"></script>
<?php
// Fecha a conexão MySQL
$conn->close();
?>
</html>