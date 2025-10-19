<?php
session_start();

require_once 'data.php';

$input_username = $_POST['username'] ?? '';
$input_password = $_POST['password'] ?? '';

$loggedInUser = null;
foreach ($users as $user) {
    if ($user['username'] === $input_username) {
        $loggedInUser = $user;
        break;
    }
}

if ($loggedInUser) {
    if (password_verify($input_password, $loggedInUser['password'])) {
        unset($loggedInUser['password']); 
        $_SESSION['user'] = $loggedInUser;
        header('Location: dashboard.php');
        exit();
    }
}

$_SESSION['error'] = 'Username atau password salah!';
header('Location: login.php');
exit();