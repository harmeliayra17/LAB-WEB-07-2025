<?php
session_start();
include 'data.php';

$username = $_POST['username'];
$password = $_POST['password'];
$userFound = false;

foreach ($users as $user) {
    if ($user['username'] === $username && password_verify($password, $user['password'])) {
        $userFound = true;
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit();
    }
}

if (!$userFound) {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit();
}
?>