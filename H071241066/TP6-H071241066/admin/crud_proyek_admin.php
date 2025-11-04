<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'ADMIN') {
    die("Akses ditolak. Hanya Admin yang dapat mengakses halaman ini.");
}

$message = "";


if (isset($_GET['hapus_id'])) {
    $hapus_id = (int) $_GET['hapus_id'];

    $cek = mysqli_prepare($conn, "SELECT id FROM projects WHERE id = ?");
    mysqli_stmt_bind_param($cek, "i", $hapus_id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) === 0) {
        $message = "<p class='text-red-600 font-medium'>Proyek tidak ditemukan!</p>";
    } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $hapus_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "<p class='text-green-600 font-medium'>Proyek berhasil dihapus!</p>";
        } else {
            $message = "<p class='text-red-600 font-medium'>Gagal menghapus proyek: " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_stmt_close($cek);
}

// --- Ambil semua proyek sm nama manager ---
$query = "SELECT p.*, u.username AS manager_name 
          FROM projects p 
          JOIN users u ON p.manager_id = u.id";
$result = mysqli_query($conn, $query);

$projects = [];
while ($row = mysqli_fetch_assoc($result)) {
    $projects[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Proyek (Admin)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen p-8">

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white flex justify-between items-center">
            <h1 class="text-2xl font-bold">Kelola Proyek (Admin)</h1>
            <a href="admin_dashboard.php" class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">
                ← Kembali
            </a>
        </div>

        <div class="p-8 space-y-6">
            <?php if (!empty($message)): ?>
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- TABEL PROYEK -->
            <div class="bg-white border rounded-xl shadow-md overflow-x-auto">
                <?php if (empty($projects)): ?>
                    <div class="p-6 text-center text-gray-500">Belum ada proyek yang terdaftar.</div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Proyek</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Mulai</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal Selesai</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Manager</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs"><?= htmlspecialchars($p['deskripsi']) ?></td>
                                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($p['manager_name']) ?></td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="?hapus_id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus proyek ini?')" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-lg text-sm font-medium">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
