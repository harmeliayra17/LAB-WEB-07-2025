<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'team_member') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?");
    $stmt->execute([$status, $id, $user_id]);
}
$tasks = $pdo->prepare("SELECT t.*, p.nama_proyek FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.assigned_to = ?");
$tasks->execute([$user_id]);
$tasks = $tasks->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">My Tasks</h2>
        <a href="tm_dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 mb-4 inline-block">Back to Dashboard</a>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nama Tugas</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Project</th>
                        <th class="px-4 py-2">Update Status</th>
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
                            <td class="px-4 py-2">
                                <form method="POST">
                                    <input type="hidden" name="update_status" value="1">
                                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                    <select name="status" class="border border-gray-300 rounded-md px-2 py-1 mr-2">
                                        <option value="belum" <?php echo $task['status'] === 'belum' ? 'selected' : ''; ?>>Belum</option>
                                        <option value="proses" <?php echo $task['status'] === 'proses' ? 'selected' : ''; ?>>Proses</option>
                                        <option value="selesai" <?php echo $task['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>