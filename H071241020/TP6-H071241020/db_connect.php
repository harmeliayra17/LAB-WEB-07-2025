<?php
// db_connect.php - Database connection file

$host = 'localhost';
$db = 'db_manajemen_proyek';
$user = 'root'; // Change to your MySQL username
$pass = ''; // Change to your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}