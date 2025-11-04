<?php
session_start();
require 'data.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$found = false;
foreach ($users as $user) {
    if ($user['username'] === $username) {
        $found = true;
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
            header("Location: login.php");
            exit;   
        }
    }
}

if (!$found) {
    $_SESSION['error'] = "Username tidak ditemukan!";
    header("Location: login.php");
    exit;
}
?>
