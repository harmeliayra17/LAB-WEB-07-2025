<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Hapus tugas (hanya dari proyek miliknya)
$query = "DELETE t FROM tasks t 
          JOIN projects p ON t.project_id = p.id 
          WHERE t.id='$id' AND p.manager_id='$user_id'";

mysqli_query($conn, $query);

header('Location: index.php');
exit();
?>