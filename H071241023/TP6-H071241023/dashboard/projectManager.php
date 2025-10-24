<?php

require __DIR__ . '/../auth.php';
requiredRole('project_manager');
require __DIR__ . '/../config/config.php';

$current_user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_project'])) {
        // Tambah proyek baru
        $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        
        $query = "INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $current_user_id);
        mysqli_stmt_execute($stmt);
    } 
    elseif (isset($_POST['edit_project'])) {
        // Edit proyek
        $id = (int)$_POST['project_id'];
        $nama_proyek = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        
        $query = "UPDATE projects SET nama_proyek = ?, deskripsi = ?, tanggal_mulai = ?, tanggal_selesai = ? WHERE id = ? AND manager_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssii', $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $id, $current_user_id);
        mysqli_stmt_execute($stmt);
    }
    elseif (isset($_POST['delete_project'])) {
        // Hapus proyek
        $id = (int)$_POST['project_id'];
        mysqli_query($conn, "DELETE FROM projects WHERE id = $id AND manager_id = $current_user_id");
    }
    elseif (isset($_POST['add_task'])) {
        // Tambah tugas baru
        $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $project_id = (int)$_POST['project_id'];
        $assigned_to = (int)$_POST['assigned_to'];
        
        $query = "INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssii', $nama_tugas, $deskripsi, $project_id, $assigned_to);
        mysqli_stmt_execute($stmt);
    }
    elseif (isset($_POST['edit_task'])) {
        // Edit tugas
        $id = (int)$_POST['task_id'];
        $nama_tugas = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        $assigned_to = (int)$_POST['assigned_to'];
        
        $query = "UPDATE tasks SET nama_tugas = ?, deskripsi = ?, assigned_to = ? WHERE id = ? AND project_id IN (SELECT id FROM projects WHERE manager_id = ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssiii', $nama_tugas, $deskripsi, $assigned_to, $id, $current_user_id);
        mysqli_stmt_execute($stmt);
    }
    elseif (isset($_POST['delete_task'])) {
        // Hapus tugas
        $id = (int)$_POST['task_id'];
        mysqli_query($conn, "DELETE FROM tasks WHERE id = $id AND project_id IN (SELECT id FROM projects WHERE manager_id = $current_user_id)");
    }
    header('Location: projectManager.php');
    exit;
}

// Get data untuk ditampilkan
$projects = mysqli_query($conn, "
    SELECT p.*, 
    COUNT(t.id) as total_tasks,
    SUM(CASE WHEN t.status = 'selesai' THEN 1 ELSE 0 END) as completed_tasks
    FROM projects p 
    LEFT JOIN tasks t ON p.id = t.project_id
    WHERE p.manager_id = $current_user_id
    GROUP BY p.id
    ORDER BY p.tanggal_mulai DESC
");

$team_members = mysqli_query($conn, "
    SELECT id, username 
    FROM users 
    WHERE role = 'team_member' AND project_manager_id = $current_user_id
    ORDER BY username
");

$project_tasks = [];
if (isset($_GET['view_tasks'])) {
    $project_id = (int)$_GET['view_tasks'];
    $project_tasks = mysqli_query($conn, "
        SELECT t.*, u.username as assigned_name 
        FROM tasks t 
        JOIN users u ON t.assigned_to = u.id 
        WHERE t.project_id = $project_id
        ORDER BY t.status, t.nama_tugas
    ");
    
    $project_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_proyek FROM projects WHERE id = $project_id"));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Project Manager Dashboard</h1>
            <p class="text-md text-gray-600">Username: <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
            <p class="text-md text-gray-600">Anda memiliki <?= mysqli_num_rows($team_members) ?> team member</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Proyek Saya</h2>
                    <button onclick="openModal('addProjectModal')" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                        Tambah Proyek
                    </button>
                </div>
                
                <div class="space-y-4">
                    <?php while ($project = mysqli_fetch_assoc($projects)): 
                        $progress = $project['total_tasks'] > 0 ? ($project['completed_tasks'] / $project['total_tasks']) * 100 : 0;
                    ?>
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($project['nama_proyek']) ?></h3>
                                <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($project['deskripsi']) ?></p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Mulai: <?= $project['tanggal_mulai'] ?></span>
                                    <span>Selesai: <?= $project['tanggal_selesai'] ?></span>
                                </div>
                                <div class="mt-2">
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Progress Tugas</span>
                                        <span><?= $project['completed_tasks'] ?>/<?= $project['total_tasks'] ?></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <button onclick="openEditProjectModal(<?= $project['id'] ?>, '<?= htmlspecialchars($project['nama_proyek']) ?>', '<?= htmlspecialchars($project['deskripsi']) ?>', '<?= $project['tanggal_mulai'] ?>', '<?= $project['tanggal_selesai'] ?>')"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </button>
                                <button onclick="openTasksModal(<?= $project['id'] ?>)" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Lihat Tugas
                                </button>
                                <form method="POST" class="inline" onsubmit="return confirm('Yakin hapus proyek?')">
                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                    <button type="submit" name="delete_project" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    
                    <?php if (mysqli_num_rows($projects) === 0): ?>
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada proyek. Tambahkan proyek pertama Anda!</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Team Members</h2>
                    <div class="space-y-2">
                        <?php 
                        mysqli_data_seek($team_members, 0);
                        while ($member = mysqli_fetch_assoc($team_members)): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <span class="font-medium"><?= htmlspecialchars($member['username']) ?></span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Team Member</span>
                        </div>
                        <?php endwhile; ?>
                        
                        <?php if (mysqli_num_rows($team_members) === 0): ?>
                        <p class="text-gray-500 text-center py-4">Belum ada team member yang ditugaskan kepada Anda.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="/TP-6/logout.php" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Logout
            </a>
        </div>
    </div>

    <!-- Modal Tambah Proyek -->
    <div id="addProjectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4">Tambah Proyek Baru</h3>
            
            <form method="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                        <input type="text" name="nama_proyek" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addProjectModal')" 
                            class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" name="add_project" 
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Proyek -->
    <div id="editProjectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4">Edit Proyek</h3>
            
            <form method="POST">
                <input type="hidden" name="project_id" id="editProjectId">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Proyek</label>
                        <input type="text" name="nama_proyek" id="editNamaProyek" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="editDeskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="editTanggalMulai" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="editTanggalSelesai" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('editProjectModal')" 
                            class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" name="edit_project" 
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Daftar Tugas -->
    <?php if (isset($_GET['view_tasks'])): ?>
    <div id="tasksModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Tugas - <?= htmlspecialchars($project_info['nama_proyek']) ?></h3>
                <button onclick="closeModalAndRedirect()" 
                        class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            
            <div class="mb-4">
                <button onclick="openAddTaskForProjectModal(<?= $project_id ?>)" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Tambah Tugas
                </button>
            </div>
            
            <div class="space-y-4">
                <?php while ($task = mysqli_fetch_assoc($project_tasks)): 
                    $status_color = [
                        'belum' => 'bg-red-100 text-red-800',
                        'proses' => 'bg-yellow-100 text-yellow-800',
                        'selesai' => 'bg-green-100 text-green-800'
                    ][$task['status']] ?? 'bg-gray-100 text-gray-800';
                ?>
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-semibold"><?= htmlspecialchars($task['nama_tugas']) ?></h4>
                            <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($task['deskripsi']) ?></p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>Ditugaskan ke: <?= htmlspecialchars($task['assigned_name']) ?></span>
                                <span class="px-2 py-1 rounded <?= $status_color ?>">Status: <?= $task['status'] ?></span>
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-4">
                            <button onclick="openEditTaskModal(<?= $task['id'] ?>, '<?= htmlspecialchars($task['nama_tugas']) ?>', '<?= htmlspecialchars($task['deskripsi']) ?>', <?= $task['assigned_to'] ?>)"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </button>
                            <form method="POST" class="inline" onsubmit="return confirm('Yakin hapus tugas?')">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                <button type="submit" name="delete_task" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php if (mysqli_num_rows($project_tasks) === 0): ?>
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada tugas untuk proyek ini.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tugas untuk Project Spesifik -->
    <div id="addTaskForProjectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4">Tambah Tugas</h3>
            
            <form method="POST">
                <input type="hidden" name="project_id" id="addTaskProjectId">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tugas</label>
                        <input type="text" name="nama_tugas" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ditugaskan ke</label>
                        <select name="assigned_to" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php 
                            mysqli_data_seek($team_members, 0);
                            while ($member = mysqli_fetch_assoc($team_members)): ?>
                            <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['username']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('addTaskForProjectModal')" 
                            class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" name="add_task" 
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Tugas -->
    <div id="editTaskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4">Edit Tugas</h3>
            
            <form method="POST">
                <input type="hidden" name="task_id" id="editTaskId">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tugas</label>
                        <input type="text" name="nama_tugas" id="editTaskNama" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="editTaskDeskripsi" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ditugaskan ke</label>
                        <select name="assigned_to" id="editTaskAssigned" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php 
                            mysqli_data_seek($team_members, 0);
                            while ($member = mysqli_fetch_assoc($team_members)): ?>
                            <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['username']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal('editTaskModal')" 
                            class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" name="edit_task" 
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }

        function closeModalAndRedirect() {
            window.location.href = 'projectManager.php';
        }

        function openEditProjectModal(id, nama, deskripsi, mulai, selesai) {
            document.getElementById('editProjectId').value = id;
            document.getElementById('editNamaProyek').value = nama;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editTanggalMulai').value = mulai;
            document.getElementById('editTanggalSelesai').value = selesai;
            openModal('editProjectModal');
        }

        function openTasksModal(projectId) {
            window.location.href = 'projectManager.php?view_tasks=' + projectId;
        }

        function openAddTaskForProjectModal(projectId) {
            document.getElementById('addTaskProjectId').value = projectId;
            closeModal('tasksModal');
            openModal('addTaskForProjectModal');
        }

        function openEditTaskModal(id, nama, deskripsi, assignedTo) {
            document.getElementById('editTaskId').value = id;
            document.getElementById('editTaskNama').value = nama;
            document.getElementById('editTaskDeskripsi').value = deskripsi;
            document.getElementById('editTaskAssigned').value = assignedTo;
            closeModal('tasksModal');
            openModal('editTaskModal');
        }

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('fixed')) {
                const modals = document.querySelectorAll('.fixed.hidden');
                modals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            }
        });

        <?php if (isset($_GET['view_tasks'])): ?>
        document.addEventListener('DOMContentLoaded', function() {
            openModal('tasksModal');
        });
        <?php endif; ?>
    </script>
</body>
</html>