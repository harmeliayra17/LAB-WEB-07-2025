<?php
session_start();

// Mengosongkan semua variabel session
$_SESSION = [];

// Menghancurkan session
session_destroy();

// Mengarahkan kembali ke halaman login
header('Location: login.php');
exit;
?>