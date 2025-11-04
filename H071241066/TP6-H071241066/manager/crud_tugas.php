<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'MANAGER') {
    die("Akses ditolak. Hanya Manager yang dapat mengakses halaman ini.");
}

$manager_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];


if (!isset($_GET['project_id'])) {
    die("ID proyek tidak ditemukan.");
}
$project_id = (int)$_GET['project_id'];

// cek apakah proyek milik manager ini
$cek_proyek = mysqli_prepare($conn, "SELECT * FROM projects WHERE id=? AND manager_id=?");
mysqli_stmt_bind_param($cek_proyek, "ii", $project_id, $manager_id);
mysqli_stmt_execute($cek_proyek);
$hasil_cek = mysqli_stmt_get_result($cek_proyek);
$project = mysqli_fetch_assoc($hasil_cek);
mysqli_stmt_close($cek_proyek);

if (!$project) die("Akses ditolak. Proyek tidak ditemukan atau bukan milik Anda.");

$message = "";

if (isset($_POST['tambah'])) {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $member_id = (int)$_POST['member_id'];

    if (empty($nama_tugas) || empty($member_id)) {
        $message = "Nama tugas dan member wajib diisi!";
    } else {
        $stmt = mysqli_prepare($conn, "
            INSERT INTO tasks (project_id, nama_tugas, deskripsi, status, assigned_to)
            VALUES (?, ?, ?, 'Belum Dikerjakan', ?)
        ");
        mysqli_stmt_bind_param($stmt, "issi", $project_id, $nama_tugas, $deskripsi, $member_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $message = "Tugas baru berhasil ditambahkan.";
    }
}

if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];
    $stmt = mysqli_prepare($conn, "
        DELETE FROM tasks 
        WHERE id=? AND project_id IN (SELECT id FROM projects WHERE manager_id=?)
    ");
    mysqli_stmt_bind_param($stmt, "ii", $hapus_id, $manager_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $message = "Tugas berhasil dihapus.";
}

// ambil data tugas untuk ditampilkan 
$stmt = mysqli_prepare($conn, "
    SELECT t.*, u.username AS member_name 
    FROM tasks t
    LEFT JOIN users u ON t.assigned_to = u.id
    WHERE t.project_id = ?
    ORDER BY t.id DESC
");
mysqli_stmt_bind_param($stmt, "i", $project_id);
mysqli_stmt_execute($stmt);
$tasks = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);


// buat update tugas
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM tasks WHERE id=? AND project_id=?");
    mysqli_stmt_bind_param($stmt, "ii", $edit_id, $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// kirim ke db nya
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $status = $_POST['status'];
    $member_id = (int)$_POST['member_id'];

    $stmt = mysqli_prepare($conn, "
        UPDATE tasks 
        SET nama_tugas=?, deskripsi=?, status=?, assigned_to=? 
        WHERE id=? AND project_id IN (SELECT id FROM projects WHERE manager_id=?)
    ");
    mysqli_stmt_bind_param($stmt, "sssiii", $nama_tugas, $deskripsi, $status, $member_id, $id, $manager_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $message = "Tugas berhasil diperbarui.";
    header("Location: crud_tugas.php?project_id=" . $project_id);
    exit();
}

// Ambil daftar member untuk dropdown (HANYA 1 KALI QUERY)
$stmt_members = mysqli_prepare($conn, "SELECT id, username FROM users WHERE role='MEMBER' AND project_manager_id=?");
mysqli_stmt_bind_param($stmt_members, "i", $manager_id);
mysqli_stmt_execute($stmt_members);
$members = mysqli_stmt_get_result($stmt_members);
mysqli_stmt_close($stmt_members);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

<header class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-6 shadow-xl">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Kelola Tugas - <?= htmlspecialchars($project['nama_proyek']) ?></h1>
        <div class="space-x-3">
            <a href="manager_dashboard.php" class="bg-white/20 hover:bg-white/30 px-5 py-2.5 rounded-lg font-semibold transition">← Dashboard</a>
            <a href="../logout.php" class="bg-red-500 hover:bg-red-600 px-5 py-2.5 rounded-lg font-semibold transition">Logout</a>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto py-10 px-6 space-y-10">

    <?php if (!empty($message)): ?>
        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-6 rounded-2xl shadow-xl space-y-6">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>

        <div>
            <label class="block font-semibold mb-2">Nama Tugas</label>
            <input type="text" name="nama_tugas" required
                value="<?= htmlspecialchars($edit_data['nama_tugas'] ?? '') ?>"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block font-semibold mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl"><?= htmlspecialchars($edit_data['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
                    <?php 
                        $statuses = ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'];
                        $selected = $edit_data['status'] ?? 'Belum Dikerjakan';
                        foreach ($statuses as $status):
                    ?>
                        <option value="<?= $status ?>" <?= $status === $selected ? 'selected' : '' ?>><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">Pilih Anggota (Member)</label>
                <select name="member_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl">
                    <option value="">-- Pilih Member --</option>
                    <?php while ($m = mysqli_fetch_assoc($members)): ?>
                        <option value="<?= $m['id'] ?>" <?= ($edit_data && $edit_data['assigned_to'] == $m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['username']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <button type="submit" name="<?= $edit_data ? 'update' : 'tambah' ?>"
            class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-3 rounded-xl font-bold hover:from-indigo-700 hover:to-blue-700 transition">
            <?= $edit_data ? 'Simpan Perubahan' : '+ Tambah Tugas' ?>
        </button>
    </form>


    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-4 font-semibold text-lg">Daftar Tugas</div>
        <div class="p-6 overflow-x-auto">
            <?php if (mysqli_num_rows($tasks) === 0): ?>
                <p class="text-gray-500 text-center">Belum ada tugas untuk proyek ini.</p>
            <?php else: ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-left text-sm font-bold uppercase">
                            <th class="px-4 py-3">Nama Tugas</th>
                            <th class="px-4 py-3">Deskripsi</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Assigned To</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($t['nama_tugas']) ?></td>
                                <td class="px-4 py-3 text-gray-600 text-sm"><?= htmlspecialchars($t['deskripsi']) ?></td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-lg text-sm font-semibold 
                                        <?= $t['status'] === 'Selesai' ? 'bg-green-100 text-green-700' : 
                                            ($t['status'] === 'Sedang Dikerjakan' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') ?>">
                                        <?= htmlspecialchars($t['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3"><?= htmlspecialchars($t['member_name'] ?? '-') ?></td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="crud_tugas.php?project_id=<?= $project_id ?>&edit_id=<?= $t['id'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm">Edit</a>
                                    <a href="crud_tugas.php?project_id=<?= $project_id ?>&hapus_id=<?= $t['id'] ?>" onclick="return confirm('Yakin hapus tugas ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>
</body>
</html>