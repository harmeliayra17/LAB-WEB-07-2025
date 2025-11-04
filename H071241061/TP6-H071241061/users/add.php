<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Super Admin') {
    header('Location: ../login.php');
    exit();
}

$error = '';
$success = '';

// Ambil daftar Project Manager untuk dropdown
$managers = mysqli_query($conn, "SELECT * FROM users WHERE role='Project Manager' ORDER BY username");

// Proses tambah user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $project_manager_id = isset($_POST['project_manager_id']) ? $_POST['project_manager_id'] : NULL;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($check) > 0) {
        $error = 'Username sudah digunakan!';
    } else {
        if ($role == 'Team Member' && $project_manager_id) { 
            $query = "INSERT INTO users (username, password, role, project_manager_id) 
                      VALUES ('$username', '$hashed_password', '$role', '$project_manager_id')";
        } else {
            $query = "INSERT INTO users (username, password, role)  
                      VALUES ('$username', '$hashed_password', '$role')";
        }
        
        if (mysqli_query($conn, $query)) {
            $success = 'User berhasil ditambahkan!';
        } else {
            $error = 'Gagal menambahkan user: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="../dashboard.php" class="flex items-center">
                        <div class="bg-gradient-to-r from-pink-400 to-pink-600 w-10 h-10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-800">Manajemen Proyek</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="../dashboard.php" class="text-gray-600 hover:text-pink-600 font-semibold">Dashboard</a>
                    <a href="index.php" class="text-gray-600 hover:text-pink-600 font-semibold">Kelola User</a>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
            <p class="text-gray-600 mt-2">Isi form di bawah untuk menambah user</p>
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
                    <a href="index.php" class="font-semibold underline ml-2">Kembali ke daftar user</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <!-- Username -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           placeholder="Masukkan username">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           placeholder="Masukkan password">
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="role" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                            onchange="toggleManagerSelect()">
                        <option value="">-- Pilih Role --</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="Team Member">Team Member</option>
                    </select>
                </div>

                <!-- Project Manager (hanya muncul jika role = Team Member) -->
                <div class="mb-6" id="managerDiv" style="display: none;">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Project Manager <span class="text-red-500">*</span>
                    </label>
                    <select name="project_manager_id" id="project_manager_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                        <option value="">-- Pilih Project Manager --</option>
                        <?php while ($manager = mysqli_fetch_assoc($managers)): ?>
                            <option value="<?php echo $manager['id']; ?>">
                                <?php echo $manager['username']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-2">Team Member harus punya Project Manager</p>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                        Tambah Pengguna
                    </button>
                    <a href="index.php" 
                       class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleManagerSelect() {
            var role = document.getElementById('role').value;
            var managerDiv = document.getElementById('managerDiv');
            var managerSelect = document.getElementById('project_manager_id');
            
            if (role == 'Team Member') {
                managerDiv.style.display = 'block';
                managerSelect.required = true;
            } else {
                managerDiv.style.display = 'none';
                managerSelect.required = false;
            }
        }
    </script>
</body>
</html>