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
?><!doctype html>
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
   </div>
   <div id="overlay" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);return false;">
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
</html>