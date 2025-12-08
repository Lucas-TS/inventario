<?php
session_start();

$error = null;
if (!empty($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

$username = $_COOKIE['remember_username'] ?? '';
$checked = $username ? 'checked' : '';

if (isset($_SESSION['username']) && isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
      header('Location: ./index.php');
      exit;
   }
   else
   {
      session_unset();
      session_destroy();
      header('Location: ./login.php?error=locked');  
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
                  <td colspan="2" class="row"><input class="input" name="username" type="text" autocomplete="username" id="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Usuário"></td>
               </tr>
               <tr>
                  <td colspan="2" class="row"><input class="input" name="password" type="password" autocomplete="current-password" id="password" value="" placeholder="Senha"></td>
               </tr>
               <?php if ($error): ?>
               <tr class="erro">
                  <td colspan="2" style="color:red;">
                      <?php
                        switch ($error):
                           case 'system':     echo 'Erro no sistema. Contate o administrador.'; break;
                           case 'credentials':echo 'Usuário ou senha incorretos.'; break;
                           case 'locked':     echo 'Muitas tentativas. Tente novamente mais tarde.'; break;
                        endswitch;
                     ?>
                  </td>
               </tr>
               <?php endif; ?>
                  <td class="row">
                     <div id="wb_FlipSwitch1">
                     <input title="Lembrar usuário" type="checkbox" role="switch" name="rememberme" id="FlipSwitch1" value="" <?php echo $checked; ?>>
                        <label id="FlipSwitch1-label" for="FlipSwitch1">
                           <span id="FlipSwitch1-inner"></span>
                           <span id="FlipSwitch1-switch"></span>
                        </label>
                        <span style="margin-left:5px;color:#747474;">Lembrar login</span>
                     </div>
                  </td>
                  <td style="text-align:right"><a id="esqueci" href="esqueci.php">Esqueci minha senha</a></td>
               </tr>
               <tr>
                  <td colspan="2" class="row">
                     <div class="flex-center">
                        <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include './images/ok.svg'; ?></button>
                     </div>
                  </td>
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