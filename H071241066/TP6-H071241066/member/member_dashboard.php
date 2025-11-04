<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'MEMBER') {
    die("Akses ditolak. Halaman ini hanya untuk member.");
}

$member_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];
$message = "";

if (isset($_POST['update_status'])) {
    $task_id = (int)$_POST['task_id'];
    $status_baru = $_POST['status'];

    // pastikan tugas benar milik member ini
    $cek = mysqli_prepare($conn, "SELECT id FROM tasks WHERE id=? AND assigned_to=?");
    mysqli_stmt_bind_param($cek, "ii", $task_id, $member_id);
    mysqli_stmt_execute($cek);
    $result = mysqli_stmt_get_result($cek);
    $task = mysqli_fetch_assoc($result);
    mysqli_stmt_close($cek);

    if ($task) {
        $update = mysqli_prepare($conn, "UPDATE tasks SET status=? WHERE id=?");
        mysqli_stmt_bind_param($update, "si", $status_baru, $task_id);
        mysqli_stmt_execute($update);
        mysqli_stmt_close($update);
        $message = "Status tugas berhasil diperbarui.";
    } else {
        $message = "Gagal memperbarui status — tugas tidak ditemukan.";
    }
}


$stmt = mysqli_prepare($conn, "
    SELECT t.id, t.nama_tugas, t.deskripsi, t.status, p.nama_proyek, u.username AS manager_name
    FROM tasks t
    JOIN projects p ON t.project_id = p.id
    JOIN users u ON p.manager_id = u.id
    WHERE t.assigned_to = ?
    ORDER BY t.id DESC
");
mysqli_stmt_bind_param($stmt, "i", $member_id);
mysqli_stmt_execute($stmt);
$tugas = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .transition { transition: all 0.3s ease-in-out; }
        .card:hover { transform: scale(1.03); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-indigo-700 flex items-center space-x-2">
            <span>Dashboard Member - <?= htmlspecialchars($username) ?></span>
        </h1>
        <a href="../logout.php"
           class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 
                      2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
            </svg>
            Logout
        </a>
    </div>
</header>


<main class="max-w-7xl mx-auto px-6 py-10 space-y-10">

    <?php if (!empty($message)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg font-semibold shadow">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-indigo-600 pl-3">Daftar tugas Anda</h2>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama tugas</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Proyek</th>
                        <th class="px-6 py-4 font-semibold">Manager</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (mysqli_num_rows($tugas) === 0): ?>
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500 font-semibold">Belum ada tugas yang ditugaskan.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($t = mysqli_fetch_assoc($tugas)): ?>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($t['deskripsi']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-lg text-sm font-semibold
                                        <?= $t['status'] === 'Selesai' ? 'bg-green-100 text-green-700' : 
                                           ($t['status'] === 'Sedang Dikerjakan' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') ?>">
                                        <?= htmlspecialchars($t['status']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($t['nama_proyek']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($t['manager_name']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" class="flex justify-center items-center space-x-2">
                                        <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                                        <select name="status" required
                                            class="border-2 border-gray-300 rounded-lg px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                            <?php 
                                            $statuses = ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'];
                                            foreach ($statuses as $status): ?>
                                                <option value="<?= $status ?>" <?= $t['status'] === $status ? 'selected' : '' ?>>
                                                    <?= $status ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" name="update_status" 
                                            class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-3 py-1 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M5 13l4 4L19 7" />
                                            </svg>
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>
