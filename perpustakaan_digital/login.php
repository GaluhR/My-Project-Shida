<?php
session_start(); //memulai sesi pengguna
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan_error = ""; 

// Daftar pengguna dengan password yang sudah di-hash
$users = [
    'yoshida' => password_hash('yoshida123', PASSWORD_DEFAULT),
    'admin' => password_hash('admin123', PASSWORD_DEFAULT),
];

// hasil hash password
$hashed_users = [];
foreach ($users as $username => $hashedPassword) {
    $hashed_users[] = "Username: $username, Hash: $hashedPassword";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (array_key_exists($username, $users) && password_verify($password, $users[$username])) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit; 
    } else {
        $pesan_error = "<p style='color:red'>Username atau password salah!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .welcome-message {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .hash-output {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <div class="welcome-message">
            Selamat datang di Perpustakaan Digital<br>
            "Membaca adalah jendela dunia."
        </div>
        <?php if ($pesan_error): ?>
            <div><?php echo $pesan_error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        
    </div>
</body>
</html>