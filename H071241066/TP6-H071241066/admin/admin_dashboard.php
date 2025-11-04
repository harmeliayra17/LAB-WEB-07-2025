<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'ADMIN') {
    die("Akses ditolak. Hanya Admin yang dapat mengakses halaman ini.");
}

if (isset($_GET['hapus_id'])) {
    $hapus_id = (int) $_GET['hapus_id'];
    $cek = mysqli_query($conn, "SELECT role FROM users WHERE id = $hapus_id");
    if ($cek && mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        if (strtoupper($data['role']) !== 'ADMIN') {
            mysqli_query($conn, "DELETE FROM users WHERE id = $hapus_id");
        }
    }
    header("Location: admin_dashboard.php");
    exit();
}
//stats
$total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$total_proyek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM projects"))['total'];
$total_tugas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tasks"))['total'];


$users = mysqli_query($conn, "
    SELECT 
        u.id, 
        u.username, 
        UPPER(u.role) AS role, 
        COALESCE(m.username, '-') AS manager 
    FROM users u
    LEFT JOIN users m ON u.project_manager_id = m.id
");


$projects = mysqli_query($conn, "
    SELECT 
        p.id, 
        p.nama_proyek, 
        p.deskripsi, 
        p.tanggal_mulai, 
        p.tanggal_selesai,
        COALESCE(u.username, '-') AS manager_name
    FROM projects p
    LEFT JOIN users u ON p.manager_id = u.id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card:hover { transform: scale(1.03); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .transition { transition: all 0.3s ease-in-out; }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-50 via-blue-50 to-green-50 min-h-screen">

<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-indigo-700 flex items-center space-x-2">
            <span>Dashboard Admin</span>
        </h1>
        <div class="flex space-x-4">
            <a href="crud_user.php"
               class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah User
            </a>
            <a href="../logout.php"
               class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7
                          a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                </svg>
                Logout
            </a>
        </div>
    </div>
</header>


<main class="max-w-7xl mx-auto px-6 py-10 space-y-12">

    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-indigo-600 pl-3">Statistik</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="card bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 border-l-4 border-indigo-600">
                <div class="bg-indigo-100 p-4 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V8H2v12h5m10 0a3 3 0 0 0 3-3v-4a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v4a3 3 0 0 0 3 3h10z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Total User</p>
                    <h3 class="text-3xl font-bold text-indigo-700"><?= $total_user ?></h3>
                </div>
            </div>

            <div class="card bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 border-l-4 border-green-600">
                <div class="bg-green-100 p-4 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zM3 14l9 4 9-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Total Proyek</p>
                    <h3 class="text-3xl font-bold text-green-700"><?= $total_proyek ?></h3>
                </div>
            </div>

            <div class="card bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 border-l-4 border-blue-600">
                <div class="bg-blue-100 p-4 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 font-medium">Total Tugas</p>
                    <h3 class="text-3xl font-bold text-blue-700"><?= $total_tugas ?></h3>
                </div>
            </div>
        </div>
    </section>

    <!-- DAFTAR USER -->
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-indigo-600 pl-3">Daftar User</h2>
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Username</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Manager</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (mysqli_num_rows($users) === 0): ?>
                        <tr><td colspan="4" class="text-center py-6 text-gray-500 font-semibold">Belum ada user terdaftar.</td></tr>
                    <?php else: ?>
                        <?php while ($u = mysqli_fetch_assoc($users)): ?>
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($u['username']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($u['role']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($u['manager']) ?></td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <?php if ($u['role'] !== 'ADMIN'): ?>
                                        <a href="crud_user.php?edit_id=<?= $u['id'] ?>" 
                                           class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-3 py-2 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l9.5-9.5-5.5-5.5L4 13.5z" />
                                            </svg>Edit
                                        </a>
                                        <a href="?hapus_id=<?= $u['id'] ?>" 
                                           onclick="return confirm('Yakin ingin menghapus user ini?')"
                                           class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-2 rounded-lg text-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4" />
                                            </svg>Hapus
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic bold font-medium">Tidak dapat diubah</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- DAFTAR PROYEK -->
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-8 border-green-600 pl-3">Daftar Proyek</h2>
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Proyek</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold">Manager</th>
                        <th class="px-6 py-4 font-semibold">Mulai</th>
                        <th class="px-6 py-4 font-semibold">Selesai</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (mysqli_num_rows($projects) === 0): ?>
                        <tr><td colspan="6" class="text-center py-6 text-gray-500 font-semibold">Belum ada proyek ditambahkan.</td></tr>
                    <?php else: ?>
                        <?php while ($p = mysqli_fetch_assoc($projects)): ?>
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['deskripsi']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['manager_name']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['tanggal_mulai']) ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($p['tanggal_selesai']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="crud_proyek_admin.php?kelola_id=<?= $p['id'] ?>" 
                                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12z" />
                                        </svg>Kelola
                                    </a>
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
