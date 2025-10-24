<?php
require_once 'config.php';
if (!isLoggedIn()) redirect('login.php');

$role = getUserRole();
$user_id = $_SESSION['user_id'];
$project_id = $_GET['project_id'] ?? 0;
$message = $error = '';

if (isset($_POST['add_task']) && isProjectManager()) {
    $nama = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $proj_id = $_POST['project_id'];
    $assigned = $_POST['assigned_to'];
    
    if (!empty($nama)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nama, $deskripsi, $proj_id, $assigned])) $message = 'Tugas ditambah!';
    }
}

if (isset($_POST['edit_task']) && isProjectManager()) {
    $id = $_POST['task_id'];
    $nama = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $proj_id = $_POST['project_id'];
    $assigned = $_POST['assigned_to'];
    
    if (!empty($nama)) {
        $stmt = $pdo->prepare("UPDATE tasks SET nama_tugas = ?, deskripsi = ?, project_id = ?, assigned_to = ? WHERE id = ?");
        if ($stmt->execute([$nama, $deskripsi, $proj_id, $assigned, $id])) {
            $message = 'Tugas diperbarui!';
        } else {
            $error = 'Gagal memperbarui tugas!';
        }
    }
}

if (isset($_POST['update_status']) && isTeamMember()) {
    $stmt = $pdo->prepare("UPDATE tasks SET status=? WHERE id=? AND assigned_to=?");
    $stmt->execute([$_POST['status'], $_POST['task_id'], $user_id]);
    $message = 'Status diupdate!';
}

if (isset($_POST['delete_task']) && isProjectManager()) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->execute([$_POST['task_id']]);
    $message = 'Tugas dihapus!';
}

if (isTeamMember()) {
    $stmt = $pdo->prepare("SELECT t.*, p.nama_proyek, u.username FROM tasks t 
                           JOIN projects p ON t.project_id=p.id 
                           JOIN users u ON t.assigned_to=u.id 
                           WHERE t.assigned_to = ? ORDER BY t.id DESC");
    $stmt->execute([$user_id]);
} elseif (isProjectManager()) {
    if ($project_id) {
        $stmt = $pdo->prepare("SELECT t.*, p.nama_proyek, u.username FROM tasks t 
                               JOIN projects p ON t.project_id=p.id 
                               JOIN users u ON t.assigned_to=u.id 
                               WHERE t.project_id = ? AND p.manager_id = ? 
                               ORDER BY t.id DESC");
        $stmt->execute([$project_id, $user_id]);
    } else {
        $stmt = $pdo->prepare("SELECT t.*, p.nama_proyek, u.username FROM tasks t 
                               JOIN projects p ON t.project_id=p.id 
                               JOIN users u ON t.assigned_to=u.id 
                               WHERE p.manager_id = ? 
                               ORDER BY t.id DESC");
        $stmt->execute([$user_id]);
    }
} else {
    $stmt = $pdo->prepare("SELECT t.*, p.nama_proyek, u.username FROM tasks t 
                           JOIN projects p ON t.project_id=p.id 
                           JOIN users u ON t.assigned_to=u.id 
                           WHERE 1=1 ORDER BY t.id DESC");
    $stmt->execute();
}
$tasks = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT id, nama_proyek FROM projects WHERE manager_id = ? OR ? = 'super_admin'");
$stmt->execute([$user_id, $role]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$team_members = $pdo->query("SELECT id, username FROM users WHERE role='team_member'")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { padding: 1.5rem; }
        dialog {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
        <h1 class="text-3xl font-bold mb-6">Tugas <?= $project_id ? '(Proyek Spesifik)' : '' ?></h1>
        
        <?php if ($message): ?><div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-6"><?= $message ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6"><?= $error ?></div><?php endif; ?>

        <?php if (isProjectManager()): ?>
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h2 class="text-xl font-semibold mb-4">Tambah Tugas</h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="nama_tugas" placeholder="Nama Tugas" required class="px-3 py-2 border rounded w-full">
                <select name="project_id" required class="px-3 py-2 border rounded w-full">
                    <option value="">Pilih Proyek</option>
                    <?php foreach ($projects as $p): ?><option value="<?= $p['id'] ?>"><?= $p['nama_proyek'] ?></option><?php endforeach; ?>
                </select>
                <select name="assigned_to" required class="px-3 py-2 border rounded w-full">
                    <option value="">Pilih Team Member</option>
                    <?php foreach ($team_members as $tm): ?><option value="<?= $tm['id'] ?>"><?= $tm['username'] ?></option><?php endforeach; ?>
                </select>
                <textarea name="deskripsi" placeholder="Deskripsi" class="md:col-span-3 px-3 py-2 border rounded w-full" rows="3"></textarea>
                <button type="submit" name="add_task" class="md:col-span-3 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 w-full">Tambah Tugas</button>
            </form>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Tugas</th>
                        <th class="px-6 py-3 text-left">Proyek</th>
                        <th class="px-6 py-3 text-left">Ditugaskan</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr class="border-t">
                        <td class="px-6 py-4 font-medium"><?= htmlspecialchars($task['nama_tugas']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($task['nama_proyek']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($task['username']) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-sm font-medium 
                                <?= $task['status']=='selesai' ? 'bg-green-100 text-green-800' : 
                                   ($task['status']=='proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') ?>">
                                <?= ucfirst($task['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if (isTeamMember() && $task['assigned_to'] == $user_id): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                        <option value="belum" <?= $task['status']=='belum'?'selected':'' ?>>Belum</option>
                                        <option value="proses" <?= $task['status']=='proses'?'selected':'' ?>>Proses</option>
                                        <option value="selesai" <?= $task['status']=='selesai'?'selected':'' ?>>Selesai</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            <?php endif; ?>
                            <?php if (isProjectManager() && (!$project_id || $task['project_id'] == $project_id)): ?>
                                <button onclick="showEditTaskForm(<?= $task['id'] ?>, '<?= htmlspecialchars($task['nama_tugas'], ENT_QUOTES) ?>', '<?= htmlspecialchars($task['deskripsi'] ?? '', ENT_QUOTES) ?>', '<?= $task['project_id'] ?>', '<?= $task['assigned_to'] ?>')" class="text-yellow-600 mr-4">Edit</button>
                                <form method="POST" class="inline ml-4" onsubmit="return confirm('Yakin?')">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <button type="submit" name="delete_task" class="text-red-600">Hapus</button>
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

        <dialog id="editTaskDialog">
            <div class="dialog-header">
                <h2 class="text-xl font-bold">Edit Tugas</h2>
            </div>
            <div class="dialog-body">
                <form method="POST" id="edit_task_form" class="dialog-content grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="hidden" name="task_id" id="edit_task_id">
                    <input type="text" name="nama_tugas" id="edit_nama_tugas" placeholder="Nama Tugas" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                    <select name="project_id" id="edit_project_id" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Proyek</option>
                        <?php foreach ($projects as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['nama_proyek'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="assigned_to" id="edit_assigned_to" required class="px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Team Member</option>
                        <?php foreach ($team_members as $tm): ?>
                            <option value="<?= $tm['id'] ?>"><?= $tm['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <textarea name="deskripsi" id="edit_deskripsi" placeholder="Deskripsi" class="md:col-span-3 px-3 py-2 border border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
                    <div class="dialog-buttons md:col-span-3">
                        <button type="button" onclick="closeEditTaskForm()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-150">Batal</button>
                        <button type="submit" name="edit_task" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition duration-150">Perbarui Tugas</button>
                    </div>
                </form>
            </div>
        </dialog>
    </div>
    <script>
        function showEditTaskForm(id, nama, deskripsi, project_id, assigned_to) {
            document.getElementById('edit_task_id').value = id;
            document.getElementById('edit_nama_tugas').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_project_id').value = project_id;
            document.getElementById('edit_assigned_to').value = assigned_to;
            document.getElementById('editTaskDialog').showModal();
        }

        function closeEditTaskForm() {
            document.getElementById('editTaskDialog').close();
            document.getElementById('edit_task_form').reset();
        }
    </script>
</body>
</html>