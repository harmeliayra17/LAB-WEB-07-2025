<?php
// functions.php - Helper functions (e.g., for authentication)

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function redirectBasedOnRole() {
    $role = getUserRole();
    if ($role === 'super_admin') {
        header('Location: super_admin_dashboard.php');
    } elseif ($role === 'project_manager') {
        header('Location: pm_dashboard.php');
    } elseif ($role === 'team_member') {
        header('Location: tm_dashboard.php');
    } else {
        header('Location: login.php');
    }
    exit;
}