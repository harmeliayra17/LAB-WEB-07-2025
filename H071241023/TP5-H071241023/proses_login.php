<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_SESSION["user"])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

require __DIR__ . '/data.php';
if (!isset($users) || !is_array($users)) {
    $_SESSION['error'] = 'Data users tidak valid. Cek data.php.';
    header('Location: login.php');
    exit;
}

$foundUser = null;
foreach ($users as $user) {
    if (isset($user['username']) && $user['username'] === $username) {
        $foundUser = $user;
        break;
    }
}

$auth = false;
if ($foundUser && isset($foundUser['password'])) {
    $auth = password_verify($password, $foundUser['password']);
}

if ($auth) {
    $_SESSION['user'] = [
        'username' => $foundUser['username'],
        'name'     => $foundUser['name'] ?? $foundUser['username'],
    ];
    unset($_SESSION['error'], $_SESSION['old']);
    header('Location: dashboard.php');
    exit;
}

$_SESSION['error'] = 'Username atau password salah.';
$_SESSION['old']   = ['username' => $username];
header('Location: login.php');
exit;