<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'super_admin') {
    header('Location: login.php');
    exit;
}
if (isset($_GET['delete'])) {
    $project_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    header('Location: view_all_projects.php');
    exit;
}
$projects = $pdo->query("SELECT p.*, u.username AS manager_username FROM projects p JOIN users u ON p.manager_id = u.id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View All Projects</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">All Projects</h2>
        <a href="super_admin_dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4 inline-block">Back to Dashboard</a>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama Proyek</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Tanggal Mulai</th>
                        <th class="px-4 py-2">Tanggal Selesai</th>
                        <th class="px-4 py-2">Manager</th>
                        <th class="px-4 py-2">Action</th>
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
                            <td class="px-4 py-2"><?php echo $project['manager_username']; ?></td>
                            <td class="px-4 py-2">
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