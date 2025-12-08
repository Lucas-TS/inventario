<?php require 'includes/valida_sessao.php'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
   <meta charset="utf-8">
   <title>Sistema de Inventário de Computadores</title>
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
   <script src="javascript/avatar.js"></script>
</head>

<body>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content">
      <form name="edit-pc" id="edit-pc" method="post" accept-charset="UTF-8" action="includes/editar_pc.php" onreset="limparFormulario()">
         <div id="bloco" class="bloco">
            <div class="header">
               <div id="b-line-fim-1" class="b-line">
                  <span>Editar Computador</span>
               </div>
               <div id="botoes">
                  <div id="b-line-fim-2" class="b-line correcao-altura">
                     <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include './images/erase.svg'; ?></button>
                  </div>
                  <div id="h-spacer"></div>
                  <div id="b-line-fim-3" class="b-line correcao-altura">
                     <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include './images/ok.svg'; ?></button>
                  </div>
               </div>
            </div>
            <div id="linha-0" class="linha">
                <div id="h-line-edit-pc-1" class="h-line">Cadastro:</div>
                <div id="b-line-edit-pc-1" class="b-line"><label class="label" for="id-edit-pc">ID:</label>
                    <input id="id-edit-pc" name="id-edit-pc" type="text" class="input" placeholder="" readonly title="ID">
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-pc-2" class="b-line">
                    <input type="checkbox" id="ativo-edit-pc" name="ativo-edit-pc" class="checkbox" value="1">
                    <label for="ativo-edit-pc"><span></span>Ativo</label>
                </div>
                <input id="hidden-tipo" name="hidden-tipo" type="hidden" value="0">
                <div id="h-spacer" style="flex-basis: 100%;"></div>
                <div id="b-line-edit-pc-3" class="b-line" style="flex-basis: 50%;"><span class="label">Incluído em:</span>
                    <span id="data-add-edit-pc"></span>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-pc-3" class="b-line"><span class="label">Última atualização em:</span>
                    <span id="data-updt-edit-pc"></span>
                </div>
            </div>
            <div id="linha-1" class="linha">
               <div id="h-line-1" class="h-line">Informações básicas:</div>
               <div id="b-line-1" class="b-line"><label class="label" for="op">Seção:</label>
                  <input id="op" name="op" type="text" class="input box" placeholder="Escolha a seção (Opcional)" style="width:350px"><div id="adicionarSec" class="flex-center margin-left icon-button"><a title="Adicionar nova seção" href="#" onclick="exibirOverlay('./overlay/add_sec_overlay.php')"><?php include './images/novo.svg'; ?></a></div>
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
                  <div id="suggestions-marca" class="suggestions-box marca"></div>
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-4" class="b-line"><label class="label" for="modelo">Modelo:</label>
                  <input id="modelo" name="modelo" type="text" class="input" placeholder="Digite o modelo (Opcional)" style="width:250px">
                  <div id="suggestions-modelo" class="suggestions-box modelo"></div>
               </div>
               <div id="h-spacer"></div>
               <div id="b-line-5" class="b-line"><label class="label" for="garantia">Garantia:</label>
                  <input id="garantia" name="garantia" type="number" class="input" placeholder="" style="width:100px">
                  <span style="color:#AAAAAA">&nbsp;meses</span>
               </div>
            </div>
            <div id="linha-2" class="linha">
               <div id="h-line-2" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php
                        $svg = file_get_contents('./images/acima.svg');
                        // Adiciona a classe rotacionado na tag SVG
                        $svg = str_replace('<svg', '<svg class="rotacionado"', $svg);
                        echo $svg;
                     ?>
                     Processador:
                  </a>
                  <div id="adicionarProc" class="flex-center margin-left icon-button"><a title="Adicionar novo processador" href="#" onclick="exibirOverlay('./overlay/add_proc_overlay.php')"><?php include './images/novo.svg'; ?></a></div>
               </div>
               <div id="b-line-proc-1" class="b-line"><label class="label" for="processador-desktop">Modelo:</label>
                  <input id="processador-desktop" class="input box" type="text" name="processador-desktop" style="width:400px;" placeholder="Escolha o modelo" required onkeyup="verificarTecla(event)">
                  <div id="suggestions-processador-desktop" class="suggestions-box processador-desktop"></div>
                  <input id="hidden-processador-desktop" name="hidden-processador-desktop" type="hidden" value="">
                  <input id="hidden-id-assoc-processador-desktop" name="hidden-id-assoc-processador-desktop" type="hidden" value="">
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
               <div id="h-line-3" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Memória RAM:
                  </a>
               </div>
               <div id="b-line-mem-1" class="b-line oculto"><span class="label">Quantidade:</span>
                  <button title="Diminuir" type="button" id="menos" class="menos icon-button margin-bottom" disabled onclick="less(this, 'mem')"><?php include './images/menos.svg'; ?></button>
                  <input id="qtde-mem" type="number" title="Quantidade" name="qtde-mem" data-tipo="mem" class="qtde-mem input" placeholder='Quantidade' value="1" style="width:59px;text-align:center;"><span style="color:#AAAAAA">&nbsp;GB</span>
                  <button title="Aumentar" type="button" id="mais" class="mais icon-button margin-bottom" onclick="more(this, 'mem')"><?php include './images/add.svg'; ?></button>
               </div>
               <div id="h-spacer" class="oculto"></div>
               <div id="b-line-mem-2" class="b-line oculto"><label class="label" for="tipo-mem">Tipo:</label>
                  <input id="tipo-mem" class="input openBox" type="text" name="tipo-mem" placeholder="Escolha o tipo" required readonly style="width:190px">
                  <div id="suggestions-tipo-mem" class="suggestions-box tipo-mem">
                  </div>
               </div>
            </div>
            <div id="linha-4" class="linha">
               <div id="h-line-4" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Armazenamento:
                  </a>
                  <div id="adicionarDsk" class="flex-center margin-left icon-button oculto">
                     <a title="Adicionar novo tamanho de armazenamento" href="#" onclick="exibirOverlay('./overlay/add_dsk_overlay.php')"><?php include './images/novo.svg'; ?></a>
                  </div>
               </div>
               <div id="armazenamentos-container" class="oculto">
                  <!-- Armazenamentos serão adicionados aqui -->
               </div>
               <div id="h-line-5" class="h-line h-line-sec oculto">
                  <div id="adicionarAmzt" class="flex-center icon-button"><a title="Adicionar armazenamento" href="#" onclick="adicionarArmazenamento()"><?php include './images/list.add.svg'; ?></a></div>
               </div>
            </div>
            <div id="linha-5" class="linha">
               <div id="h-line-6" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Placa de vídeo:
                  </a>
                  <div id="adicionarGpu" class="flex-center margin-left icon-button"><a title="Adicionar nova placa de vídeo" href="#" onclick="exibirOverlay('./overlay/add_pv_overlay.php')"><?php include './images/novo.svg'; ?></a></div>
               </div>
               <div id="b-line-pv-1" class="b-line oculto">
                  <span class="label">Tipo:</span>
                  <input type="radio" id="pv-on" name="pv" class="radio pv-check" value="on" checked onclick="formularioGPU(this.value)">
                  <label for="pv-on"><span></span>Onboard</label>
                  <input type="radio" id="pv-off" name="pv" class="radio pv-check" value="off" onclick="formularioGPU(this.value)">
                  <label for="pv-off"><span></span>Offboard</label>
               </div>
               <div id="formulario-pv-1" class="formulario pv oculto">
               </div>
            </div>
            <div id="linha-6" class="linha">
               <div id="h-line-7" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Monitor:
                  </a>
                  <div id="adicionarMon" class="flex-center margin-left icon-button oculto">
                     <a title="Adicionar novo monitor" href="#" onclick="exibirOverlay('./overlay/add_mon_overlay.php')"><?php include './images/novo.svg'; ?></a>
                  </div>
               </div>
               <div id="monitores-container" class="oculto">
                  <!-- Monitores serão adicionados aqui -->
               </div>
               <div id="h-line-8" class="h-line h-line-sec oculto">
                  <div id="adicionarMonitor" class="flex-center icon-button"><a title="Adicionar monitor" href="#" onclick="adicionarMonitor()"><?php include './images/list.add.svg'; ?></a></div>
               </div>
            </div>
            <div id="linha-7" class="linha">
               <div id="h-line-9" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Sistema Operacional:
                  </a>
                  <div id="adicionarSO" class="flex-center margin-left icon-button">
                     <a title="Adicionar novo SO" href="#" onclick="exibirOverlay('./overlay/add_so_overlay.php')"><?php include './images/novo.svg'; ?></a>
                  </div>
               </div>
               <div id="b-line-so-1" class="b-line oculto">
                  <span class="label">Família:</span>
                  <input type="radio" id="win" name="so" class="radio so-check" value="Windows" onclick="formularioSO(this.value)">
                  <label for="win"><span></span>Windows</label>
                  <input type="radio" id="linux" name="so" class="radio so-check" value="Linux" onclick="formularioSO(this.value)">
                  <label for="linux"><span></span>Linux</label>
               </div>
               <div id="formulario-so-1" class="formulario so oculto">
               </div>
               <div id="h-spacer" class="oculto"></div>
            </div>
            <div id="linha-8" class="linha">
               <div id="h-line10" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Pacote Office:
                  </a>
                  <div id="adicionarOffice" class="flex-center margin-left icon-button">
                     <a title="Adicionar novo pacote office" href="#" onclick="exibirOverlay('./overlay/add_office_overlay.php')"><?php include './images/novo.svg'; ?></a>
                  </div>
               </div>
               <div id="b-line-office-1" class="b-line oculto">
                  <span class="label">Pacote:</span>
                  <input type="radio" id="ms" name="office" class="radio" value="Office" onclick="formularioOffice(this.value)">
                  <label for="ms"><span></span>Microsoft Office</label>
                  <input type="radio" id="free" name="office" class="radio" value="Free" onclick="formularioOffice(this.value)">
                  <label for="free"><span></span>Gratuito</label>
               </div>
               <div id="formulario-office-1" class="formulario office oculto">
               </div>
            </div>
            <div id="linha-9" class="linha">
               <div id="h-line-11" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Antivírus:
                  </a>                  
               </div>
               <div id="b-line-av-1" class="b-line oculto">
                  <span class="label">Kaspersky Endpoint Security (KES):</span>
                  <input type="radio" id="av-sim" name="av" class="radio" value="1">
                  <label for="av-sim" onclick="expandirItem('h-line-12')"><span></span>Sim</label>
                  <input type="radio" id="av-nao" name="av" class="radio" value="0">
                  <label for="av-nao" onclick="expandirItem('h-line-12')"><span></span>Não</label>
               </div>
            </div>
            <div id="linha-10" class="linha">
               <div id="h-line-12" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Rede:
                  </a>                  
               </div>
               <div id="b-line-rede-1" class="b-line oculto"><label class="label" for="input-hn">Hostname:</label>
                  <input id="input-hn" name="hn" type="text" class="input trim" placeholder="Digite o nome" required style="width:250px">
               </div>
               <div id="h-spacer" class="oculto" style="flex-basis:100%"></div>
               <div id="b-line-rede-2" class="b-line oculto">
                  <span class="label">Placa de rede:</span>
                  <input type="radio" id="rede-on" name="rede" class="radio" value="0">
                  <label for="rede-on"><span></span>Onboard</label>
                  <input type="radio" id="rede-off" name="rede" class="radio" value="1">
                  <label for="rede-off"><span></span>Offboard</label>
               </div>
               <div id="h-spacer" class="oculto"></div>
               <div id="b-line-rede-3" class="b-line oculto"><label class="label" for="input-mac">MAC:</label>
                  <input id="input-mac" name="mac" type="text" class="input mac trim" placeholder="Digite o MAC" required style="width:250px" title="Digite apenas os caracteres">
               </div>
               <div id="h-spacer" style="flex-basis:100%"></div>
               <div id="b-line-rede-4" class="b-line oculto">
                  <span class="label">Wi-Fi:</span>
                  <input type="radio" id="wifi-nao" name="wifi" class="radio" value="0" required checked onclick="bloquearMacWifi()">
                  <label for="wifi-nao"><span></span>Não</label>
                  <input type="radio" id="wifi-sim" name="wifi" class="radio" value="1" onclick="liberarMacWifi()">
                  <label for="wifi-sim"><span></span>Sim</label>
               </div>
               <div id="h-spacer" class="oculto"></div>
               <div id="b-line-rede-5" class="b-line oculto"><label class="label" for="input-mac-wifi">MAC:</label>
                  <input id="input-mac-wifi" name="mac-wifi" type="text" class="input mac trim" placeholder="Digite o MAC" required disabled style="width:250px" title="Digite apenas os caracteres">
               </div>
               <div id="h-spacer" style="flex-basis:100%"></div>
               <div id="b-line-rede-6" class="b-line oculto" style="display:none"><label class="label" for="ip">IP:</label>
                  <input id="ip" name="ip" type="text" class="input" placeholder="Digite o IP" disabled style="width:250px">
               </div>
            </div>
            <div id="linha-11" class="linha fim">
               <div id="h-line-13" class="h-line expansivel">
                  <a onclick="expandirItem(this)">
                     <?php include './images/acima.svg'; ?>
                     Informações complementares:
                  </a>
               </div>
               <div id="b-line-fim-1" class="b-line oculto"><label class="label" for="situacao">Situação:</label>
                  <input id="situacao" class="input openBox" type="text" name="situacao" placeholder="Escolha a situação" required style="width:290px">
                  <div id="suggestions-situacao" class="suggestions-box situacao">
                     <p id="p0" onclick="passarValor('0', 'situacao', '0')">Em uso</p>
                     <p id="p1" onclick="passarValor('1', 'situacao', '1')">Devolver</p>
                     <p id="p2" onclick="passarValor('2', 'situacao', '2')">Distribuir</p>
                     <p id="p3" onclick="passarValor('3', 'situacao', '3')">Manutenção</p>
                     <p id="p4" onclick="passarValor('4', 'situacao', '4')">Aguardando Peças</p>
                     <p id="p5" onclick="passarValor('5', 'situacao', '5')">Defeito</p>
                     <p id="p6" onclick="passarValor('6', 'situacao', '6')">Descarregar</p>
                     <p id="p7" onclick="passarValor('7', 'situacao', '7')">Bloqueado</p>
                     <p id="p8" onclick="passarValor('8', 'situacao', '8')">Disponível</p>
                     <p id="p9" onclick="passarValor('9', 'situacao', '9')">Cautelado</p>
                  </div>
                  <input id="hidden-situacao" name="hidden-situacao" type="hidden" value="">
               </div>
               <div id="h-spacer" class="oculto"></div>
               <div id="b-line-fim-2" class="b-line oculto" style="flex:1"><label class="label" for="input-obs">Observações:</label>
                  <input id="input-obs" name="obs" type="text" class="input obs" placeholder="Opcional" style="width:100%">
               </div>
            </div>
         </div>
      </form>
   </div>
   <a href="#" title="Voltar ao topo">
      <div id="topo" class="topo botao-oculto"><?php include './images/seta.svg'; ?></div>
   </a>
   <div id="overlay" onclick="handleOverlayClick(event);clearTimeout(closeTimeout);">
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let urlParams = new URLSearchParams(window.location.search);
        let id = urlParams.get('id');
        preencherPC(id);
    });
</script>
<script src="javascript/suggestions.js"></script>
<script src="javascript/more.less.js"></script>
<script src="javascript/load.svg.js"></script>
<script src="javascript/pc.js"></script>
<script src="javascript/formulario.dsk.js"></script>
<script src="javascript/formulario.monitor.js"></script>
<script src="javascript/formulario.so.js"></script>
<script src="javascript/formulario.office.js"></script>
<script src="javascript/formulario.gpu.js"></script>
<script src="javascript/processador.js"></script>
<script src="javascript/placa.video.js"></script>
<script src="javascript/so.js"></script>
<script src="javascript/office.js"></script>
<script src="javascript/ssd.js"></script>
<script src="javascript/hd.js"></script>
<script src="javascript/monitor.js"></script>
<script src="javascript/secao.js"></script>
<script src="javascript/placeholder.js"></script>
<script src="javascript/masks.js"></script>
<script src="javascript/events.js"></script>

</html>