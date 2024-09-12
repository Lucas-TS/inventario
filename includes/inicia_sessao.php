<?php
session_start();
if (isset($_POST['form_name']) && $_POST['form_name'] == 'loginform')
{
   if (isset($_SESSION['url']))
   {
      $success_page = $_SESSION['url'];
   }
   else
   {
      $success_page = '../index.php';
   }
   $error_page = '../login.php';
   $mysql_server = '127.0.0.1';
   $mysql_username = 'inventario';
   $mysql_password = 't3rr4d3n1ngu3m';
   $mysql_database = 'inventario';
   $mysql_table = 'users';
   $crypt_pass = md5($_POST['password']);
   $found = false;
   $db_email = '';
   $db_fullname = '';
   $db_username = '';
   $session_timeout = 3600;
   $db = mysqli_connect($mysql_server, $mysql_username, $mysql_password);
   if (!$db)
   {
      die('Failed to connect to database server!<br>'.mysqli_error($db));
   }
   mysqli_select_db($db, $mysql_database) or die('Failed to select database<br>'.mysqli_error($db));
   mysqli_set_charset($db, 'utf8');
   $sql = "SELECT * FROM ".$mysql_table." WHERE username = '".mysqli_real_escape_string($db, $_POST['username'])."'";
   $result = mysqli_query($db, $sql);
   if ($data = mysqli_fetch_array($result))
   {
      if ($crypt_pass == $data['password'] && $data['ativo'] != 0)
      {
         $found = true;
         $db_email = $data['email'];
         $db_fullname = $data['fullname'];
         $db_username = $data['username'];
         $db_id = $data['id'];
         if ($data['avatar'] != NULL)
         {
            $avatar = $data['avatar'];
         }
         else
         {
            $avatar = 'images\avatar.png';
         }
      }
   }
   mysqli_close($db);
   if ($found == false)
   {
      header('Location: '.$error_page);
      exit;
   }
   else
   {
      $_SESSION['email'] = $db_email;
      $_SESSION['fullname'] = $db_fullname;
      $_SESSION['username'] = $db_username;
      $_SESSION['id'] = $db_id;
      $_SESSION['avatar'] = $avatar;
      $_SESSION['expires_by'] = time() + $session_timeout;
      $_SESSION['expires_timeout'] = $session_timeout;
      if (isset($_POST['rememberme']))
      {
         setcookie('username', $db_username, time() + 3600*24*30, '/');
         setcookie('password', $_POST['password'], time() + 3600*24*30, '/');
      }
      else
      {
         setcookie('username', "");
         setcookie('password', "");
      }
      header('Location: '.$success_page);
      exit;
   }
}
