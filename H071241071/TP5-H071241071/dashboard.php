<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        .dashboard { max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; }
        .dashboard table { width: 100%; border-collapse: collapse; }
        .dashboard th, .dashboard td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .dashboard a { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php if ($user['username'] === 'adminxxx'): ?>
            <h2>Selamat Datang, Admin!</h2>
            <a href="logout.php">Logout</a>
            <h3>Data Semua Pengguna</h3>
            <table>
                <tr><th>Nama</th><th>Username</th><th>Email</th></tr>
                <?php include 'data.php'; foreach ($users as $u): ?>
                    <tr><td><?php echo $u['name']; ?></td><td><?php echo $u['username']; ?></td><td><?php echo $u['email']; ?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <h2>Selamat Datang, <?php echo $user['name']; ?>!</h2>
            <a href="logout.php">Logout</a>
            <h3>Data Anda</h3>
            <table>
                <tr><th>Nama</th><td><?php echo $user['name']; ?></td></tr>
                <tr><th>Username</th><td><?php echo $user['username']; ?></td></tr>
                <tr><th>Email</th><td><?php echo $user['email']; ?></td></tr>
                <?php if (isset($user['gender'])): ?><tr><th>Gender</th><td><?php echo $user['gender']; ?></td></tr><?php endif; ?>
                <?php if (isset($user['faculty'])): ?><tr><th>Fakultas</th><td><?php echo $user['faculty']; ?></td></tr><?php endif; ?>
                <?php if (isset($user['batch'])): ?><tr><th>Angkatan</th><td><?php echo $user['batch']; ?></td></tr><?php endif; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>