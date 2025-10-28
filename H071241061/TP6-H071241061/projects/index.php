<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'Super Admin') {
    // Super Admin lihat semua proyek dengan nama Project Manager
    $query = "SELECT p.*, u.username as manager_name 
              FROM projects p 
              JOIN users u ON p.manager_id = u.id 
              ORDER BY p.id DESC";
} elseif ($role == 'Project Manager') {
    // Project Manager hanya lihat proyeknya
    $query = "SELECT p.*, u.username as manager_name 
              FROM projects p 
              JOIN users u ON p.manager_id = u.id 
              WHERE p.manager_id = '$user_id' 
              ORDER BY p.id DESC";
} else {
    // Team Member lihat proyek yang ada tugasnya DISTINCT biar gak duplikat
    $query = "SELECT DISTINCT p.*, u.username as manager_name  
              FROM projects p 
              JOIN users u ON p.manager_id = u.id 
              JOIN tasks t ON p.id = t.project_id 
              WHERE t.assigned_to = '$user_id' 
              ORDER BY p.id DESC";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../dashboard.php" class="flex items-center">
                        <div class="bg-gradient-to-r from-pink-400 to-pink-600 w-10 h-10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-800">Manajemen Proyek</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="../dashboard.php" class="text-gray-600 hover:text-pink-600 font-semibold">Dashboard</a>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800"><?php echo $_SESSION['username']; ?></p>
                        <p class="text-xs text-pink-600"><?php echo $_SESSION['role']; ?></p>
                    </div>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Proyek</h1>
                <p class="text-gray-600 mt-2">
                    <?php 
                    if ($role == 'Super Admin') {
                        echo 'Semua proyek dari Project Manager';
                    } elseif ($role == 'Project Manager') {
                        echo 'Kelola proyek Anda';
                    } else {
                        echo 'Proyek yang Anda ikuti';
                    }
                    ?>
                </p>
            </div>
            <?php if ($role == 'Project Manager'): ?>
                <a href="add.php" class="bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Proyek
                </a>
            <?php endif; ?>
        </div>

        <!-- Grid Proyek -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($project = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1">
                        <!-- Header Card -->
                        <div class="bg-gradient-to-r from-pink-400 to-pink-600 p-6">
                            <h3 class="text-xl font-bold text-white mb-2"><?php echo $project['nama_proyek']; ?></h3>
                            <p class="text-pink-100 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo $project['manager_name']; ?>
                            </p>
                        </div>

                        <!-- Body Card -->
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?php echo $project['deskripsi']; ?>
                            </p>

                            <!-- Tanggal -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-semibold">Mulai:</span>
                                    <span class="ml-2"><?php echo date('d M Y', strtotime($project['tanggal_mulai'])); ?></span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-semibold">Selesai:</span>
                                    <span class="ml-2"><?php echo date('d M Y', strtotime($project['tanggal_selesai'])); ?></span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <?php if ($role == 'Project Manager' && $project['manager_id'] == $user_id): ?>
                                    <a href="edit.php?id=<?php echo $project['id']; ?>" 
                                       class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-lg text-sm font-semibold transition">
                                        Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $project['id']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                       class="flex-1 bg-red-500 hover:bg-red-600 text-white text-center py-2 rounded-lg text-sm font-semibold transition">
                                        Hapus
                                    </a>
                                <?php elseif ($role == 'Super Admin'): ?>
                                    <a href="delete.php?id=<?php echo $project['id']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus proyek ini?')"
                                       class="flex-1 bg-red-500 hover:bg-red-600 text-white text-center py-2 rounded-lg text-sm font-semibold transition">
                                        Hapus Proyek
                                    </a>
                                <?php else: ?>
                                    <div class="flex-1 bg-gray-300 text-gray-600 text-center py-2 rounded-lg text-sm font-semibold">
                                        Hanya Lihat
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Proyek</h3>
                <p class="text-gray-600 mb-6">
                    <?php 
                    if ($role == 'Project Manager') {
                        echo 'Mulai dengan menambahkan proyek pertama Anda!';
                    } else {
                        echo 'Tidak ada proyek yang tersedia saat ini.';
                    }
                    ?>
                </p>
                <?php if ($role == 'Project Manager'): ?>
                    <a href="add.php" class="inline-block bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
                        Tambah Proyek Pertama
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>