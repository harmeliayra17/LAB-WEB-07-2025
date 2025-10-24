<?php
session_start();

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function userRole(): ?string {
    return $_SESSION['user']['role'] ?? null;
}

function requiredLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /TP-6/login.php');
        exit;
    }
}

function requiredRole(string|array $roles): void {
    requiredLogin();
    $roles = (array)$roles;
    if (!in_array(userRole(), $roles, true)) {
        echo '<p>Akses ditolak untuk peran Anda.</p>';
        exit; 
    }
}

function redirectByRole(): void {
    requiredLogin();
    
    switch (userRole()) {
        case 'super_admin':
            header('Location: /TP-6/dashboard/superAdmin.php');
            break;
        case 'project_manager':
            header('Location: /TP-6/dashboard/projectManager.php');
            break;
        case 'team_member':
            header('Location: /TP-6/dashboard/teamMember.php');
            break;
        default:
            session_destroy();
            header('Location: /TP-6/login.php');
    }
    exit;
}
?>