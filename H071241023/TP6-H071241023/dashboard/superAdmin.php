<?php

require __DIR__ . '/../auth.php';
requiredRole('super_admin');
require __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        // Tambah user baru
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $project_manager_id = $role === 'team_member' ? (int)$_POST['project_manager_id'] : NULL;

        $query = "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssi', $username, $password, $role, $project_manager_id);
        mysqli_stmt_execute($stmt);
    }
    elseif (isset($_POST['delete_user'])) {
        // Hapus user
        $id = (int)$_POST['user_id'];
        mysqli_query($conn, "DELETE FROM users WHERE id = $id AND role != 'super_admin'");
    }
    elseif (isset($_POST['delete_project'])) {
        // Hapus project
        $id = (int)$_POST['project_id'];
        mysqli_query($conn, "DELETE FROM projects WHERE id = $id");
    }
    header('Location: superAdmin.php');
    exit;
}

// Get data untuk ditampilkan
$users = mysqli_query($conn, "
    SELECT u1.*, u2.username as pm_name 
    FROM users u1 
    LEFT JOIN users u2 ON u1.project_manager_id = u2.id
    ORDER BY u1.username ASC, u1.role
");

$projects = mysqli_query($conn, "
    SELECT p.*, u.username as manager_name 
    FROM projects p 
    JOIN users u ON p.manager_id = u.id
    ORDER BY p.nama_proyek
");

$project_managers = mysqli_query($conn, "
    SELECT id, username FROM users WHERE role = 'project_manager'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Super Admin Dashboard</h1>
            <p class="text-md text-gray-600">Username: <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Manajemen User</h2>
                    <button onclick="openModal('addUserModal')" 
                            class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">
                        Tambah User
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-sm px-4 py-2 text-left">Username</th>
                                <th class="text-sm px-4 py-2 text-left">Role</th>
                                <th class="text-sm px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr class="border-b">
                                <td class="text-sm px-2"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="text-sm">
                                    <span class="inline-block  py-1
                                        <?= $user['role'] === 'super_admin' ? 'text-red-800' : ($user['role'] === 'project_manager' ? 'text-blue-800' : 'text-green-800') ?>">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
                                    <?php if ($user['role'] === 'team_member' && $user['pm_name']): ?>
                                        <br><small class="text-gray-500">Under: <?= htmlspecialchars($user['pm_name']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?php if ($user['role'] !== 'super_admin'): ?>
                                    <form method="POST" class="inline" onsubmit="return confirm('Yakin hapus user?')">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="delete_user" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Semua Proyek</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-sm px-4 py-2 text-left">Nama Proyek</th>
                                <th class="text-sm px-4 py-2 text-left">Project Manager</th>
                                <th class="text-sm px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($project = mysqli_fetch_assoc($projects)): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?= htmlspecialchars($project['nama_proyek']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($project['manager_name']) ?></td>
                                <td class="px-4 py-2">
                                    <form method="POST" class="inline" onsubmit="return confirm('Yakin hapus proyek?')">
                                        <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                        <button type="submit" name="delete_project" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/TP-6/logout.php" class="inline-block bg-gray-500 hover:bg-gray-600 text-white text-sm px-6 py-2 rounded">
                Logout
            </a>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-md font-semibold mb-4">Tambah User Baru</h3>
            
            <form method="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" required 
                            class="text-sm w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required 
                            class="text-sm w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="roleSelect" required 
                                class="text-sm w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="project_manager" class="text-xs">Project Manager</option>
                            <option value="team_member" class="text-xs">Team Member</option>
                        </select>
                    </div>
                    
                    <div id="pmSelection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Manager</label>
                        <select name="project_manager_id" 
                                class="text-sm w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php while ($pm = mysqli_fetch_assoc($project_managers)): ?>
                            <option value="<?= $pm['id'] ?>"><?= htmlspecialchars($pm['username']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addUserModal')" 
                            class="text-sm px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" name="add_user" 
                            class="text-sm px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }

        document.getElementById('roleSelect').addEventListener('change', function() {
            const pmSelection = document.getElementById('pmSelection');
            if (this.value === 'team_member') {
                pmSelection.classList.remove('hidden');
            } else {
                pmSelection.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
            }
        });
    </script>
</body>
</html>