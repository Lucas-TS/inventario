<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'email' => $_SESSION['email'] ?? null,
    'fullname' => $_SESSION['fullname'] ?? null,
    'username' => $_SESSION['username'] ?? null,
    'id' => $_SESSION['id'] ?? null,
    'grupo' => $_SESSION['grupo'] ?? null,
    'avatar' => $_SESSION['avatar'] ?? null
]);
?>