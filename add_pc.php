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
   <script src="javascript/desktops.js"></script>
   <script>
      function clearPlaceholder(input)
      {
         input.dataset.placeholder = input.placeholder;
         input.placeholder = '';
      }
      function restorePlaceholder(input)
      {
         input.placeholder = input.dataset.placeholder;
      }

      function showSuggestions(str1, str2) {
         const $suggestions = $('#suggestions-' + str2);
         if (!$suggestions.hasClass("visivel")) {
            $suggestions.addClass('visivel');
         }
         $.ajax({
            url: "./includes/auto_complete.php",
            method: "GET",
            data: { q: str1, n: str2 },
            success: function(response) {
               $suggestions.html(response);
            }
         });
      }

      function fichaProcessador(str1) {
         var div = document.getElementById('b-line-5');
         div.innerHTML = '';
         $.ajax({
            url: "./includes/auto_complete.php",
            method: "GET",
            data: { fp: str1 },
            success: function(response) {
               var dados = JSON.parse(response);
               var output = '<table class="fichaProc"><tr>';
               
               if (dados.geracao) output += "<td><b>Geração:</b> " + dados.geracao + "</td>";
               if (dados.pcores) {
                  if (dados.ecores) {
                     output += "<td><b>P-Cores / E-Cores / Threads:</b> " + dados.pcores + " / " + dados.ecores + " / " + dados.threads + "</td>";
                  } else {
                     output += "<td><b>Cores / Threads:</b> " + dados.pcores + " / " + dados.threads + "</td>";
                  }
               }
               if (dados.memoria) output += "<td><b>Memória:</b> " + dados.memoria + "</td>";
               
               output += "</tr><tr>";
               
               if (dados.socket) output += "<td><b>Socket:</b> " + dados.socket + "</td>";
               if (dados.clock && dados.turbo) {
                  output += "<td><b>Clock / Turbo (Ghz):</b> " + dados.clock + " / " + dados.turbo + "</td>";
               } else {
                  if (dados.clock) output += "<td><b>Clock:</b> " + dados.clock + "</td>";
                  if (dados.turbo) output += "<td><b>Turbo:</b> " + dados.turbo + "</td>";
               }
               
               if (dados.clock) {
                  output += "<td><b>iGPU:</b> " + (dados.igpu ? dados.igpu : "N/A") + "</td>";
               }
               
               output += "</tr></table>";
               
               div.innerHTML = output;
            }
         });
      }

      function passarValor(nr, input, id) {
      var valor = $("#p" + nr).text();
      $(input).val(valor);
      $('#suggestions-' + $(input).attr('id')).removeClass('visivel');
    
      var hiddenElement = document.getElementById('hidden-' + $(input).attr('id'));
      if (hiddenElement) {
         hiddenElement.value = id;
      }
   }

   </script>
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
               <div id="linha">
                  <div id="h-line-1" class="h-line">Informações básicas:</div>
                  <div id="b-line-1" class="b-line"><label class="label" for="op">Operador:</label><input id="op" name="op" type="text" class="input" placeholder="Digite um nome" required style="width:250px" onkeyup="showSuggestions(this.value, this.id)" onclick="showSuggestions(this.value, this.id)" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)"></div>
                  <input id="hidden-op" name="hidden-op" type="hidden" value="">
                  <div id="suggestions-op" class="suggestions-box op"></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-2"class="b-line"><label class="label" for="marca">Marca:</label><input id="marca" name="marca" type="text" class="input" placeholder="Digite uma marca (Opcional)" style="width:250px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)"></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-3"class="b-line"><label class="label" for="modelo">Modelo:</label><input id="modelo" name="modelo" type="text" class="input" placeholder="Digite um modelo (Opcional)" style="width:250px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)"></div>
               </div>
               <div id="linha">
                  <div id="h-line-2" class="h-line">Processador:</div>
                  <div id="b-line-4"class="b-line"><label class="label" for="processador">Modelo:</label><input id="processador" class="input" type="text" name="processador" class="input" placeholder="Escolha um modelo na lista" required onkeyup="showSuggestions(this.value, this.id); fichaProcessador(this.value)" onclick="showSuggestions(this.value, this.id)" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)"></div>
                  <input id="hidden-processador" name="hidden-processador" type="hidden" value="">
                  <div id="suggestions-processador" class="suggestions-box processador"></div>
                  <div id="adicionarProc"><a title="Adicionar novo processador" href="#"><?php include './images/add.svg'; ?></a></div>
                  <div id="h-spacer"></div>
                  <div id="b-line-5"class="b-line"></div>
               </div>
               <div id="linha">
                  <div id="h-line-3" class="h-line">Memória RAM:</div>
                  <div id="b-line-6"class="b-line"><label class="label" for="qtde-mem-1">Quantidade:</label>
                     <button title="Diminuir" type="button" id="menos" class="menos" disabled onclick="less(this, 'mem')"><?php include './images/menos.svg'; ?></button>
                     <input type="text" name="qtde-mem" class="qtde-mem input" value="1" style="width:59px;text-align:center;"><span style="color:#AAAAAA">&nbsp;GB</span>
                     <button title="Aumentar" type="button" id="mais" class="mais" onclick="more(this, 'mem')"><?php include './images/add.svg'; ?></button>
                  </div>
                  <div id="h-spacer"></div>
                  <div id="b-line-7" class="b-line"><label class="label" for="tipo-mem">Tipo:</label><input id="tipo-mem" class="input" type="text" name="tipo-mem" class="input" placeholder="Escolha um tipo na lista" required style="width:190px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)"></div>
                  <div id="suggestions-tipo-mem" class="suggestions-box tipo-mem">
                     <p>DDR5</p>
                     <p>DDR4</p>
                     <p>DDR3</p>
                     <p>DDR2</p>
                     <p>DDR</p>
                  </div>
               </div>
               <div id="linha">
                  <div id="h-line-4" class="h-line">Armazenamento:</div>
                     <div id="armazenamentos-container">
                        <!-- Armazenamentos serão adicionados aqui -->
                     </div>
                  <div id="h-line-5" class="h-line"><div id="adicionarDsk"><a title="Adicionar armazenamento" href="#" onclick="adicionarArmazenamento()"><?php include './images/add.svg'; ?></a></div></div>
               </div>
               <div id="linha">
               <div id="h-line-6" class="h-line">Monitor:</div>
                     <div id="monitores-container">
                        <!-- Monitores serão adicionados aqui -->
                     </div>
                  <div id="h-line-7" class="h-line"><div id="adicionarMonitor"><a title="Adicionar monitor" href="#" onclick="adicionarMonitor()"><?php include './images/add.svg'; ?></a></div></div>
               </div>
               <div id="linha">
                  
               </div>
               <div id="linha">
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
<?php
// Fecha a conexão MySQL
$conn->close();
?>
</html>