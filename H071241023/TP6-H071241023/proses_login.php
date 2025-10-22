<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';
require __DIR__ . '/config/config.php'; 

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: /TP-6/login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

try {
    $sql  = 'SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1';
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception('Prepare gagal: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) === 0) {
        mysqli_stmt_close($stmt);
        $_SESSION['error'] = 'Username tidak ditemukan.';
        header('Location: /TP-6/login.php');
        exit;
    }

    mysqli_stmt_bind_result($stmt, $id, $uname, $hash, $role);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!password_verify($password, $hash)) {
        $_SESSION['error'] = 'Password salah.';
        header('Location: /TP-6/login.php');
        exit;
    }

    $_SESSION['user'] = [
        'id'       => (int)$id,
        'username' => $uname,
        'role'     => $role, 
    ];

    redirectByRole();

} catch (Throwable $e) {
    $_SESSION['error'] = 'Terjadi kesalahan server.';
    header('Location: /TP-6/login.php');
    exit;
}
?>