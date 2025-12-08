<?php
session_start();

// Verifica se está logado
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Valida IP e User-Agent
if ($_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']
 || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Renova expiração
if (time() > $_SESSION['expires_by']) {
    session_unset();
    session_destroy();
    header('Location: login.php?error=locked');
    exit;
}
$_SESSION['expires_by'] = time() + $_SESSION['expires_timeout'];
?>