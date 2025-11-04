<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'project_manager') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$projects = $pdo->prepare("SELECT * FROM projects WHERE manager_id = ?");
$projects->execute([$user_id]);
$projects = $projects->fetchAll();
$tms = $pdo->prepare("SELECT * FROM users WHERE project_manager_id = ?");
$tms->execute([$user_id]);
$tms = $tms->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        $nama = $_POST['nama_tugas'];
        $desc = $_POST['deskripsi'];
        $project_id = $_POST['project_id'];
        $assigned_to = $_POST['assigned_to'];
        $status = 'belum';
        $stmt = $pdo->prepare("SELECT id FROM projects WHERE id = ? AND manager_id = ?");
        $stmt->execute([$project_id, $user_id]);
        if ($stmt->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO tasks (nama_tugas, deskripsi, status, project_id, assigned_to) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $desc, $status, $project_id, $assigned_to]);
        }
    } elseif (isset($_POST['update_task'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama_tugas'];
        $desc = $_POST['deskripsi'];
        $assigned_to = $_POST['assigned_to'];
        $stmt = $pdo->prepare("SELECT t.id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?");
        $stmt->execute([$id, $user_id]);
        if ($stmt->fetch()) {
            $stmt = $pdo->prepare("UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ? WHERE id = ?");
            $stmt->execute([$nama, $desc, $assigned_to, $id]);
        }
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT t.id FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?");
    $stmt->execute([$id, $user_id]);
    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: manage_tasks.php');
    exit;
}
$tasks = $pdo->prepare("SELECT t.*, p.nama_proyek, u.username AS assigned_username FROM tasks t JOIN projects p ON t.project_id = p.id JOIN users u ON t.assigned_to = u.id WHERE p.manager_id = ?");
$tasks->execute([$user_id]);
$tasks = $tasks->fetchAll();
$editTask = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT t.* FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.id = ? AND p.manager_id = ?");
    $stmt->execute([$id, $user_id]);
    $editTask = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Tasks</h2>
        <a href="manage_projects.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4 inline-block">Back to Projects</a>
        <h4 class="text-xl font-semibold text-gray-700 mb-4"><?php echo $editTask ? 'Edit Task' : 'Add Task'; ?></h4>
        <form method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <?php if ($editTask): ?>
                <input type="hidden" name="update_task" value="1">
                <input type="hidden" name="id" value="<?php echo $editTask['id']; ?>">
            <?php else: ?>
                <input type="hidden" name="add_task" value="1">
            <?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Tugas</label>
                <input type="text" name="nama_tugas" value="<?php echo $editTask['nama_tugas'] ?? ''; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><?php echo $editTask['deskripsi'] ?? ''; ?></textarea>
            </div>
            <?php if (!$editTask): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Project</label>
                    <select name="project_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id']; ?>"><?php echo $project['nama_proyek']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700">Assigned To</label>
                <select name="assigned_to" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <?php foreach ($tms as $tm): ?>
                        <option value="<?php echo $tm['id']; ?>" <?php echo ($editTask && $editTask['assigned_to'] == $tm['id']) ? 'selected' : ''; ?>><?php echo $tm['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"><?php echo $editTask ? 'Update' : 'Add'; ?></button>
            <?php if ($editTask): ?>
                <a href="manage_tasks.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 ml-2">Cancel Edit</a>
            <?php endif; ?>
        </form>
        <h4 class="text-xl font-semibold text-gray-700 mt-6 mb-4">Your Tasks</h4>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama Tugas</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Project</th>
                        <th class="px-4 py-2">Assigned To</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?php echo $task['id']; ?></td>
                            <td class="px-4 py-2"><?php echo $task['nama_tugas']; ?></td>
                            <td class="px-4 py-2"><?php echo $task['deskripsi']; ?></td>
                            <td class="px-4 py-2"><?php echo $task['status']; ?></td>
                            <td class="px-4 py-2"><?php echo $task['nama_proyek']; ?></td>
                            <td class="px-4 py-2"><?php echo $task['assigned_username']; ?></td>
                            <td class="px-4 py-2">
                                <a href="?edit=<?php echo $task['id']; ?>" class="bg-yellow-600 text-white px-2 py-1 rounded-md hover:bg-yellow-700 mr-2">Edit</a>
                                <a href="?delete=<?php echo $task['id']; ?>" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>