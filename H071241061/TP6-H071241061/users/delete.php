<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil ID user yang akan dihapus
$id = $_GET['id'];

// Pastikan tidak menghapus Super Admin
$check = mysqli_query($conn, "SELECT role FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($check);

if ($user['role'] != 'Super Admin') {
    $query = "DELETE FROM users WHERE id='$id'";
    mysqli_query($conn, $query);
}

header('Location: index.php');
exit();
?>