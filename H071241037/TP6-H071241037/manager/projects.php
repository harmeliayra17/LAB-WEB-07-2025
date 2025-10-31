<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Project Manager') {
    header("Location: ../login.php");
    exit();
}

$manager_id = $_SESSION['id'];

// Tambah proyek
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_proyek'];
    $desk = $_POST['deskripsi'];
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];
    $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
            VALUES ('$nama', '$desk', '$mulai', '$selesai', '$manager_id')";
    $conn->query($sql);
}

// Hapus proyek
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM projects WHERE id=" . $_GET['delete']);
}

$projects = $conn->query("SELECT * FROM projects WHERE manager_id=$manager_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Proyek</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2>Manajemen Proyek</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
    <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>

    <div class="card p-3 shadow-sm mb-4">
        <h5>Tambah Proyek</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="nama_proyek" class="form-control" placeholder="Nama Proyek" required>
            </div>
            <div class="col-md-4">
                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_selesai" class="form-control" required>
            </div>
            <div class="col-md-12 text-end">
                <button class="btn btn-success">Tambah</button>
            </div>
        </form>
    </div>

    <h5>Daftar Proyek</h5>
    <table class="table table-bordered table-striped">
        <tr><th>Nama</th><th>Deskripsi</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Aksi</th></tr>
        <?php while($p = $projects->fetch_assoc()): ?>
        <tr>
            <td><?= $p['nama_proyek'] ?></td>
            <td><?= $p['deskripsi'] ?></td>
            <td><?= $p['tanggal_mulai'] ?></td>
            <td><?= $p['tanggal_selesai'] ?></td>
            <td>
                <a href="tasks.php?project_id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">Tugas</a>
                <a href="?delete=<?= $p['id'] ?>" class="btn btn-sm btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
