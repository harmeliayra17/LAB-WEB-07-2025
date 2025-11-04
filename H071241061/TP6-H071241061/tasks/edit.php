<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Project Manager') {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];


// Ambil data tugas (cek kepemilikan)
$stmt = $conn->prepare("
    SELECT t.* FROM tasks t 
    JOIN projects p ON t.project_id = p.id 
    WHERE t.id = ? AND p.manager_id = ?
");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: index.php');
    exit();
}

$task = $result->fetch_assoc();
$stmt->close();

// Ambil proyek milik manager yang sedang login
$stmt_projects = $conn->prepare("
    SELECT * FROM projects WHERE manager_id = ? ORDER BY nama_proyek
");
$stmt_projects->bind_param("i", $user_id);
$stmt_projects->execute();
$projects = $stmt_projects->get_result();

// Ambil team member di bawah manager ini
$stmt_members = $conn->prepare("
    SELECT * FROM users WHERE project_manager_id = ? ORDER BY username
");
$stmt_members->bind_param("i", $user_id);
$stmt_members->execute();
$members = $stmt_members->get_result();

// Proses update tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_tugas = $_POST['nama_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $project_id = $_POST['project_id'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];

    $stmt_update = $conn->prepare("
        UPDATE tasks 
        SET nama_tugas = ?, 
            deskripsi = ?, 
            project_id = ?, 
            assigned_to = ?, 
            status = ?
        WHERE id = ?
    ");
    $stmt_update->bind_param("ssiiii", $nama_tugas, $deskripsi, $project_id, $assigned_to, $status, $id);

    if ($stmt_update->execute()) {
        $success = 'Tugas berhasil diupdate!';

        $stmt_refresh = $conn->prepare("
            SELECT t.* FROM tasks t 
            JOIN projects p ON t.project_id = p.id 
            WHERE t.id = ? AND p.manager_id = ?
        ");
        $stmt_refresh->bind_param("ii", $id, $user_id);
        $stmt_refresh->execute();
        $task = $stmt_refresh->get_result()->fetch_assoc();
        $stmt_refresh->close();

    } else {
        $error = 'Gagal mengupdate tugas: ' . $stmt_update->error;
    }

    $stmt_update->close();
}

$stmt_projects->close();
$stmt_members->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../dashboard.php" class="flex items-center">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-600 w-10 h-10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-800">Manajemen Proyek</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="../dashboard.php" class="text-gray-600 hover:text-pink-600 font-semibold">Dashboard</a>
                    <a href="index.php" class="text-gray-600 hover:text-pink-600 font-semibold">Tugas</a>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Tugas</h1>
            <p class="text-gray-600 mt-2">Update informasi tugas</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <!-- Nama Tugas -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Nama Tugas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_tugas" required 
                           value="<?php echo $task['nama_tugas']; ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" required rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"><?php echo $task['deskripsi']; ?></textarea>
                </div>

                <!-- Pilih Proyek -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Proyek <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        <option value="">-- Pilih Proyek --</option>
                        <?php while ($project = mysqli_fetch_assoc($projects)): ?>
                            <option value="<?php echo $project['id']; ?>" 
                                    <?php echo ($project['id'] == $task['project_id']) ? 'selected' : ''; ?>>
                                <?php echo $project['nama_proyek']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tugaskan Ke -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Tugaskan Ke <span class="text-red-500">*</span>
                    </label>
                    <select name="assigned_to" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        <option value="">-- Pilih Team Member --</option>
                        <?php while ($member = mysqli_fetch_assoc($members)): ?>
                            <option value="<?php echo $member['id']; ?>"
                                    <?php echo ($member['id'] == $task['assigned_to']) ? 'selected' : ''; ?>>
                                <?php echo $member['username']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        <option value="belum" <?php echo ($task['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                        <option value="proses" <?php echo ($task['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                        <option value="selesai" <?php echo ($task['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                        Update Tugas
                    </button>
                    <a href="index.php" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>