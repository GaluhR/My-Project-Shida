<?php
session_start();
include('db.php'); // Koneksi ke database
// Inisialisasi jumlah percobaan login
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$error = ''; // Inisialisasi variabel error
$captcha_error = ''; // Inisialisasi variabel untuk error CAPTCHA

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);
    $user = mysqli_fetch_assoc($result);

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        // Jika sudah 3 kali salah, verifikasi CAPTCHA
        if ($_SESSION['login_attempts'] >= 3) {
            $captcha_input = $_POST['captcha'];
            if ($captcha_input !== $_SESSION['captcha_code']) {
                $captcha_error = "CAPTCHA salah, silakan coba lagi."; // Pesan error CAPTCHA
            } else {
                // Reset percobaan login jika CAPTCHA benar
                $_SESSION['login_attempts'] = 0;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php"); 
                exit();
            }
        } else {
            // Jika login berhasil dan belum mencapai 3 percobaan, langsung login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_attempts'] = 0; 
            header("Location: index.php"); 
            exit();
        }
    } else {
        $_SESSION['login_attempts']++;
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <?php if ($error) {
        echo "<p style='color:red;'>$error</p>";
    } ?>
    <form class="form" method="POST" name="login">
        <h2 class="login-title">Login</h2>
        <input type="text" name="username" placeholder="Username" class="login-input" required>
        <input type="password" name="password" placeholder="Password" class="login-input" required>

        <?php if ($_SESSION['login_attempts'] >= 3) { ?>
            <img src="captcha.php" alt="CAPTCHA" /><br>
            <input type="text" name="captcha" placeholder="Masukkan CAPTCHA" class="login-input" required>
            <?php if ($captcha_error) {
                echo "<span style='color:red;'>$captcha_error</span>"; // Menampilkan pesan error CAPTCHA
            } ?>
        <?php } ?>

        <input type="submit" value="Login" class="login-button">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </form>

</body>

</html>