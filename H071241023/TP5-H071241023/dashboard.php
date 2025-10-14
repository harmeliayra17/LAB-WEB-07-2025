<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$currentUsername = $_SESSION['user']['username'] ?? '';

require __DIR__ . '/data.php';

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$whiteList = [
    'name' => 'Nama',
    'username' => 'Username',
    'email' => 'Email',
    'gender' => 'Gender',
    'faculty' => 'Fakultas',
    'batch' => 'Angkatan',
];

$profile = null;
if (isset($users) && is_array($users)) {
    foreach ($users as $user) {
        if (isset($user['username']) && $user['username'] === $currentUsername) {
            $profile = $user;
            break;
        }
    }
}

if (!$profile) {
    $profile = ['username' => $currentUsername, 'name' => ($_SESSION['user']['name'] ?? $currentUsername)];
}

$isAdmin = $currentUsername === 'AdminOteweHaji';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="dashboard">
    <?php if($isAdmin): ?>
        <h1>Selamat datang, Admin!</h1>
        <div class="card">
            <div class="actions">
                <a href="logout.php" class="btn">Logout</a>
            </div>
            <hr>
            <div class="card-header">Data Semua Pengguna</div>
            <table>
                <thead>
                    <tr>
                        <?php foreach ($whiteList as $label): ?>
                            <th><?= e($label) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $row): ?>
                        <tr>
                            <?php foreach ($whiteList as $key => $label): ?>
                                <td><?= isset($row[$key]) ? e($row[$key]) : '' ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <h1>Selamat datang, <?= e($profile['name']) ?></h1>
        <div class="card">
            <div class="actions">
                <a href="logout.php" class="btn">Logout</a>
            </div>
            <hr>
            <div class="card-header">Data Anda</div>
            <table>
                <thead>
                    <?php foreach($whiteList as $key => $label): ?>
                        <?php if(isset($profile[$key]) && $profile[$key] !== ''): ?>
                            <tr>
                                <th><?= e($label) ?></th>
                                <td class="td-user"><?= e($profile[$key]) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </thead>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>