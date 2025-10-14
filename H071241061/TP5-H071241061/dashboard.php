<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$currentUser = $_SESSION['user'];
$isAdmin = ($currentUser['username'] === 'adminxxx'); 

if ($isAdmin) {
    require_once 'data.php';
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
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: #dc9dd8ff;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .logout-btn {
            background: white;
            color: #a655a1ff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #f0f0f0;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .welcome-box h2 {
            color: #dc9dd8ff;
            margin-bottom: 10px;
        }
        
        .user-info {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .user-info h3 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #dc9dd8ff;
            padding-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        thead {
            background: #dc9dd8ff;
            color: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
        }
        
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        tbody tr:hover {
            background: #f0f0f0;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-admin {
            background: #ff6b6b;
            color: white;
        }
        
        .badge-user {
            background: #51cf66;
            color: white;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar h1 {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .logout-btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            .container {
                padding: 10px;
                margin: 10px;
            }

            .welcome-box, .user-info {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background: white;
                padding: 10px;
            }

            td {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                border: none;
                border-bottom: 1px solid #eee;
            }

            td:last-child {
                border-bottom: none;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #555;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Dashboard</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    
    <div class="container">
        <div class="welcome-box">
            <?php if ($isAdmin): ?>
                <h2>Selamat Datang, Admin!</h2>
                <p>Anda memiliki akses penuh ke semua data pengguna.</p>
            <?php else: ?>
                <h2>Selamat Datang, <?php echo htmlspecialchars($currentUser['name']); ?>!</h2>
                <p>Berikut adalah informasi profil Anda.</p>
            <?php endif; ?>
        </div>
        
        <?php if ($isAdmin): ?>
            <div class="user-info">
                <h3>Data Semua Pengguna</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Fakultas</th>
                            <th>Angkatan</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td data-label="Username"><?php echo htmlspecialchars($user['username']); ?></td>
                                <td data-label="Nama"><?php echo htmlspecialchars($user['name']); ?></td>
                                <td data-label="Email"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td data-label="Gender"><?php echo isset($user['gender']) ? htmlspecialchars($user['gender']) : '-'; ?></td>
                                <td data-label="Fakultas"><?php echo isset($user['faculty']) ? htmlspecialchars($user['faculty']) : '-'; ?></td>
                                <td data-label="Angkatan"><?php echo isset($user['batch']) ? htmlspecialchars($user['batch']) : '-'; ?></td>
                                <td data-label="Role">
                                    <?php if ($user['username'] === 'adminxxx'): ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php else: ?>
                                        <span class="badge badge-user">User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="user-info">
                <h3>Informasi Profil Anda</h3>
                <div class="info-row">
                    <div class="info-label">Username:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['username']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama Lengkap:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['name']); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['email']); ?></div>
                </div>
                <?php if (isset($currentUser['gender'])): ?>
                <div class="info-row">
                    <div class="info-label">Gender:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['gender']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (isset($currentUser['faculty'])): ?>
                <div class="info-row">
                    <div class="info-label">Fakultas:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['faculty']); ?></div>
                </div>
                <?php endif; ?>
                <?php if (isset($currentUser['batch'])): ?>
                <div class="info-row">
                    <div class="info-label">Angkatan:</div>
                    <div class="info-value"><?php echo htmlspecialchars($currentUser['batch']); ?></div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
