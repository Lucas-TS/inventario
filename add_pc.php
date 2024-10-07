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
function montarURLget()
{
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
   $filtered_params = array_filter($params, function ($value) {
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
<html lang="pt-BR">

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
   <script src="javascript/overlay.js"></script>
   <script src="javascript/fichas.js"></script>
</head>

<body>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content">
      <form name="add-pc" id="add-pc" method="post" accept-charset="UTF-8" action="includes/inserir_pc.php" onreset="limparFormulario()">
         <div id="bloco" class="bloco">
            <div class="header">
               <div id="b-line-fim-1" class="b-line">
                  <span>Adicionar Computador</span>
               </div>
               <div id="botoes">
                  <div id="b-line-fim-2" class="b-line correcao-altura">
                     <button id="limpar" class="flex-center large-button" type="reset"><?php include './images/erase.svg'; ?></button>
                  </div>
                  <div id="h-spacer"></div>
                  <div id="b-line-fim-3" class="b-line correcao-altura">
                     <button id="enviar" class="flex-center large-button" type="submit"><?php include './images/ok.svg'; ?></button>
                  </div>
               </div>
            </div>
            <div id="linha-1" class="linha">
               <div id="h-line-1" class="h-line">Informações básicas:</div>
               <div id="b-line-1" class="b-line"><label class="label" for="op">Operador:</label>
                  <input id="op" name="op" type="text" class="input box" placeholder="Escolha o operador (Opcional)" style="width:250px">
                  <input id="hidden-op" name="hidden-op" type="hidden" value="">
                  <div id="suggestions-op" class="suggestions-box op"></div>
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-2" class="b-line"><label class="label" for="lacre">Lacre:</label>
                  <input id="lacre" name="lacre" type="number" class="input trim" placeholder="Digite o número" required style="width:250px">
               </div>
               <div id="h-spacer" style="flex-basis: 100%;"></div>
               <div id="b-line-3" class="b-line"><label class="label" for="marca">Marca:</label>
                  <input id="marca" name="marca" type="text" class="input" placeholder="Digite a marca (Opcional)" style="width:250px">
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-4" class="b-line"><label class="label" for="modelo">Modelo:</label>
                  <input id="modelo" name="modelo" type="text" class="input" placeholder="Digite o modelo (Opcional)" style="width:250px">
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-5" class="b-line"><label class="label" for="garantia">Garantia:</label>
                  <input id="garantia" name="garantia" type="number" class="input" placeholder="" style="width:100px">
                  <span style="color:#AAAAAA">&nbsp;meses</span>
               </div>
            </div>
            <div id="linha-2" class="linha">
               <div id="h-line-2" class="h-line">Processador:<div id="adicionarProc" class="flex-center margin-left icon-button"><a title="Adicionar novo processador" href="#" onclick="exibirOverlay('./overlay/add_proc_overlay.php')"><?php include './images/novo.svg'; ?></a></div>
               </div>
               <div id="b-line-proc-1" class="b-line"><label class="label" for="processador-desktop">Modelo:</label>
                  <input id="processador-desktop" class="input box" type="text" name="processador-desktop" style="width:400px;" placeholder="Escolha o modelo" required onkeyup="verificarTecla(event)">
                  <div id="suggestions-processador-desktop" class="suggestions-box processador-desktop"></div>
                  <input id="hidden-processador-desktop" name="hidden-processador-desktop" type="hidden" value="">
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-proc-2" class="b-line">
                  <table id="fichaProc" class="fichaProc">
                     <tr>
                        <td>&nbsp;</td>
                     </tr>
                     <tr>
                        <td><span>Escolha um modelo da lista para carregar a ficha técnica</span></td>
                     </tr>
                  </table>
               </div>
            </div>
            <div id="linha-3" class="linha">
               <div id="h-line-3" class="h-line">Memória RAM:</div>
               <div id="b-line-mem-1" class="b-line"><label class="label" for="qtde-mem-1">Quantidade:</label>
                  <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'mem')"><?php include './images/menos.svg'; ?></button>
                  <input type="number" name="qtde-mem" class="qtde-mem input" value="1" style="width:59px;text-align:center;"><span style="color:#AAAAAA">&nbsp;GB</span>
                  <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'mem')"><?php include './images/add.svg'; ?></button>
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-mem-2" class="b-line"><label class="label" for="tipo-mem">Tipo:</label>
                  <input id="tipo-mem" class="input" type="text" name="tipo-mem" placeholder="Escolha o tipo" required readonly style="width:190px">
                  <div id="suggestions-tipo-mem" class="suggestions-box tipo-mem">
                     <p>DDR5</p>
                     <p>DDR4</p>
                     <p>DDR3</p>
                     <p>DDR2</p>
                     <p>DDR</p>
                  </div>
               </div>
            </div>
            <div id="linha-4" class="linha">
               <div id="h-line-4" class="h-line">Armazenamento:</div>
               <div id="armazenamentos-container">
                  <!-- Armazenamentos serão adicionados aqui -->
               </div>
               <div id="h-line-5" class="h-line">
                  <div id="adicionarDsk" class="flex-center icon-button"><a title="Adicionar armazenamento" href="#" onclick="adicionarArmazenamento()"><?php include './images/list.add.svg'; ?></a></div>
               </div>
            </div>
            <div id="linha-5" class="linha">
               <div id="h-line-6" class="h-line">Placa de vídeo:<div id="adicionarGpu" class="flex-center margin-left icon-button"><a title="Adicionar nova placa de vídeo" href="#" onclick="exibirOverlay('./overlay/add_pv_overlay.php')"><?php include './images/novo.svg'; ?></a></div>
               </div>
               <div id="b-line-pv-1" class="b-line">
                  <span class="label">Tipo:</span>
                  <input type="radio" id="pv-on" name="pv" class="radio pv-check" value="on" checked onclick="formularioGPU(this.value)">
                  <label for="pv-on"><span></span>Onboard</label>
                  <input type="radio" id="pv-off" name="pv" class="radio pv-check" value="off" onclick="formularioGPU(this.value)">
                  <label for="pv-off"><span></span>Offboard</label>
               </div>
               <div id="formulario-pv-1" class="formulario pv">
               </div>
            </div>
            <div id="linha-6" class="linha">
               <div id="h-line-7" class="h-line">Monitor:</div>
               <div id="monitores-container">
                  <!-- Monitores serão adicionados aqui -->
               </div>
               <div id="h-line-8" class="h-line">
                  <div id="adicionarMonitor" class="flex-center icon-button"><a title="Adicionar monitor" href="#" onclick="adicionarMonitor()"><?php include './images/list.add.svg'; ?></a></div>
               </div>
            </div>
            <div id="linha-7" class="linha">
               <div id="h-line-9" class="h-line">Sistema Operacional:</div>
               <div id="b-line-so-1" class="b-line">
                  <span class="label">Família:</span>
                  <input type="radio" id="win" name="so" class="radio so-check" value="Windows" onclick="formularioSO(this.value)">
                  <label for="win"><span></span>Windows</label>
                  <input type="radio" id="linux" name="so" class="radio so-check" value="Linux" onclick="formularioSO(this.value)">
                  <label for="linux"><span></span>Linux</label>
               </div>
               <div id="formulario-so-1" class="formulario so">
               </div>
               <div id="h-spacer"></div>
            </div>
            <div id="linha-8" class="linha">
               <div id="h-line10" class="h-line">Pacote Office:</div>
               <div id="b-line-office-1" class="b-line">
                  <span class="label">Pacote:</span>
                  <input type="radio" id="ms" name="office" class="radio" value="Office" onclick="formularioOffice(this.value)">
                  <label for="ms"><span></span>Microsoft Office</label>
                  <input type="radio" id="free" name="office" class="radio" value="Free" onclick="formularioOffice(this.value)">
                  <label for="free"><span></span>Gratuito</label>
               </div>
               <div id="formulario-office-1" class="formulario office">
               </div>
            </div>
            <div id="linha-9" class="linha">
               <div id="h-line-11" class="h-line">Antivírus:</div>
               <div id="b-line-av-1" class="b-line">
                  <span class="label">Kaspersky Endpoint Security (KES):</span>
                  <input type="radio" id="av-sim" name="av" class="radio" value="1">
                  <label for="av-sim"><span></span>Sim</label>
                  <input type="radio" id="av-nao" name="av" class="radio" value="0">
                  <label for="av-nao"><span></span>Não</label>
               </div>
            </div>
            <div id="linha-10" class="linha fim">
               <div id="h-line-12" class="h-line">Rede:</div>
               <div id="b-line-rede-1" class="b-line"><label class="label" for="hn">Hostname:</label>
                  <input id="input-hn" name="hn" type="text" class="input trim" placeholder="Digite o nome" required style="width:250px">
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-rede-2" class="b-line">
                  <span class="label">Placa de rede:</span>
                  <input type="radio" id="rede-on" name="rede" class="radio" value="0">
                  <label for="rede-on"><span></span>Onboard</label>
                  <input type="radio" id="rede-off" name="rede" class="radio" value="1">
                  <label for="rede-off"><span></span>Offboard</label>
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-rede-3" class="b-line"><label class="label" for="mac">MAC:</label>
                  <input id="input-mac" name="mac" type="text" class="input mac trim" placeholder="Digite o MAC" required style="width:250px">
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-rede-4" class="b-line" style="display:none"><label class="label" for="ip">IP:</label>
                  <input id="ip" name="ip" type="text" class="input" placeholder="Digite o IP" disabled style="width:250px">
               </div>
            </div>
         </div>
      </form>
   </div>
   <a href="#" title="Voltar ao topo">
      <div id="topo" class="topo oculto"><?php include './images/seta.svg'; ?></div>
   </a>
   <div id="overlay" onclick="handleOverlayClick(event);">
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
<script src="javascript/add.pc.js"></script>
<script src="javascript/formulario.dsk.js"></script>
<script src="javascript/formulario.monitor.js"></script>
<script src="javascript/formulario.so.js"></script>
<script src="javascript/formulario.office.js"></script>
<script src="javascript/formulario.gpu.js"></script>
<script src="javascript/add.proc.js"></script>
<script src="javascript/add.pv.js"></script>
<script src="javascript/placeholder.js"></script>
<script src="javascript/masks.js"></script>
<script src="javascript/events.js"></script>
<?php
// Fecha a conexão MySQL
$conn->close();
?>

</html>