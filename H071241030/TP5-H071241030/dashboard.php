<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 0 10px #ccc; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #007BFF; color: white; }
        .logout { background: red; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; float: right; }
    </style>    
</head>
<body>
    <a href="logout.php" class="logout">Logout</a>
    <h2>
        <?php
        if ($user['username'] === 'adminxxx') {
            echo "Selamat Datang, Admin!";
        } else {
            echo "Selamat Datang, {$user['name']}!";
        }
        ?>
    </h2>

    <?php if ($user['username'] === 'adminxxx'): ?>
        <h3>Data Seluruh Pengguna:</h3>
        <table>
            <tr>
                <th>Email</th><th>Username</th><th>Nama</th><th>Gender</th><th>Fakultas</th><th>Angkatan</th>
            </tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['email'] ?></td>
                <td><?= $u['username'] ?></td>
                <td><?= $u['name'] ?></td>
                <td><?= $u['gender'] ?? '-' ?></td>
                <td><?= $u['faculty'] ?? '-' ?></td>
                <td><?= $u['batch'] ?? '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h3>Data Anda:</h3>
        <table>
            <tr><th>Email</th><td><?= $user['email'] ?></td></tr>
            <tr><th>Username</th><td><?= $user['username'] ?></td></tr>
            <tr><th>Nama</th><td><?= $user['name'] ?></td></tr>
            <tr><th>Gender</th><td><?= $user['gender'] ?? '-' ?></td></tr>
            <tr><th>Fakultas</th><td><?= $user['faculty'] ?? '-' ?></td></tr>
            <tr><th>Angkatan</th><td><?= $user['batch'] ?? '-' ?></td></tr>
        </table>
    <?php endif; ?>
</body>
</html>
