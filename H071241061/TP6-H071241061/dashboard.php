<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Query berdasarkan role
if ($role == 'Super Admin') {
    // Total proyek
    $stmt = $conn->prepare("SELECT COUNT(*) FROM projects");
    $stmt->execute();
    $stmt->bind_result($total_projects);
    $stmt->fetch(); 
    $stmt->close();
    // Total tugas
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks");
    $stmt->execute();
    $stmt->bind_result($total_tasks);
    $stmt->fetch();
    $stmt->close();
    // Total manajer proyek
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'Project Manager'");
    $stmt->execute();
    $stmt->bind_result($total_managers);
    $stmt->fetch();
    $stmt->close();
    // Total anggota tim
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'Team Member'");
    $stmt->execute();
    $stmt->bind_result($total_members);
    $stmt->fetch();
    $stmt->close();

} elseif ($role == 'Project Manager') {
    // Total proyek milik manager
    $stmt = $conn->prepare("SELECT COUNT(*) FROM projects WHERE manager_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_projects);
    $stmt->fetch();
    $stmt->close();
    // Total tugas di proyek manager
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE manager_id = ?)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_tasks);
    $stmt->fetch();
    $stmt->close();
    // Total tugas selesai
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE manager_id = ?) AND status = 'Selesai'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_selesai);
    $stmt->fetch();
    $stmt->close();

} elseif ($role == 'Team Member') {
    // Total tugas untuk anggota tim
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($total_tasks);
    $stmt->fetch();
    $stmt->close();
    // Total tugas selesai
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status = 'Selesai'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($task_selesai);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-pink-300 to-pink-600 w-10 h-10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-800">Manajemen Proyek</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800"><?php echo $_SESSION['username']; ?></p>
                        <p class="text-xs text-pink-600"><?php echo $role; ?></p>
                    </div>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-2">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
        </div>

        <!-- Statistik Cards -->
            <?php if ($role == 'Super Admin'): ?>
                <!-- Card Total Proyek -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Proyek</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_projects; ?></p>
                        </div>
                        <div class="bg-pink-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Total Tugas -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Tugas</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_tasks; ?></p>
                        </div>
                        <div class="bg-pink-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Project Managers -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Project Manager</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_managers; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Team Members -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Team Member</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_members; ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php elseif ($role == 'Project Manager'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Proyek Saya</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_projects; ?></p>
                        </div>
                        <div class="bg-pink-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Tugas</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_tasks; ?></p>
                        </div>
                        <div class="bg-pink-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Tugas Selesai</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_selesai; ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Total Tugas</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $total_tasks; ?></p>
                        </div>
                        <div class="bg-pink-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-semibold">Tugas Selesai</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo $task_selesai; ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Menu Navigation -->
            <?php if ($role == 'Super Admin'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="users/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Kelola Pengguna</h3>
                            <p class="text-gray-600 text-sm">Tambah & Hapus User</p>
                        </div>
                    </div>
                </a>

                <a href="projects/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Semua Proyek</h3>
                            <p class="text-gray-600 text-sm">Lihat & Hapus Proyek</p>
                        </div>
                    </div>
                </a>

                <a href="tasks/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Semua Tugas</h3>
                            <p class="text-gray-600 text-sm">Lihat Semua Tugas</p>
                        </div>
                    </div>
                </a>
            <?php elseif ($role == 'Project Manager'): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <a href="projects/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Proyek Saya</h3>
                            <p class="text-gray-600 text-sm">Kelola Proyek</p>
                        </div>
                    </div>
                </a>

                <a href="tasks/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Tugas Proyek</h3>
                            <p class="text-gray-600 text-sm">Kelola Tugas</p>
                        </div>
                    </div>
                </a>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <a href="projects/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Proyek Saya</h3>
                            <p class="text-gray-600 text-sm">Lihat Proyek</p>
                        </div>
                    </div>
                </a>

                <a href="tasks/index.php" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 p-4 rounded-full">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Tugas Saya</h3>
                            <p class="text-gray-600 text-sm">Update Status Tugas</p>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>