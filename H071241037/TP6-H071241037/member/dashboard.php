<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Team Member') {
    header("Location: ../login.php");
    exit();
}

$member_id = $_SESSION['id'];

// Update status tugas
if (isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE tasks SET status='$status' WHERE id=$task_id AND assigned_to=$member_id");
}

// Ambil tugas berdasarkan member
$tasks = $conn->query("SELECT t.*, p.nama_proyek 
                       FROM tasks t 
                       JOIN projects p ON t.project_id = p.id 
                       WHERE t.assigned_to=$member_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Team Member</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Dashboard Team Member</h2>
    <p>Halo, <strong><?= $_SESSION['username'] ?></strong>!</p>
    <a href="../logout.php" class="btn btn-danger mb-3">Logout</a>

    <h5>Tugas Saya</h5>
    <table class="table table-bordered table-striped">
        <tr><th>Proyek</th><th>Tugas</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr>
        <?php while($t = $tasks->fetch_assoc()): ?>
        <tr>
            <td><?= $t['nama_proyek'] ?></td>
            <td><?= $t['nama_tugas'] ?></td>
            <td><?= $t['deskripsi'] ?></td>
            <td><?= ucfirst($t['status']) ?></td>
            <td>
                <form method="POST" class="d-flex">
                    <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                    <select name="status" class="form-select form-select-sm me-2">
                        <option value="belum" <?= $t['status']=='belum'?'selected':'' ?>>Belum</option>
                        <option value="proses" <?= $t['status']=='proses'?'selected':'' ?>>Proses</option>
                        <option value="selesai" <?= $t['status']=='selesai'?'selected':'' ?>>Selesai</option>
                    </select>
                    <button name="update_status" class="btn btn-sm btn-primary">Simpan</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
