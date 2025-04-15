<?php
session_start();
if (isset($_SESSION['avatar'])) {
    $avatar = $_SESSION['avatar'];
} else {
    $avatar = 'images\avatar.png';
}
unset($_SESSION['url']);
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['username']))
{
   $_SESSION['url'] = $url;
   header('Location: ./login.php');
   exit;
}
if (isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
   }
   else
   {
      unset($_SESSION['email']);
      unset($_SESSION['fullname']);
      unset($_SESSION['username']);
      unset($_SESSION['avatar']);
      unset($_SESSION['grupo']);
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      $_SESSION['url'] = $url;
      header('Location: ./login.php');
      exit;
   }
}

?>
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
<script src="javascript/load.svg.js"></script>
<script src="javascript/cookies.js"></script>
<script src="javascript/cria.tabela.js"></script>
</head>
<body>
    <header id="FlexContainer1" style="visibility:hidden;">
        <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
            <h1 id="Heading">Sistema de Controle de Inventário</h1>
        </div>
        <?php include 'includes/menu.php'; ?>
    </header>
    <div id="content" style="visibility:hidden;">
        <div id="bloco-busca" class="bloco">
            <form name="filtro-form" method="post" accept-charset="UTF-8" action="includes/filtro.php" id="filtro-form">
                <input type="hidden" name="url" value="desktops.php">
                    <div class="header fim">
                        <div id="b-line-header-1" class="b-line" style="flex-basis:100%;">
                            <input id="input-busca" class="input busca" name="busca" value="" placeholder="Buscar">
                        </div>
                    <div id="h-spacer"></div>
                    <div id="botoes">
                        <div id="b-line-header-2" class="b-line">
                            <button id="buscar" title="Buscar" class="flex-center large-button" type="submit"><?php include './images/buscar.svg'; ?></button>
                        </div>
                        <div id="h-spacer"></div>
                        <div id="b-line-header-3" class="b-line">
                            <div id="filtro" class="large-button-inverse large-button flex-center adjust-position svg"><a title="Filtro" href="#" onclick="exibirOverlayComCheckboxes(Object.keys(dadosTabela[0]), preferenciasAtuais.colunas, preferenciasAtuais.resultadosPorPagina)">
                            <?php include './images/filtro.svg'; ?></a></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="spacer"></div>
        <div id="bloco-tabela" class="bloco">
            <div id="tabela" class="tabela-lista">
            
            </div>
            <div id="rodape-bloco" class="flex-center rodape">
                <div id="paginacao" class="flex-center paginacao">
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['tabela']) && !empty($_GET['tabela']))
    {
        $icone = file_get_contents('./images/add.svg');
        $linkAdd = "";
        $js = "";
        switch ($_GET['tabela']) {
            case "notebooks":
                $linkAdd = '<a href="./add_notebook.php" title="Adicionar novo Notebook"><div id="adicionar" class="balao">' . $icone . '</div></a>';
                $js = '';
                break;
            case "computadores":
                $linkAdd = '<a href="./add_pc.php" title="Adicionar novo PC"><div id="adicionar" class="balao">' . $icone . '</div></a>';
                $js = '';
                break;
            case "lista_processador":
                $linkAdd = '<a href="#" title="Adicionar novo processador"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_proc_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/processador.js"></script>';
                break;
            case "lista_placa_video":
                $linkAdd = '<a href="#" title="Adicionar nova placa de vídeo"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_pv_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/placa.video.js"></script>';
                break;
            case "militares":
                $linkAdd = '<a href="#" title="Adicionar novo militar"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_mil_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/militar.js"></script>';
                break;
            case "secao":
                $linkAdd = '<a href="#" title="Adicionar nova seção"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_sec_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/secao.js"></script>';
                break;
            case "lista_monitor":
                $linkAdd = '<a href="#" title="Adicionar novo monitor"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_mon_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/monitor.js"></script>';
                break;
            case "lista_hd":
                $linkAdd = '<a href="#" title="Adicionar novo HD"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_hd_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/hd.js"></script>';
                break;
            case "lista_ssd":
                $linkAdd = '<a href="#" title="Adicionar novo SSD"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_ssd_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/ssd.js"></script>';
                break;
            case "lista_so":
                $linkAdd = '<a href="#" title="Adicionar novo sistema operacional"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_so_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/so.js"></script>';
                break;
            case "lista_office":
                $linkAdd = '<a href="#" title="Adicionar novo pacote office"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_office_overlay.php\')">' . $icone . '</div></a>';
                $js = '<script src="javascript/office.js"></script>';
                break;
            case "users":
                if ($_SESSION['grupo'] == 1)
                {
                    $linkAdd = '<a href="#" title="Adicionar novo usuario"><div id="adicionar" class="balao" onclick="exibirOverlay(\'./overlay/add_user_overlay.php\')">' . $icone . '</div></a>';
                    $js = '<script src="javascript/user.js"></script>';
                }
                break;
            case "":
                break;
        }
        echo $linkAdd;
    }
    ?>
    <a href="#" title="Voltar ao topo"><div id="topo" class="topo oculto"><?php include './images/seta.svg'; ?></div></a>
    <div id="overlay" onclick="handleOverlayClick(event);clearTimeout(closeTimeout);">
    </div>
    <footer id="FlexContainer2" style="visibility:hidden;">
        <div id="wb_Text1">
            <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
        </div>
    </footer>
    <script src="javascript/suggestions.js"></script>
    <?php echo $js; ?>
    <script src="javascript/apagar.item.js"></script>
    <script src="javascript/placeholder.js"></script>
    <script src="javascript/overlay.js"></script>
    <script src="javascript/masks.js"></script>
    <script src="javascript/more.less.js"></script>
    <script src="javascript/events.js"></script>
</body>
</html>