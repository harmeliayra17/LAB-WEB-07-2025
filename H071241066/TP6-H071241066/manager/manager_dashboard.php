<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'MANAGER') {
    die("Akses ditolak. Hanya Manager yang dapat mengakses halaman ini.");
}

$manager_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

if (isset($_GET['hapus_proyek'])) {
    $delete_id = (int)($_GET['hapus_proyek']);
    
    // Hapus semua tugas yang terkait dengan proyek
    $stmt1 = mysqli_prepare($conn, "DELETE FROM tasks WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt1, "i", $delete_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    // Hapus proyek yang dimiliki manager
    $stmt2 = mysqli_prepare($conn, "DELETE FROM projects WHERE id = ? AND manager_id = ?");
    mysqli_stmt_bind_param($stmt2, "ii", $delete_id, $manager_id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
    
    header("Location: manager_dashboard.php");
    exit;
}

//stats
$stmt = mysqli_prepare($conn, "
    SELECT 
        COUNT(DISTINCT p.id) as total_proyek,
        COUNT(t.id) as total_tugas,
        SUM(CASE WHEN t.status = 'Belum Dikerjakan' THEN 1 ELSE 0 END) as tugas_belum,
        SUM(CASE WHEN t.status = 'Sedang Dikerjakan' THEN 1 ELSE 0 END) as tugas_progress,
        SUM(CASE WHEN t.status = 'Selesai' THEN 1 ELSE 0 END) as tugas_selesai
    FROM projects p
    LEFT JOIN tasks t ON t.project_id = p.id
    WHERE p.manager_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$stats = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$total_proyek = $stats['total_proyek'];
$total_tugas = $stats['total_tugas'];
$tugas_belum = $stats['tugas_belum'];
$tugas_progress = $stats['tugas_progress'];
$tugas_selesai = $stats['tugas_selesai'];


// buat daftr proyek
$stmt = mysqli_prepare($conn, "
    SELECT id, nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai
    FROM projects 
    WHERE manager_id = ?
    ORDER BY id DESC
");
mysqli_stmt_bind_param($stmt, "i", $manager_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .transition { transition: all 0.3s ease-in-out; }
        .card:hover { transform: scale(1.03); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-blue-700 flex items-center space-x-2">
                <span>Dashboard Manager</span>
            </h1>
            <div class="flex space-x-4">
                <a href="crud_proyek.php" 
                   class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah proyek
                </a>
                <a href="../logout.php" 
                   class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 
                              2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </header>


    <main class="max-w-7xl mx-auto px-6 py-10 space-y-12">

        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-indigo-600 pl-3">Ringkasan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="card bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 border-l-4 border-indigo-600">
                    <div class="bg-indigo-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 7l9-4 9 4-9 4-9-4zM3 10l9 4 9-4m-9 4v6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 font-medium">Total proyek</p>
                        <h3 class="text-3xl font-bold text-indigo-700"><?= $total_proyek ?></h3>
                    </div>
                </div>

                <div class="card bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 border-l-4 border-purple-600">
                    <div class="bg-purple-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 font-medium">Total tugas</p>
                        <h3 class="text-3xl font-bold text-purple-700"><?= $total_tugas ?></h3>
                    </div>
                </div>

                <div class="card bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-600">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Status tugas</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-red-600 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="8" />
                                </svg>
                                <span>Belum dikerjakan</span>
                            </div>
                            <span><?= $tugas_belum ?></span>
                        </div>

                        <div class="flex justify-between items-center text-yellow-600 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="8" />
                                </svg>
                                <span>Dalam progress</span>
                            </div>
                            <span><?= $tugas_progress ?></span>
                        </div>

                        <div class="flex justify-between items-center text-green-600 font-medium">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="8" />
                                </svg>
                                <span>Selesai</span>
                            </div>
                            <span><?= $tugas_selesai ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-indigo-600 pl-3">Daftar proyek</h2>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama proyek</th>
                            <th class="px-6 py-4 font-semibold">Deskripsi</th>
                            <th class="px-6 py-4 font-semibold">Mulai</th>
                            <th class="px-6 py-4 font-semibold">Selesai</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (count($projects) === 0): ?>
                            <tr><td colspan="5" class="text-center py-6 text-gray-500 font-semibold">Belum ada proyek ditambahkan.</td></tr>
                        <?php else: ?>
                            <?php foreach ($projects as $p): ?>
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['deskripsi']) ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="crud_proyek.php?edit_id=<?= $p['id'] ?>" 
                                           class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-3 py-2 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l9.5-9.5-5.5-5.5L4 13.5z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="manager_dashboard.php?hapus_proyek=<?= $p['id'] ?>" 
                                           onclick="return confirm('Yakin ingin menghapus proyek ini beserta semua tugasnya?')" 
                                           class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-2 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4" />
                                            </svg>
                                            Hapus
                                        </a>
                                        <a href="crud_tugas.php?project_id=<?= $p['id'] ?>" 
                                           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h5l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2z" />
                                            </svg>
                                            Tugas
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</body>
</html>