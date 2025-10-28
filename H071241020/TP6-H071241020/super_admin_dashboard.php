<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'super_admin') {
    header('Location: login.php');
    exit;
}
$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$taskCount = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Super Admin Dashboard</h2>
        <div class="flex space-x-4 mb-6">
            <a href="manage_users.php" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Manage Users</a>
            <a href="view_all_projects.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">View All Projects</a>
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Logout</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">Summary</h4>
            <p class="text-gray-800">Total Projects: <?php echo $projectCount; ?></p>
            <p class="text-gray-800">Total Tasks: <?php echo $taskCount; ?></p>
        </div>
    </div>
</body>
</html>