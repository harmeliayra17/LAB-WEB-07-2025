<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Project Manager') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Project Manager</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Dashboard Project Manager</h2>
    <p>Halo, <strong><?= $_SESSION['username'] ?></strong>!</p>
    <a href="projects.php" class="btn btn-primary">Kelola Proyek</a>
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
