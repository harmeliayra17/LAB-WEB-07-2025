<?php
require __DIR__ . '/auth.php';
session_destroy();
header('Location: /TP-6/login.php');
exit;
?>