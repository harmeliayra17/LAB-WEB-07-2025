<?php
require __DIR__ . '/../auth.php';
requiredRole('team_member');
require __DIR__ . '/../config/config.php';

$current_user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $task_id = (int)$_POST['task_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $query = "UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sii', $new_status, $task_id, $current_user_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Status tugas berhasil diupdate!";
        } else {
            $_SESSION['error_message'] = "Gagal mengupdate status.";
        }
        mysqli_stmt_close($stmt);
    }
    
    header('Location: teamMember.php');
    exit;
}

$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['success_message'], $_SESSION['error_message']);

$tasks_data = mysqli_query($conn, "
    SELECT 
        t.*,
        p.nama_proyek,
        p.deskripsi as deskripsi_proyek,
        p.tanggal_mulai,
        p.tanggal_selesai,
        u.username as manager_name,
        p.id as project_id
    FROM tasks t 
    JOIN projects p ON t.project_id = p.id 
    JOIN users u ON p.manager_id = u.id
    WHERE t.assigned_to = $current_user_id
    ORDER BY 
        CASE t.status 
            WHEN 'belum' THEN 1
            WHEN 'proses' THEN 2
            WHEN 'selesai' THEN 3
        END,
        t.nama_tugas
");

$tasks = [];
$projects = [];
$statistics = [
    'total' => 0,
    'completed' => 0,
    'in_progress' => 0,
    'not_started' => 0
];

while ($task = mysqli_fetch_assoc($tasks_data)) {
    $tasks[] = $task;

    $statistics['total']++;
    switch ($task['status']) {
        case 'selesai': $statistics['completed']++; break;
        case 'proses': $statistics['in_progress']++; break;
        case 'belum': $statistics['not_started']++; break;
    }

    $project_id = $task['project_id'];
    if (!isset($projects[$project_id])) {
        $projects[$project_id] = [
            'id' => $project_id,
            'nama_proyek' => $task['nama_proyek'],
            'deskripsi' => $task['deskripsi_proyek'],
            'tanggal_mulai' => $task['tanggal_mulai'],
            'tanggal_selesai' => $task['tanggal_selesai'],
            'manager_name' => $task['manager_name'],
            'tasks' => [],
            'total_tasks' => 0,
            'completed_tasks' => 0
        ];
    }
    
    $projects[$project_id]['tasks'][] = $task;
    $projects[$project_id]['total_tasks']++;
    if ($task['status'] === 'selesai') {
        $projects[$project_id]['completed_tasks']++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Member</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Team Member Dashboard</h1>
            <p class="text-gray-600">Username: <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
            
            <?php if ($success_message): ?>
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?= htmlspecialchars($success_message) ?>
            </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?= htmlspecialchars($error_message) ?>
            </div>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600"><?= $statistics['total'] ?></div>
                    <div class="text-sm text-blue-800">Total Tugas</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-yellow-600"><?= $statistics['in_progress'] ?></div>
                    <div class="text-sm text-yellow-800">Dalam Proses</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-600"><?= $statistics['completed'] ?></div>
                    <div class="text-sm text-green-800">Selesai</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tugas Saya</h2>
                
                <div class="space-y-4">
                    <?php foreach ($tasks as $task): 
                        $status_color = [
                            'belum' => 'bg-red-100 text-red-800 border-red-300',
                            'proses' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                            'selesai' => 'bg-green-100 text-green-800 border-green-300'
                        ][$task['status']] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                    ?>
                    <div class="border rounded-lg p-4 <?= $status_color ?>">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($task['nama_tugas']) ?></h3>
                                <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($task['deskripsi']) ?></p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Proyek: <?= htmlspecialchars($task['nama_proyek']) ?></span>
                                    <span>Manager: <?= htmlspecialchars($task['manager_name']) ?></span>
                                </div>
                            </div>
                            <div class="ml-4 flex flex-col items-end">
                                <form method="POST" class="mb-2">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <input type="hidden" name="update_status" value="1">

                                    <select name="status" 
                                            onchange="this.form.submit()"
                                            class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium">
                                        <option value="belum" <?= $task['status'] === 'belum' ? 'selected' : '' ?>>Belum</option>
                                        <option value="proses" <?= $task['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                                        <option value="selesai" <?= $task['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <button type="submit" name="update_status" class="hidden">Update</button>
                                </form>
                                <div class="text-center text-sm font-medium px-3 py-1 rounded <?= $status_color ?>">
                                    Status: <?= ucfirst($task['status']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($tasks)): ?>
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada tugas yang ditugaskan kepada Anda.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Proyek Saya</h2>
                
                <div class="space-y-4">
                    <?php foreach ($projects as $project): 
                        $progress = $project['total_tasks'] > 0 ? 
                            ($project['completed_tasks'] / $project['total_tasks']) * 100 : 0;
                    ?>
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($project['nama_proyek']) ?></h3>
                                <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($project['deskripsi']) ?></p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Manager: <?= htmlspecialchars($project['manager_name']) ?></span>
                                    <span>Mulai: <?= $project['tanggal_mulai'] ?></span>
                                    <span>Selesai: <?= $project['tanggal_selesai'] ?></span>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress Tugas Anda</span>
                                        <span><?= $project['completed_tasks'] ?>/<?= $project['total_tasks'] ?></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" 
                                            style="width: <?= $progress ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3 space-y-2">
                            <?php foreach ($project['tasks'] as $dt): 
                                $dot_color = [
                                    'belum' => 'bg-red-500',
                                    'proses' => 'bg-yellow-500',
                                    'selesai' => 'bg-green-500'
                                ][$dt['status']] ?? 'bg-gray-500';
                            ?>
                            <div class="flex items-center text-sm">
                                <div class="w-2 h-2 rounded-full <?= $dot_color ?> mr-2"></div>
                                <span class="flex-1"><?= htmlspecialchars($dt['nama_tugas']) ?></span>
                                <span class="text-xs px-2 py-1 rounded <?= [
                                    'belum' => 'bg-red-100 text-red-800',
                                    'proses' => 'bg-yellow-100 text-yellow-800',
                                    'selesai' => 'bg-green-100 text-green-800'
                                ][$dt['status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                    <?= $dt['status'] ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($projects)): ?>
                    <div class="text-center py-8 text-gray-500">
                        <p>Anda belum terdaftar dalam proyek apapun.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/TP-6/logout.php" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Logout
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const select = this.querySelector('select[name="status"]');
                    if (select) {
                        select.disabled = true;
                        select.style.opacity = '0.7';
                    }
                });
            });
        });
    </script>
</body>
</html>