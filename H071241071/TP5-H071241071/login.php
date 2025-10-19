<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

include 'data.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .login-container { max-width: 300px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; text-align: center; }
        .login-container label { display: block; text-align: left; opacity: 1; margin-bottom: 0; }
        .login-container input { width: 100%; padding: 5px; box-sizing: border-box; margin: 0 0 10px 0; }
        .login-container button { width: 100%; padding: 10px; background-color: #007BFF; color: white; border: none; box-sizing: border-box; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Silakan Login</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="proses_login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>