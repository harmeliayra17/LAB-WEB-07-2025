<?php
session_start();
include 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: dashboard.php');
                exit;
            }
            break;
        }
    }

    $_SESSION['error'] = 'Username atau password salah!';
    header('Location: login.php');
    exit;
}
?>