<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password']))
{
   $checked = "checked";
}
else
{
   $checked = "";
}
$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
      header('Location: ./index.php');
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
   }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Home - Sistema de Inventário de Computadores</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/inventario.css" rel="stylesheet">
<link href="css/login.css" rel="stylesheet">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script src="javascript/panel.min.js"></script>
<script src="javascript/wwb19.min.js"></script>
<script src="javascript/load.effect.js"></script>
</head>
<body>
      <header id="FlexContainer1" style="visibility:hidden;">
      <div id="wb_Heading" style="display:block;width:886px;z-index:0;">
         <h1 id="Heading">Sistema de Controle de Inventário</h1>
      </div>
   </header>
   <div id="content" style="visibility:hidden;">
      <div id="wb_Login1">
         <form name="loginform" method="post" accept-charset="UTF-8" action="includes/inicia_sessao.php" id="loginform">
            <input type="hidden" name="form_name" value="loginform">
            <table id="Login1">
               <tr>
                  <td colspan="3" class="row"><input  class="input" name="username" autocomplete="on" type="text" id="username" value="<?php echo $username; ?>" placeholder="Usuário"></td>
               </tr>
               <tr>
                  <td colspan="3" class="row"><input  class="input" name="password" type="password" id="password" value="<?php echo $password; ?>" placeholder="Senha"></td>
               </tr>
               <tr>
                  <td colspan="3" class="row">
                     <div id="wb_FlipSwitch1">
                     <input title="Lembrar login" type="checkbox" <?php echo $checked; ?> role="switch" name="rememberme" id="FlipSwitch1" value="">
                        <label id="FlipSwitch1-label" for="FlipSwitch1">
                           <span id="FlipSwitch1-inner"></span>
                           <span id="FlipSwitch1-switch"></span>
                        </label>
                        <span style="margin-left:5px;color:#747474;">Lembrar login</span>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td style="text-align:left;vertical-align:bottom"><a id="esqueci" href="esqueci.php">Esqueci minha senha</a></td>
                  <td style="text-align:left;vertical-align:bottom"><!--<input class="button" type="reset" name="reset" value="Limpar" id="reset">--></td>
                  <td style="text-align:right;vertical-align:bottom"><input class="button" type="submit" name="login" value="Entrar" id="login"></td>
               </tr>
            </table>
         </form>
      </div>
   </div>
   <footer id="FlexContainer2" style="visibility:hidden;">
      <div id="wb_Text1">
         <p>Desenvolvido por Lucas Trindade Silveira © 2024 - v1.0</p>
      </div>
   </footer>
</body>
</html>