<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'MANAGER') {
    die("Akses ditolak. Hanya Manager yang dapat mengakses halaman ini.");
}

$user_id = $_SESSION['user']['id'];
$pemberitahuan = "";

if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE id=? AND manager_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $pemberitahuan = "Proyek berhasil dihapus.";
}

if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    if (empty($nama) || empty($mulai) || empty($selesai)) {
        $pemberitahuan = "Semua field wajib diisi!";
    } else {
        $cek = mysqli_prepare($conn, "SELECT COUNT(*) FROM projects WHERE nama_proyek=? AND manager_id=?");
        mysqli_stmt_bind_param($cek, "si", $nama, $user_id);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlah);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ($jumlah > 0) {
            $pemberitahuan = "Nama proyek '$nama' sudah ada!";
        } else {
            $sql = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssi", $nama, $deskripsi, $mulai, $selesai, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $pemberitahuan = "Proyek '$nama' berhasil ditambahkan.";
        }
    }
}



// ambil data proyek untuk diedit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM projects WHERE id=? AND manager_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $edit_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// update kde db
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];

    $sql = "UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=? 
            WHERE id=? AND manager_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $nama, $deskripsi, $mulai, $selesai, $id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $pemberitahuan = "Proyek berhasil diperbarui.";
    header("Location: manager_dashboard.php");
    exit;
}


// ambil data proyek
$res = mysqli_prepare($conn, "SELECT * FROM projects WHERE manager_id=? ORDER BY id DESC");
mysqli_stmt_bind_param($res, "i", $user_id);
mysqli_stmt_execute($res);
$result = mysqli_stmt_get_result($res);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($res);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

<header class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-6 shadow-xl">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Kelola Proyek</h1>
        <div class="space-x-3">
            <a href="manager_dashboard.php" class="bg-white/20 hover:bg-white/30 px-5 py-2.5 rounded-lg font-semibold transition">← Dashboard</a>
            <a href="../logout.php" class="bg-red-500 hover:bg-red-600 px-5 py-2.5 rounded-lg font-semibold transition">Logout</a>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto py-10 px-6 space-y-10">
    <?php if (!empty($pemberitahuan)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg"><?= $pemberitahuan ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-6 rounded-2xl shadow-xl space-y-6">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <div>
            <label class="block font-semibold mb-2">Nama Proyek</label>
            <input type="text" name="nama_proyek" required value="<?= htmlspecialchars($edit_data['nama_proyek'] ?? '') ?>"
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block font-semibold mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl"><?= htmlspecialchars($edit_data['deskripsi'] ?? '') ?></textarea>
        </div>
        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" required value="<?= htmlspecialchars($edit_data['tanggal_mulai'] ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
            </div>
            <div>
                <label class="block font-semibold mb-2">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" required value="<?= htmlspecialchars($edit_data['tanggal_selesai'] ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
            </div>
        </div>
        <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>" 
                class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-3 rounded-xl font-bold hover:from-indigo-700 hover:to-blue-700 transition">
            <?= $edit_data ? 'Simpan Perubahan' : '+ Tambah Proyek' ?>
        </button>
    </form>

    <!-- DAFTAR PROYEK -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-4 font-semibold text-lg">Daftar Proyek Anda</div>
        <div class="p-6 overflow-x-auto">
            <?php if (empty($projects)): ?>
                <p class="text-gray-500 text-center">Belum ada proyek yang dibuat.</p>
            <?php else: ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-left text-sm font-bold uppercase">
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Mulai</th>
                            <th class="px-4 py-3">Selesai</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($projects as $p): ?>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($p['nama_proyek']) ?></td>
                                <td class="px-4 py-3"><?= $p['tanggal_mulai'] ?></td>
                                <td class="px-4 py-3"><?= $p['tanggal_selesai'] ?></td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="crud_proyek.php?edit_id=<?= $p['id'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm">Edit</a>
                                    <a href="crud_proyek.php?hapus_id=<?= $p['id'] ?>" onclick="return confirm('Hapus proyek ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Hapus</a>
                                    <a href="crud_tugas.php?project_id=<?= $p['id'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Tugas</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>
