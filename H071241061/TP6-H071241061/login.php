<?php
session_start();
require 'db.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role, project_manager_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['project_manager_id'] = $user['project_manager_id'];

                // Redirect ke dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan!';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-100 to-pink-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <div class="bg-gradient-to-r from-pink-400 to-pink-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Proyek</h1>
                <p class="text-gray-500 mt-2">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <p><?= htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form method="POST" action="">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           placeholder="Masukkan username">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                           placeholder="Masukkan password">
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white font-semibold py-3 rounded-lg hover:from-pink-600 hover:to-pink-700 transition duration-300 shadow-lg">
                    Login
                </button>
            </form>

            <!-- Info Akun Demo -->
            <div class="mt-8 p-4 bg-pink-50 rounded-lg">
                <p class="text-sm font-semibold text-gray-700 mb-2">Akun Demo:</p>
                <div class="text-xs text-gray-600 space-y-1">
                    <p><strong>Super Admin:</strong> superadmin / admin123</p>
                    <p><strong>Manager:</strong> manager1 / manager123</p>
                    <p><strong>Manager:</strong> manager2 / manager456</p>
                    <p><strong>Member:</strong> member1 / member123</p>
                    <p><strong>Member:</strong> member2 / member456</p>
                    <p><strong>Member:</strong> member3 / member789</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
