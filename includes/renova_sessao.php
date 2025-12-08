<?php
session_start();

if (isset($_SESSION['username'])) {
    $_SESSION['expires_by'] = time() + $_SESSION['expires_timeout'];
    http_response_code(200);
} else {
    http_response_code(401); // sessão inválida
}
?>
