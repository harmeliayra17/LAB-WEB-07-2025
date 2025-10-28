<?php
include 'db_connect.php';
include 'functions.php';
redirectIfNotLoggedIn();
if (getUserRole() !== 'team_member') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to = ?");
$stmt->execute([$user_id]);
$taskCount = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Member Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Team Member Dashboard</h2>
        <div class="flex space-x-4 mb-6">
            <a href="view_tasks.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">View My Tasks</a>
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">Logout</a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">Summary</h4>
            <p class="text-gray-800">Your Tasks: <?php echo $taskCount; ?></p>
        </div>
    </div>
</body>
</html>