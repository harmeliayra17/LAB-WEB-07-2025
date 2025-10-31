<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Super Admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Super Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Dashboard Super Admin</h2>
    <p>Selamat datang, <strong><?= $_SESSION['username'] ?></strong></p>
    <a href="manage_users.php" class="btn btn-primary">Kelola Pengguna</a>
    <a href="manage_projects.php" class="btn btn-secondary">Kelola Semua Proyek</a>
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
