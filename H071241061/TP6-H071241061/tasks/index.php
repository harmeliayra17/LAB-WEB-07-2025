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
    // Super Admin lihat semua tugas
    $query = "SELECT t.*, p.nama_proyek, u.username as assigned_name 
              FROM tasks t 
              JOIN projects p ON t.project_id = p.id 
              LEFT JOIN users u ON t.assigned_to = u.id 
              ORDER BY t.id DESC";
} elseif ($role == 'Project Manager') {
    // Project Manager lihat tugas di proyeknya
    $query = "SELECT t.*, p.nama_proyek, u.username as assigned_name 
              FROM tasks t 
              JOIN projects p ON t.project_id = p.id 
              LEFT JOIN users u ON t.assigned_to = u.id 
              WHERE p.manager_id = '$user_id' 
              ORDER BY t.id DESC";
} else {
    // Team Member hanya lihat tugasnya
    $query = "SELECT t.*, p.nama_proyek, u.username as assigned_name 
              FROM tasks t 
              JOIN projects p ON t.project_id = p.id 
              LEFT JOIN users u ON t.assigned_to = u.id 
              WHERE t.assigned_to = '$user_id' 
              ORDER BY t.id DESC";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Daftar Tugas</h1>
                <p class="text-gray-600 mt-2">
                    <?php 
                    if ($role == 'Super Admin') {
                        echo 'Semua tugas dari semua proyek';
                    } elseif ($role == 'Project Manager') {
                        echo 'Kelola tugas di proyek Anda';
                    } else {
                        echo 'Tugas yang ditugaskan kepada Anda';
                    }
                    ?>
                </p>
            </div>
            <?php if ($role == 'Project Manager'): ?>
                <a href="add.php" class="bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Tugas
                </a>
            <?php endif; ?>
        </div>

        <!-- Tabel Tugas -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-pink-400 to-pink-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Tugas</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Proyek</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Ditugaskan Ke</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                            $no = 1;
                            while ($task = mysqli_fetch_assoc($result)): 
                            ?>
                            <tr class="hover:bg-pink-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $no++; ?></td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800"><?php echo $task['nama_tugas']; ?></div>
                                    <div class="text-xs text-gray-500"><?php echo substr($task['deskripsi'], 0, 50); ?>...</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $task['nama_proyek']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo $task['assigned_name'] ? $task['assigned_name'] : '-'; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($task['status'] == 'belum'): ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Belum
                                        </span>
                                    <?php elseif ($task['status'] == 'proses'): ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Proses
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <?php if ($role == 'Project Manager'): ?>
                                        <div class="flex justify-center space-x-2">
                                            <a href="edit.php?id=<?php echo $task['id']; ?>" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Edit
                                            </a>
                                            <a href="delete.php?id=<?php echo $task['id']; ?>" 
                                               onclick="return confirm('Yakin ingin menghapus tugas ini?')"
                                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Hapus
                                            </a>
                                        </div>
                                    <?php elseif ($role == 'Team Member'): ?>
                                        <a href="update_status.php?id=<?php echo $task['id']; ?>" 
                                           class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            Update Status
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">Hanya Lihat</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Tugas</h3>
                <p class="text-gray-600 mb-6">
                    <?php 
                    if ($role == 'Project Manager') {
                        echo 'Mulai dengan menambahkan tugas pertama!';
                    } else {
                        echo 'Belum ada tugas yang ditugaskan kepada Anda.';
                    }
                    ?>
                </p>
                <?php if ($role == 'Project Manager'): ?>
                    <a href="add.php" class="inline-block bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition">
                        Tambah Tugas Pertama
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>