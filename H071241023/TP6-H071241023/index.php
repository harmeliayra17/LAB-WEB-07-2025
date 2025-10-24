<?php
require __DIR__ . '/auth.php';
if (isLoggedIn()) {
    redirectByRole();
}
header('Location: /TP-6/login.php');
exit;
?>