<?php
session_start();

if (isset($_SESSION['user'])) { 
    header('Location: dashboard.php');
    exit;
}

$error = isset($_SESSION['error']) ? $_SESSION['error'] : ''; 
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #dc9dd8ff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #dc9dd8ff;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: #dc9dd8ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #b162abff;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .info {
            margin-top: 20px;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 5px;
            font-size: 12px;
        }
        
        .info h4 {
            margin-bottom: 10px;
            color: #6e3169ff;
        }
        
        .info p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Sistem</h2>
        
        <?php if ($error): ?>  
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?> 
        
        <form action="proses_login.php" method="POST"> 
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="info">
            <h4>Info Login:</h4>
            <p><strong>Admin:</strong> adminxxx / admin123</p>
            <p><strong>User:</strong> naldi_aja / naldi123</p>
            <p><strong>User:</strong> ervin / ervin123</p>
            <p><strong>User:</strong> yusra59 / yusra123</p>
            <p><strong>User:</strong> muslih23 / muslih123</p>
        </div>
    </div>
</body>
</html>