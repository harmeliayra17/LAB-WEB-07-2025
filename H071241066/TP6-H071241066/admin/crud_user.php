<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['user']) || strtoupper($_SESSION['user']['role']) !== 'ADMIN') {
    die("Akses ditolak. Hanya Admin yang dapat mengakses halaman ini.");
}

$id = $username = $role = $project_manager_id = '';
$edit_mode = false;
$error_message = "";

// untuk dropdown "Pilih Manager"
$managers = mysqli_query($conn, "SELECT id, username FROM users WHERE role = 'MANAGER'");

// mode edit
if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $id = (int)$_GET['edit_id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $role = $row['role'];
        $project_manager_id = $row['project_manager_id'];
    }
    
    mysqli_stmt_close($stmt);
}

// Proses tambah / update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = strtoupper(trim($_POST['role']));
    $project_manager_id = ($role === 'MEMBER' && !empty($_POST['project_manager_id'])) ? (int)$_POST['project_manager_id'] : NULL;

    if ($username === '' || (!$edit_mode && $password === '') || $role === '') {
        $error_message = "Semua field wajib diisi.";
    } else {
        if ($edit_mode) {
            $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? AND id != ?");
            mysqli_stmt_bind_param($stmt, "si", $username, $id);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
            mysqli_stmt_bind_param($stmt, "s", $username);
        }
        
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Username sudah digunakan. Silakan pilih username lain.";
            mysqli_stmt_close($stmt);
        } else {
            mysqli_stmt_close($stmt);
            
            if ($edit_mode) {
                if ($password !== '') {
                    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = mysqli_prepare($conn, "UPDATE users SET username = ?, password = ?, role = ?, project_manager_id = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, "sssii", $username, $password_hashed, $role, $project_manager_id, $id);
                } else {
                    $stmt = mysqli_prepare($conn, "UPDATE users SET username = ?, role = ?, project_manager_id = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, "ssii", $username, $role, $project_manager_id, $id);
                }
            } else {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssi", $username, $password_hashed, $role, $project_manager_id);
            }

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $error_message = "Terjadi kesalahan: " . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

<header class="bg-white shadow-md">
    <div class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-blue-700">Kelola User</h1>
        <a href="../logout.php"
           class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md flex items-center space-x-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 
                      2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span>Logout</span>
        </a>
    </div>
</header>

<main class="max-w-3xl mx-auto p-8 bg-white shadow-2xl rounded-2xl mt-10 space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800"><?= $edit_mode ? 'EDIT USER' : 'TAMBAH USER' ?></h2>
        <a href="admin_dashboard.php"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    
    <form method="POST" class="space-y-6">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Password <?= $edit_mode ? '(opsional)' : '' ?></label>
            <input type="password" name="password"
                   placeholder="<?= $edit_mode ? 'Biarkan kosong jika tidak ingin mengganti password' : 'Masukkan password baru' ?>"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   <?= $edit_mode ? '' : 'required' ?>>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Role</label>
            <select name="role" id="roleSelect"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                <option value="">-- Pilih Role --</option>
                <option value="MANAGER" <?= strtoupper($role) === 'MANAGER' ? 'selected' : '' ?>>Manager</option>
                <option value="MEMBER" <?= strtoupper($role) === 'MEMBER' ? 'selected' : '' ?>>Member</option>
            </select>
        </div>

        <div id="managerSelectDiv" class="<?= strtoupper($role) === 'MEMBER' ? '' : 'hidden' ?>">
            <label class="block text-gray-700 font-semibold mb-2">Pilih Manager</label>
            <select name="project_manager_id"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    <?= strtoupper($role) === 'MEMBER' ? 'required' : '' ?>>
                <option value="">-- Pilih Manager --</option>
                <?php mysqli_data_seek($managers, 0); while ($m = mysqli_fetch_assoc($managers)): ?>
                    <option value="<?= $m['id'] ?>" <?= $project_manager_id == $m['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['username']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center items-center bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-90 text-white font-semibold py-3 rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>
                Simpan
            </button>
        </div>
    </form>
</main>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const managerDiv = document.getElementById('managerSelectDiv');
    roleSelect.addEventListener('change', () => {
        if (roleSelect.value === 'MEMBER') {
            managerDiv.classList.remove('hidden');
            managerDiv.querySelector('select').setAttribute('required', 'required');
        } else {
            managerDiv.classList.add('hidden');
            managerDiv.querySelector('select').removeAttribute('required');
        }
    });
</script>

</body>
</html>
