<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Super Admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM projects WHERE id=" . $_GET['delete']);
}

$projects = $conn->query("SELECT p.*, u.username AS manager 
                          FROM projects p 
                          LEFT JOIN users u ON p.manager_id = u.id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Semua Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2>Kelola Semua Proyek</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
    <table class="table table-bordered table-striped">
        <tr>
            <th>ID</th><th>Nama Proyek</th><th>Deskripsi</th>
            <th>Manager</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Aksi</th>
        </tr>
        <?php while($p = $projects->fetch_assoc()): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nama_proyek'] ?></td>
            <td><?= $p['deskripsi'] ?></td>
            <td><?= $p['manager'] ?></td>
            <td><?= $p['tanggal_mulai'] ?></td>
            <td><?= $p['tanggal_selesai'] ?></td>
            <td><a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
