<?php
session_start();
include '../config.php';
if ($_SESSION['role'] != 'Super Admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];
    $pm_id = $_POST['project_manager_id'] ?? 'NULL';

    $sql = "INSERT INTO users (username, password, role, project_manager_id)
            VALUES ('$username', '$password', '$role', " . ($pm_id == 'NULL' ? 'NULL' : $pm_id) . ")";
    $conn->query($sql);
}

// hapus user
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM users WHERE id=" . $_GET['delete']);
}

$managers = $conn->query("SELECT id, username FROM users WHERE role='Project Manager'");
$users = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Pengguna</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2>Kelola Pengguna</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
    <form method="POST" class="card p-3 mb-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-md-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="Project Manager">Project Manager</option>
                    <option value="Team Member">Team Member</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="project_manager_id" class="form-select">
                    <option value="NULL">- PM (jika Team Member) -</option>
                    <?php while($m = $managers->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>"><?= $m['username'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success w-100">Tambah</button>
            </div>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <tr><th>ID</th><th>Username</th><th>Role</th><th>PM</th><th>Aksi</th></tr>
        <?php while($u = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['username'] ?></td>
            <td><?= $u['role'] ?></td>
            <td><?= $u['project_manager_id'] ?></td>
            <td><a href="?delete=<?= $u['id'] ?>" class="btn btn-sm btn-danger">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
