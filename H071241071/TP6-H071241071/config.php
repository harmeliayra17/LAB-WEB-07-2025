<?php
session_start();
$host = 'localhost'; $dbname = 'db_manajemen_proyek'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) { die("Koneksi gagal: " . $e->getMessage()); }

function isLoggedIn() { return isset($_SESSION['user_id']); }
function getUserRole() { return $_SESSION['role'] ?? null; }
function redirect($url) { header("Location: $url"); exit(); }
function isSuperAdmin() { return getUserRole() === 'super_admin'; }
function isProjectManager() { return getUserRole() === 'project_manager'; }
function isTeamMember() { return getUserRole() === 'team_member'; }
?>