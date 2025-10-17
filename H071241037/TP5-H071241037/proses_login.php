<?php
session_start();

// Mengimpor data pengguna
require 'data.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_found = null;

    // Cari pengguna berdasarkan username
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $user_found = $user;
            break;
        }
    }

    // Verifikasi password jika user ditemukan
    if ($user_found && password_verify($password, $user_found['password'])) {
        // Jika berhasil, simpan data user ke session dan arahkan ke dashboard
        $_SESSION['user'] = $user_found;
        header('Location: dashboard.php');
        exit;
    } else {
        // Jika gagal, buat pesan error dan kembali ke halaman login
        $_SESSION['error'] = 'Username atau password salah!';
        header('Location: login.php');
        exit;
    }
} else {
    // Jika halaman diakses tanpa metode POST, kembalikan ke login
    header('Location: login.php');
    exit;
}
?>