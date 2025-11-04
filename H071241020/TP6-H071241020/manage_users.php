<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'super_admin') {
    header('Location: login.php');
    exit;
}
$pms = $pdo->query("SELECT id, username FROM users WHERE role = 'project_manager'")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $pm_id = $role === 'team_member' ? $_POST['project_manager_id'] : null;
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $role, $pm_id]);
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'super_admin'");
        $stmt->execute([$user_id]);
    }
}
$users = $pdo->query("SELECT u.*, pm.username AS pm_username FROM users u LEFT JOIN users pm ON u.project_manager_id = pm.id WHERE u.role != 'super_admin'")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Users</h2>
        <a href="super_admin_dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4 inline-block">Back to Dashboard</a>
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Add User</h4>
        <form method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <input type="hidden" name="add_user" value="1">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role_select" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="project_manager">Project Manager</option>
                    <option value="team_member">Team Member</option>
                </select>
            </div>
            <div id="pm_select" class="hidden">
                <label class="block text-sm font-medium text-gray-700">Assign to Project Manager</label>
                <select name="project_manager_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <?php foreach ($pms as $pm): ?>
                        <option value="<?php echo $pm['id']; ?>"><?php echo $pm['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add User</button>
        </form>
        <h4 class="text-xl font-semibold text-gray-700 mt-6 mb-4">Existing Users</h4>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Project Manager</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?php echo $user['id']; ?></td>
                            <td class="px-4 py-2"><?php echo $user['username']; ?></td>
                            <td class="px-4 py-2"><?php echo $user['role']; ?></td>
                            <td class="px-4 py-2"><?php echo $user['pm_username'] ?? 'N/A'; ?></td>
                            <td class="px-4 py-2">
                                <form method="POST" class="inline">
                                    <input type="hidden" name="delete_user" value="1">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('role_select').addEventListener('change', function() {
            document.getElementById('pm_select').classList.toggle('hidden', this.value !== 'team_member');
        });
    </script>
</body>
</html>