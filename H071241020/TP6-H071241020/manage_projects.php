<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'project_manager') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_project'])) {
        $nama = $_POST['nama_proyek'];
        $desc = $_POST['deskripsi'];
        $start = $_POST['tanggal_mulai'];
        $end = $_POST['tanggal_selesai'];
        $stmt = $pdo->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $desc, $start, $end, $user_id]);
    } elseif (isset($_POST['update_project'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama_proyek'];
        $desc = $_POST['deskripsi'];
        $start = $_POST['tanggal_mulai'];
        $end = $_POST['tanggal_selesai'];
        $stmt = $pdo->prepare("UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?");
        $stmt->execute([$nama, $desc, $start, $end, $id, $user_id]);
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND manager_id = ?");
    $stmt->execute([$id, $user_id]);
    header('Location: manage_projects.php');
    exit;
}
$projects = $pdo->prepare("SELECT * FROM projects WHERE manager_id = ?");
$projects->execute([$user_id]);
$projects = $projects->fetchAll();
$editProject = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ? AND manager_id = ?");
    $stmt->execute([$id, $user_id]);
    $editProject = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Projects</h2>
        <a href="pm_dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4 inline-block">Back to Dashboard</a>
        <a href="manage_tasks.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mb-4 ml-2 inline-block">Manage Tasks</a>
        <h4 class="text-xl font-semibold text-gray-700 mb-4"><?php echo $editProject ? 'Edit Project' : 'Add Project'; ?></h4>
        <form method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
            <?php if ($editProject): ?>
                <input type="hidden" name="update_project" value="1">
                <input type="hidden" name="id" value="<?php echo $editProject['id']; ?>">
            <?php else: ?>
                <input type="hidden" name="add_project" value="1">
            <?php endif; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Proyek</label>
                <input type="text" name="nama_proyek" value="<?php echo $editProject['nama_proyek'] ?? ''; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><?php echo $editProject['deskripsi'] ?? ''; ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="<?php echo $editProject['tanggal_mulai'] ?? ''; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="<?php echo $editProject['tanggal_selesai'] ?? ''; ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"><?php echo $editProject ? 'Update' : 'Add'; ?></button>
            <?php if ($editProject): ?>
                <a href="manage_projects.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 ml-2">Cancel Edit</a>
            <?php endif; ?>
        </form>
        <h4 class="text-xl font-semibold text-gray-700 mt-6 mb-4">Your Projects</h4>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama Proyek</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Tanggal Mulai</th>
                        <th class="px-4 py-2">Tanggal Selesai</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2"><?php echo $project['id']; ?></td>
                            <td class="px-4 py-2"><?php echo $project['nama_proyek']; ?></td>
                            <td class="px-4 py-2"><?php echo $project['deskripsi']; ?></td>
                            <td class="px-4 py-2"><?php echo $project['tanggal_mulai']; ?></td>
                            <td class="px-4 py-2"><?php echo $project['tanggal_selesai']; ?></td>
                            <td class="px-4 py-2">
                                <a href="?edit=<?php echo $project['id']; ?>" class="bg-yellow-600 text-white px-2 py-1 rounded-md hover:bg-yellow-700 mr-2">Edit</a>
                                <a href="?delete=<?php echo $project['id']; ?>" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>