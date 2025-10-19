<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
include 'data.php';
$user = $_SESSION['user'];
$isAdmin = $user['username'] === 'adminxxx';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        a { display: block; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <?php if ($isAdmin): ?>
        <h1>Selamat Datang, Admin!</h1>
        <h2>Data Semua Pengguna</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Faculty</th>
                <th>Batch</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo $u['name']; ?></td>
                    <td><?php echo $u['username']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td><?php echo isset($u['gender']) ? $u['gender'] : '-'; ?></td>
                    <td><?php echo isset($u['faculty']) ? $u['faculty'] : '-'; ?></td>
                    <td><?php echo isset($u['batch']) ? $u['batch'] : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h1>Selamat Datang, <?php echo $user['name']; ?>!</h1>
        <h2>Data Anda</h2>
        <table>
            <tr><th>Name</th><td><?php echo $user['name']; ?></td></tr>
            <tr><th>Username</th><td><?php echo $user['username']; ?></td></tr>
            <tr><th>Email</th><td><?php echo $user['email']; ?></td></tr>
            <tr><th>Gender</th><td><?php echo $user['gender']; ?></td></tr>
            <tr><th>Faculty</th><td><?php echo $user['faculty']; ?></td></tr>
            <tr><th>Batch</th><td><?php echo $user['batch']; ?></td></tr>
        </table>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</body>
</html>