<?php
if (isset($_POST['form_name']) && $_POST['form_name'] == 'logoutform')
{
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['fullname']);
    unset($_SESSION['username']);
    unset($_SESSION['avatar']);
    unset($_SESSION['expires_by']);
    header('Location: ../login.php');
}
else
{
    header('Location: ../index.php');
}
?>