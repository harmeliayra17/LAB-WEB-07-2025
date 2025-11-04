<?php
require_once 'config.php';
if (!isSuperAdmin()) redirect('dashboard.php');

$message = $error = '';
if (isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $pm_id = $_POST['project_manager_id'] ?? null;
    
    if (empty($username) || empty($password)) {
        $error = 'Username & password wajib!';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username=?");
        $stmt->execute([$username]);
        if (!$stmt->fetch() && ($role != 'team_member' || $pm_id)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$username, $hash, $role, $pm_id])) {
                $message = 'User berhasil ditambah!';
            } else $error = 'Gagal tambah user!';
        } else $error = 'Username sudah ada atau PM wajib untuk Team Member!';
    }
}

if (isset($_POST['delete_user'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=? AND id != 1");
    $stmt->execute([$_POST['user_id']]);
    $message = 'User dihapus!';
}

$users = $pdo->query("SELECT u.*, pm.username as pm_name FROM users u LEFT JOIN users pm ON u.project_manager_id=pm.id WHERE u.id != 1")->fetchAll();
$pm_list = $pdo->query("SELECT id, username FROM users WHERE role='project_manager'")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Kelola Pengguna</h1>
        
        <?php if ($message): ?><div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-6"><?= $message ?></div><?php endif; ?>
        <?php if ($error): ?><div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6"><?= $error ?></div><?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h2 class="text-xl font-semibold mb-4">Tambah Pengguna</h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="username" placeholder="Username" required class="px-3 py-2 border rounded">
                <input type="password" name="password" placeholder="Password" required class="px-3 py-2 border rounded">
                <select name="role" required class="px-3 py-2 border rounded" onchange="togglePM(this)">
                    <option value="">Pilih Role</option>
                    <option value="project_manager">Project Manager</option>
                    <option value="team_member">Team Member</option>
                </select>
                <select name="project_manager_id" class="px-3 py-2 border rounded" id="pm_select">
                    <option value="">-- Project Manager --</option>
                    <?php foreach ($pm_list as $pm): ?>
                        <option value="<?= $pm['id'] ?>"><?= $pm['username'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add_user" class="md:col-span-2 bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Tambah</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">Username</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Project Manager</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr class="border-t">
                        <td class="px-6 py-4"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium <?= $user['role']=='project_manager' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4"><?= htmlspecialchars($user['pm_name'] ?? '-') ?></td>
                        <td class="px-6 py-4">
                            <form method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete_user" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Kembali</a>
        </div>
    </div>
    <script>
        function togglePM(select) {
            document.getElementById('pm_select').required = select.value === 'team_member';
        }
    </script>
</body>
</html>