<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Super Admin bisa hapus semua, Project Manager hanya miliknya
if ($role == 'Super Admin') {
    $query = "DELETE FROM projects WHERE id='$id'";
} elseif ($role == 'Project Manager') {
    $query = "DELETE FROM projects WHERE id='$id' AND manager_id='$user_id'";
}

mysqli_query($conn, $query);

header('Location: index.php');
exit();
?>