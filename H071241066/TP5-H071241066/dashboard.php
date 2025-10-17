<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$current_user = $_SESSION['user'];
$is_admin = $current_user['username'] === 'adminxxx';
$welcome_name = $is_admin ? 'Admin' : $current_user['name'];

if ($is_admin) {
    require_once 'data.php';
    $display_users = array_map(function($user) {
        unset($user['password']);
        return $user;
    }, $users);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            <?php if ($is_admin): ?>
                background: linear-gradient(135deg, #ffc5d9 0%, #ffb8d1 100%);
            <?php else: ?>
                background: linear-gradient(135deg, #f5e6d3 0%, #f9e4c8 100%);
            <?php endif; ?>
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #333;
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logout-btn {
            padding: 10px 25px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .content-card h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            <?php if ($is_admin): ?>
                border-bottom: 3px solid #ff91b4;
            <?php else: ?>
                border-bottom: 3px solid #d4a574;
            <?php endif; ?>
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th {
            background: #ff91b4;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }
        
        th:first-child {
            border-top-left-radius: 8px;
        }
        
        th:last-child {
            border-top-right-radius: 8px;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
        }
        
        tr:hover td {
            background-color: #fff5f8;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .user-data {
            display: grid;
            gap: 15px;
            margin-top: 20px;
        }
        
        .user-data-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #fef9f3;
            border-radius: 8px;
            border-left: 4px solid #d4a574;
            transition: all 0.3s ease;
        }
        
        .user-data-item:hover {
            transform: translateY(5px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .user-data-item label {
            font-weight: 600;
            color: #d4a574;
            min-width: 120px;
            margin-right: 15px;
        }
        
        .user-data-item span {
            color: #333;
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .header h1 {
                font-size: 22px;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                Selamat Datang, <?= htmlspecialchars($welcome_name) ?>
            </h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <?php if ($is_admin): ?>
            <div class="content-card">
                <h2>Data Pengguna</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Fakultas</th>
                                <th>Angkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($display_users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['username'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['gender'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['faculty'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['batch'] ?? '-') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <div class="content-card">
                <h2>Profil Anda</h2>
                <div class="user-data">
                    <div class="user-data-item">
                        <label>Nama</label>
                        <span><?= htmlspecialchars($current_user['name'] ?? '-') ?></span>
                    </div>
                    <div class="user-data-item">
                        <label>Username</label>
                        <span><?= htmlspecialchars($current_user['username'] ?? '-') ?></span>
                    </div>
                    <div class="user-data-item">
                        <label>Email</label>
                        <span><?= htmlspecialchars($current_user['email'] ?? '-') ?></span>
                    </div>
                    <div class="user-data-item">
                        <label>Gender</label>
                        <span><?= htmlspecialchars($current_user['gender'] ?? '-') ?></span>
                    </div>
                    <div class="user-data-item">
                        <label>Fakultas</label>
                        <span><?= htmlspecialchars($current_user['faculty'] ?? '-') ?></span>
                    </div>
                    <div class="user-data-item">
                        <label>Angkatan</label>
                        <span><?= htmlspecialchars($current_user['batch'] ?? '-') ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>