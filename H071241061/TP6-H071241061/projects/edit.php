<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

$id = (int)$_GET['id']; 
$user_id = (int)$_SESSION['user_id'];

// Ambil data proyek (hanya milik manager yang login)
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    header('Location: index.php');
    exit();
}
$project = $res->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_proyek = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $mulai = DateTime::createFromFormat('Y-m-d', $tanggal_mulai);
    $selesai = DateTime::createFromFormat('Y-m-d', $tanggal_selesai);

    if (!$mulai || !$selesai) {
        $error = 'Format tanggal tidak valid!';
    } elseif ($selesai < $mulai) {
        $error = 'Tanggal selesai harus setelah tanggal mulai!';
    } else {
        $stmt = $conn->prepare("
            UPDATE projects 
            SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? 
            WHERE id = ? AND manager_id = ?
        ");
        $stmt->bind_param("ssssii", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $id, $user_id);

        if ($stmt->execute()) {
            $success = 'Proyek berhasil diupdate!';

            $stmt2 = $conn->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
            $stmt2->bind_param("ii", $id, $user_id);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            $project = $res2->fetch_assoc();
            $stmt2->close();
        } else {
            $error = 'Gagal mengupdate proyek: ' . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
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
                    <a href="index.php" class="text-gray-600 hover:text-pink-600 font-semibold">Proyek</a>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Proyek</h1>
            <p class="text-gray-600 mt-2">Update informasi proyek Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <!-- Nama Proyek -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Nama Proyek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_proyek" required 
                           value="<?php echo $project['nama_proyek']; ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" required rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"><?php echo $project['deskripsi']; ?></textarea>
                </div>

                <!-- Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" required 
                               value="<?php echo $project['tanggal_mulai']; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai" required 
                               value="<?php echo $project['tanggal_selesai']; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                        Update Proyek
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