<?php
session_start();
if (isset ($_SESSION['avatar'])) {
   $avatar = $_SESSION['avatar'];
} else {
   $avatar = 'images\avatar1.png';
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
<script src="javascript/avatar.js"></script>
<script src="javascript/chart.js"></script>
<script src="javascript/chart.labels.js"></script>

</head>
<body>
   <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
      <?php include 'includes/menu.php'; ?>
   </header>
   <div id="content" style="visibility:hidden;" class="content-index">
      <div id="cards-container" class="cards-container">
        <div id="bloco-card-1" class="card">
        </div>
        <div id="bloco-card-2" class="card">
        </div>
        <div id="bloco-card-3" class="card">
        </div>
        <div id="bloco-card-4" class="card">
        </div>
      </div>
   </div>
   <div id="overlay" onclick="handleOverlayClick(event);clearTimeout(closeTimeout);">
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
<script src="javascript/cards.js"></script>
<script src="javascript/apagar.item.js"></script>
<script src="javascript/placeholder.js"></script>
<script src="javascript/overlay.js"></script>
<script src="javascript/masks.js"></script>
<script src="javascript/more.less.js"></script>
<script src="javascript/events.js"></script>
</html>