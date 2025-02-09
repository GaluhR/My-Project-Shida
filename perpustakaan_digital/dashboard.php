<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Utama Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .welcome-message {
            font-size: 20px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Halaman Utama Pengelolaan Perpustakaan Digital</h1>
    <div class="welcome-message">
        Selamat datang, Admin!
    </div>
    <a href="index.php">Kelola Buku</a>
    <a href="riwayat_aktivitas.php">Riwayat Aktivitas</a>
    <a href="logout.php">Logout</a>
</body>
</html>