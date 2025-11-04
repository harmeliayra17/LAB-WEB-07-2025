<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Team Member') {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';
$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data tugas (hanya miliknya)
$query = "SELECT t.*, p.nama_proyek 
          FROM tasks t 
          JOIN projects p ON t.project_id = p.id 
          WHERE t.id='$id' AND t.assigned_to='$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$task = mysqli_fetch_assoc($result);

// Proses update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    
    $update_query = "UPDATE tasks SET status='$status' WHERE id='$id'";
    
    if (mysqli_query($conn, $update_query)) {
        $success = 'Status tugas berhasil diupdate!';
        // Refresh data tugas
        $result = mysqli_query($conn, $query);
        $task = mysqli_fetch_assoc($result);
    } else {
        $error = 'Gagal mengupdate status: ' . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Tugas</title>
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
                    <a href="index.php" class="text-gray-600 hover:text-pink-600 font-semibold">Tugas Saya</a>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Update Status Tugas</h1>
            <p class="text-gray-600 mt-2">Perbarui status perkembangan tugas Anda</p>
        </div>

        <!-- Detail Tugas Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Tugas</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nama Tugas</p>
                    <p class="text-lg font-semibold text-gray-800"><?php echo $task['nama_tugas']; ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Proyek</p>
                    <p class="text-gray-800"><?php echo $task['nama_proyek']; ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="text-gray-800"><?php echo $task['deskripsi']; ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Saat Ini</p>
                    <?php if ($task['status'] == 'belum'): ?>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Belum Dikerjakan
                        </span>
                    <?php elseif ($task['status'] == 'proses'): ?>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Sedang Dikerjakan
                        </span>
                    <?php else: ?>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Selesai
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Update Status -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <?php echo $success; ?>
                    <a href="index.php" class="font-semibold underline ml-2">Kembali ke daftar tugas</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Ubah Status <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 transition <?php echo ($task['status'] == 'belum') ? 'border-pink-500 bg-pink-50' : ''; ?>">
                            <input type="radio" name="status" value="belum" <?php echo ($task['status'] == 'belum') ? 'checked' : ''; ?> 
                                   class="w-4 h-4 text-pink-600 focus:ring-pink-500">
                            <div class="ml-3">
                                <span class="block font-semibold text-gray-800">Belum Dikerjakan</span>
                                <span class="block text-xs text-gray-500">Tugas belum dimulai</span>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-yellow-300 transition <?php echo ($task['status'] == 'proses') ? 'border-yellow-500 bg-yellow-50' : ''; ?>">
                            <input type="radio" name="status" value="proses" <?php echo ($task['status'] == 'proses') ? 'checked' : ''; ?>
                                   class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                            <div class="ml-3">
                                <span class="block font-semibold text-gray-800">Sedang Dikerjakan</span>
                                <span class="block text-xs text-gray-500">Tugas sedang dalam proses</span>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-300 transition <?php echo ($task['status'] == 'selesai') ? 'border-green-500 bg-green-50' : ''; ?>">
                            <input type="radio" name="status" value="selesai" <?php echo ($task['status'] == 'selesai') ? 'checked' : ''; ?>
                                   class="w-4 h-4 text-green-600 focus:ring-green-500">
                            <div class="ml-3">
                                <span class="block font-semibold text-gray-800">Selesai</span>
                                <span class="block text-xs text-gray-500">Tugas sudah selesai dikerjakan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                        Update Status
                    </button>
                    <a href="index.php" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>