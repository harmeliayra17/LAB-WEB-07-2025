<?php
session_start();

// Jika tidak ada session 'user', tendang kembali ke halaman login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Mengimpor data semua pengguna untuk ditampilkan oleh admin
require 'data.php';

$loggedInUser = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <?php if ($loggedInUser['username'] === 'adminxxx'): ?>
                    <h1 class="text-3xl font-bold">Selamat Datang, Admin!</h1>
                <?php else: ?>
                    <h1 class="text-3xl font-bold">Selamat Datang, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</h1>
                <?php endif; ?>
                
                <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
            </div>

            <?php if ($loggedInUser['username'] === 'adminxxx'): ?>
                <h2 class="text-2xl mb-4">Data Semua Pengguna</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 border">Nama</th>
                                <th class="py-2 px-4 border">Username</th>
                                <th class="py-2 px-4 border">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <h2 class="text-2xl mb-4">Data Anda</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <tbody>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50 w-1/4">Nama</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['name']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Username</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['username']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Email</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['email']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Jenis Kelamin</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['gender']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Fakultas</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['faculty']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Angkatan</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['batch']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>