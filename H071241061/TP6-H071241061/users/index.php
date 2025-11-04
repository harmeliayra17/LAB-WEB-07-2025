<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header('Location: ../login.php');
    exit();
}

// Ambil semua user beserta nama Project Manager mereka
$stmt = $conn->prepare("
    SELECT u.*, pm.username AS manager_name
    FROM users u
    LEFT JOIN users pm ON u.project_manager_id = pm.id
    ORDER BY u.role, u.username
");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
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
                <h1 class="text-3xl font-bold text-gray-800">Kelola Pengguna</h1>
                <p class="text-gray-600 mt-2">Tambah dan hapus Project Manager & Team Member</p>
            </div>
            <a href="add.php" class="bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Pengguna
            </a>
        </div>

        <!-- Tabel Users -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-pink-400 to-pink-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Manager</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php 
                    $no = 1;
                    while ($user = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr class="hover:bg-pink-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo $no++; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-pink-400 to-pink-500 flex items-center justify-center text-white font-bold">
                                        <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-800"><?php echo $user['username']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user['role'] == 'Super Admin'): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Super Admin
                                </span>
                            <?php elseif ($user['role'] == 'Project Manager'): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Project Manager
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Team Member
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <?php echo $user['manager_name'] ? $user['manager_name'] : '-'; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <?php if ($user['role'] != 'Super Admin'): ?>
                                <a href="delete.php?id=<?php echo $user['id']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus user ini?')"
                                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transition inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">Tidak dapat dihapus</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>