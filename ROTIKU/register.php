<?php
include('db.php'); // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];

    // Query untuk menyimpan data pengguna
    $query = "INSERT INTO users (nama, username, password, email) VALUES ('$nama', '$username', '$password', '$email')";
    if (mysqli_query($koneksi, $query)) {
        echo "Pendaftaran berhasil! Silakan <a href='login.php'>login</a>.";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <form class="form" method="POST">
        <h2 class="login-title">Register</h2>
        <input type="text" name="nama" placeholder="Nama" class="login-input" required>
        <input type="text" name="username" placeholder="Username" class="login-input" required>
        <input type="password" name="password" placeholder="Password" class="login-input" required>
        <input type="email" name="email" placeholder="Email" class="login-input" required>
        <input type="submit" value="Register" class="login-button">
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>

</body>

</html>