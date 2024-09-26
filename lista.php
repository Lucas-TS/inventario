<?php
if (isset ($_SESSION['avatar']))
    {
    $avatar = $_SESSION['avatar'];
    }
else
    {
    $avatar = 'images\avatar.png';
    }
session_start();
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
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      $_SESSION['url'] = $url;
      header('Location: ./login.php');
      exit;
   }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home - Sistema de Inventário de Computadores</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/inventario.css" rel="stylesheet">
<script src="javascript/jquery-1.12.4.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script src="javascript/panel.min.js"></script>
<script src="javascript/wwb19.min.js"></script>
<script src="javascript/load.effect.js"></script>
<script src="javascript/load.svg.js"></script>
<script src="javascript/overlay.js"></script>
<script src="javascript/cookies.js"></script>
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
                            <button id="enviar" class="flex-center large-button" type="submit"><?php include './images/buscar.svg'; ?></button>
                        </div>
                        <div id="h-spacer"></div>
                        <div id="b-line-header-3" class="b-line">
                            <div id="filtro" class="large-button-inverse large-button flex-center adjust-position svg"><a title="Filtro" href="#" onclick="exibirOverlayComCheckboxes(Object.keys(dadosTabela[0]), colunasSelecionadas)"><?php include './images/filtro.svg'; ?></a></div>
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
                <div id="paginacao" class="flex-center paginacao"></div>
                <label for="resultadosPorPagina">Resultados por página:</label>
                <select id="resultadosPorPagina" name="resultadosPorPagina">
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="50">50</option>
                    <option value="todos">Todos</option>
                </select>
            </div>
        </div>
    </div>
    <div id="overlay"  onclick="handleOverlayClick(event);">
    </div>
    <footer id="FlexContainer2" style="visibility:hidden;">
        <div id="wb_Text1">
            <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
        </div>
    </footer>
    <script src="javascript/cria.tabela.js"></script>
    <script src="javascript/events.js"></script>
</body>
</html>