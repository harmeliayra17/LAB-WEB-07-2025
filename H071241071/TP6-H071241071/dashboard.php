<?php
require_once 'config.php';
if (!isLoggedIn()) redirect('login.php');

$role = getUserRole();
$user_id = $_SESSION['user_id'];

$stats = ['projects' => 0, 'tasks' => 0, 'completed' => 0];
if (isSuperAdmin()) {
    $stats['projects'] = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $stats['tasks'] = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
    $stats['completed'] = $pdo->query("SELECT COUNT(*) FROM tasks WHERE status='selesai'")->fetchColumn();
} elseif (isProjectManager()) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE manager_id=?");
    $stmt->execute([$user_id]); $stats['projects'] = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks t JOIN projects p ON t.project_id=p.id WHERE p.manager_id=?");
    $stmt->execute([$user_id]); $stats['tasks'] = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks t JOIN projects p ON t.project_id=p.id WHERE p.manager_id=? AND t.status='selesai'");
    $stmt->execute([$user_id]); $stats['completed'] = $stmt->fetchColumn();
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to=?");
    $stmt->execute([$user_id]); $stats['tasks'] = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to=? AND status='selesai'");
    $stmt->execute([$user_id]); $stats['completed'] = $stmt->fetchColumn();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
            <p class="text-gray-600 mb-6">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> (<?= ucfirst($role) ?>)</p>
            
            <div class="grid <?= $role === 'team_member' ? 'md:grid-cols-2' : 'md:grid-cols-3' ?> gap-6">
                <?php if ($role !== 'team_member'): ?>
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold">Proyek</h3>
                    <p class="text-3xl font-bold text-blue-600"><?= $stats['projects'] ?></p>
                </div>
                <?php endif; ?>
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold">Tugas Selesai</h3>
                    <p class="text-3xl font-bold text-green-600"><?= $stats['completed'] ?></p>
                </div>
                <div class="bg-indigo-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold">Total Tugas</h3>
                    <p class="text-3xl font-bold text-indigo-600"><?= $stats['tasks'] ?></p>
                </div>
            </div>
        </div>
        <?php if (isSuperAdmin()): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="lg:col-span-1">
                    <a href="users.php" class="block bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow w-full">
                        <h3 class="font-semibold mb-2">Kelola Pengguna</h3>
                        <p class="text-sm text-gray-600">Tambah/hapus Project Manager & Team Member</p>
                    </a>
                </div>
                <div class="lg:col-span-1">
                    <a href="projects.php" class="block bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow w-full">
                        <h3 class="font-semibold mb-2">Kelola Proyek</h3>
                        <p class="text-sm text-gray-600">Lihat semua proyek</p>
                    </a>
                </div>
            </div>
        <?php elseif (isProjectManager()): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div>
                    <a href="projects.php" class="block bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow w-full">
                        <h3 class="font-semibold mb-2">Kelola Proyek</h3>
                        <p class="text-sm text-gray-600">Buat, lihat, edit, hapus proyek</p>
                    </a>
                </div>
                <div>
                    <a href="tasks.php" class="block bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow w-full">
                        <h3 class="font-semibold mb-2">Kelola Tugas</h3>
                        <p class="text-sm text-gray-600">Lihat dan kelola tugas</p>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                <div class="lg:col-span-1">
                    <a href="tasks.php" class="block bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition-shadow w-full">
                        <h3 class="font-semibold mb-2">Kelola Tugas</h3>
                        <p class="text-sm text-gray-600">Lihat dan update tugas saya</p>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="mt-6 text-center">
            <a href="logout.php" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">Logout</a>
        </div>
    </div>
</body>
</html>