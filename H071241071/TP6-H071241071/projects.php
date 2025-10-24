<?php
require_once 'config.php';
if (!isLoggedIn()) redirect('login.php');

$role = getUserRole();
$user_id = $_SESSION['user_id'];
$message = $error = '';

if (isSuperAdmin()) {
    $where_clause = '';
} else {
    $where_clause = "WHERE p.manager_id = $user_id";
}

if (isset($_POST['add_project'])) {
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'] ?? null;
    $manager_id = isSuperAdmin() ? $_POST['manager_id'] : $user_id;
    
    if (!empty($nama) && !empty($tgl_mulai)) {
        $stmt = $pdo->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nama, $deskripsi, $tgl_mulai, $tgl_selesai, $manager_id])) $message = 'Proyek ditambah!';
        else $error = 'Gagal tambah proyek!';
    } else $error = 'Nama & tanggal mulai wajib!';
}

if (isset($_POST['edit_project']) && (isSuperAdmin() || isProjectManager())) {
    $id = $_POST['project_id'];
    $nama = trim($_POST['nama_proyek']);
    $deskripsi = trim($_POST['deskripsi']);
    $tgl_mulai = $_POST['tanggal_mulai'];
    $tgl_selesai = $_POST['tanggal_selesai'] ?? null;
    $manager_id = isSuperAdmin() ? $_POST['manager_id'] : $user_id;

    if (!empty($nama) && !empty($tgl_mulai)) {
        $stmt = $pdo->prepare("UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ?, manager_id = ? WHERE id = ?");
        if ($stmt->execute([$nama, $deskripsi, $tgl_mulai, $tgl_selesai, $manager_id, $id])) {
            $message = 'Proyek diperbarui!';
        } else {
            $error = 'Gagal memperbarui proyek!';
        }
    } else {
        $error = 'Nama & tanggal mulai wajib!';
    }
}

if (isset($_POST['delete_project'])) {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    if ($stmt->execute([$_POST['project_id']])) $message = 'Proyek dihapus!';
}

$projects = $pdo->query("SELECT p.*, u.username as manager FROM projects p JOIN users u ON p.manager_id=u.id $where_clause ORDER BY p.id DESC")->fetchAll();
$pm_list = isSuperAdmin() ? $pdo->query("SELECT id, username FROM users WHERE role='project_manager'")->fetchAll() : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { padding: 1.5rem; }
        dialog {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Shadow lebih kuat */
            padding: 0;
            width: 90%;
            max-width: 700px;
            margin: 1.5rem auto;
            background-color: #ffffff;
        }
        dialog::backdrop { background: rgba(0, 0, 0, 0.6); }
        .dialog-header {
            background-color: #4f46e5;
            color: white;
            padding: 1.5rem;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        .dialog-body { padding: 1.5rem; }
        .dialog-content { display: grid; gap: 1rem; }
        .dialog-buttons { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Proyek</h1>
        
        <?php if ($message): ?><div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-6"><?= $message ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6"><?= $error ?></div><?php endif; ?>

        <?php if (isSuperAdmin() || isProjectManager()): ?>
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h2 class="text-xl font-semibold mb-4">Tambah Proyek</h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="nama_proyek" placeholder="Nama Proyek" required class="px-3 py-2 border rounded w-full">
                <input type="date" name="tanggal_mulai" required class="px-3 py-2 border rounded w-full">
                <input type="date" name="tanggal_selesai" class="px-3 py-2 border rounded w-full">
                <?php if (isSuperAdmin()): ?>
                    <select name="manager_id" required class="px-3 py-2 border rounded w-full">
                        <option value="">Pilih PM</option>
                        <?php foreach ($pm_list as $pm): ?><option value="<?= $pm['id'] ?>"><?= $pm['username'] ?></option><?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <textarea name="deskripsi" placeholder="Deskripsi" class="md:col-span-3 px-3 py-2 border rounded w-full" rows="3"></textarea>
                <button type="submit" name="add_project" class="md:col-span-3 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 w-full">Tambah Proyek</button>
            </form>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Proyek</th>
                        <th class="px-6 py-3 text-left">Manager</th>
                        <th class="px-6 py-3 text-left">Mulai</th>
                        <th class="px-6 py-3 text-left">Selesai</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $proj): ?>
                    <tr class="border-t">
                        <td class="px-6 py-4 font-medium"><?= htmlspecialchars($proj['nama_proyek']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($proj['manager']) ?></td>
                        <td class="px-6 py-4"><?= date('d/m/Y', strtotime($proj['tanggal_mulai'])) ?></td>
                        <td class="px-6 py-4"><?= $proj['tanggal_selesai'] ? date('d/m/Y', strtotime($proj['tanggal_selesai'])) : '-' ?></td>
                        <td class="px-6 py-4">
                            <a href="tasks.php?project_id=<?= $proj['id'] ?>" class="text-blue-600 mr-4">Tugas</a>
                            <?php if (isSuperAdmin() || $proj['manager_id'] == $user_id): ?>
                                <button onclick="showEditForm(<?= $proj['id'] ?>, '<?= htmlspecialchars($proj['nama_proyek'], ENT_QUOTES) ?>', '<?= htmlspecialchars($proj['deskripsi'] ?? '', ENT_QUOTES) ?>', '<?= $proj['tanggal_mulai'] ?>', '<?= $proj['tanggal_selesai'] ?? '' ?>', '<?= $proj['manager_id'] ?>')" class="text-yellow-600 mr-4">Edit</button>
                                <form method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                                    <input type="hidden" name="project_id" value="<?= $proj['id'] ?>">
                                    <button type="submit" name="delete_project" class="text-red-600">Hapus</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Kembali</a>
        </div>

        <dialog id="editProjectDialog">
            <div class="dialog-header">
                <h2 class="text-xl font-bold">Edit Proyek</h2>
            </div>
            <div class="dialog-body">
                <form method="POST" id="edit_project_form" class="dialog-content grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="hidden" name="project_id" id="edit_project_id">
                    <input type="text" name="nama_proyek" id="edit_nama_proyek" placeholder="Nama Proyek" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                    <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                    <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                    <?php if (isSuperAdmin()): ?>
                        <select name="manager_id" id="edit_manager_id" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih PM</option>
                            <?php foreach ($pm_list as $pm): ?>
                                <option value="<?= $pm['id'] ?>"><?= $pm['username'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                    <textarea name="deskripsi" id="edit_deskripsi" placeholder="Deskripsi" class="md:col-span-3 px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
                    <div class="dialog-buttons md:col-span-3">
                        <button type="button" onclick="closeEditForm()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">Batal</button>
                        <button type="submit" name="edit_project" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition duration-150">Perbarui Proyek</button>
                    </div>
                </form>
            </div>
        </dialog>
    </div>
    <script>
        function showEditForm(id, nama, deskripsi, tgl_mulai, tgl_selesai, manager_id) {
            document.getElementById('edit_project_id').value = id;
            document.getElementById('edit_nama_proyek').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_tanggal_mulai').value = tgl_mulai;
            document.getElementById('edit_tanggal_selesai').value = tgl_selesai;
            if (<?php echo isSuperAdmin() ? 'true' : 'false'; ?>) {
                document.getElementById('edit_manager_id').value = manager_id;
            }
            document.getElementById('editProjectDialog').showModal();
        }

        function closeEditForm() {
            document.getElementById('editProjectDialog').close();
            document.getElementById('edit_project_form').reset();
        }
    </script>
</body>
</html>