<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Project Manager') {
    header("Location: ../login.php");
    exit();
}

$project_id = $_GET['project_id'];
$manager_id = $_SESSION['id'];

// Cek apakah proyek milik manager ini
$check = $conn->query("SELECT * FROM projects WHERE id=$project_id AND manager_id=$manager_id");
if ($check->num_rows == 0) {
    die("Akses ditolak!");
}

// Tambah tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_tugas'];
    $desk = $_POST['deskripsi'];
    $assign = $_POST['assigned_to'];
    $sql = "INSERT INTO tasks (nama_tugas, deskripsi, status, project_id, assigned_to)
            VALUES ('$nama', '$desk', 'belum', '$project_id', '$assign')";
    $conn->query($sql);
}

// Hapus tugas
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM tasks WHERE id=" . $_GET['delete']);
}

$tasks = $conn->query("SELECT t.*, u.username AS member 
                       FROM tasks t LEFT JOIN users u ON t.assigned_to = u.id 
                       WHERE t.project_id=$project_id");

$members = $conn->query("SELECT * FROM users WHERE project_manager_id=$manager_id AND role='Team Member'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Tugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2>Kelola Tugas Proyek</h2>
    <a href="projects.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card p-3 shadow-sm mb-4">
        <h5>Tambah Tugas</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="nama_tugas" class="form-control" placeholder="Nama Tugas" required>
            </div>
            <div class="col-md-3">
                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
            </div>
            <div class="col-md-3">
                <select name="assigned_to" class="form-select" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php while($m = $members->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>"><?= $m['username'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success w-100">Tambah</button>
            </div>
        </form>
    </div>

    <h5>Daftar Tugas</h5>
    <table class="table table-bordered table-striped">
        <tr><th>Nama</th><th>Deskripsi</th><th>Anggota</th><th>Status</th><th>Aksi</th></tr>
        <?php while($t = $tasks->fetch_assoc()): ?>
        <tr>
            <td><?= $t['nama_tugas'] ?></td>
            <td><?= $t['deskripsi'] ?></td>
            <td><?= $t['member'] ?></td>
            <td><?= ucfirst($t['status']) ?></td>
            <td><a href="?delete=<?= $t['id'] ?>&project_id=<?= $project_id ?>" class="btn btn-sm btn-danger">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
