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
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>KapeTann | Login Form</title>
        <link rel="stylesheet" href="../assets/css/login.css"/>
        <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico"><!-- Favicon / Icon -->
        <script src="https://accounts.google.com/gsi/client" async defer></script>
    </head>
    <body>
    <?php if ($error) {
        echo "<p style='color:red;'>$error</p>";
    } ?>
            <form class="form" method="post" name="login">
                <center>
                    <img src="../assets/images/bg.png" alt="" class="img img-fluid">
                </center>
                <hr />
                <h1 class="login-title">Login</h1>
                <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
                <input type="password" class="login-input" name="password" placeholder="Password"/>

                <?php if ($_SESSION['login_attempts'] >= 3) { ?>
            <img src="captcha.php" alt="CAPTCHA" /><br>
            <input type="text" name="captcha" placeholder="Masukkan CAPTCHA" class="login-input" required>
            <?php if ($captcha_error) {
                echo "<span style='color:red;'>$captcha_error</span>"; // Menampilkan pesan error CAPTCHA
            } ?>
        <?php } ?>

                <input type="submit" value="Login" name="submit" class="login-button"/>
                <p class="link">Don't have an account? <a href="registration.php">Register here!</a></p>
                <hr />

                <div id="g_id_onload"
                    data-client_id=""
                    data-context="signin"
                    data-ux_mode="popup"
                    data-login_uri=""
                    data-auto_prompt="false">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="rectangular"
                    data-theme="outline"
                    data-text="signin_with"
                    data-size="large"
                    data-logo_alignment="center"
                    data-callback="onSignIn">
                </div>
        </form>

        <script src="js/script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>
            function onSignIn(googleUser) {
                // Get the user ID token
                var id_token = googleUser.getAuthResponse().id_token;

                // Send the token to the server using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'set_session.php',
                    data: { id_token: id_token },
                    success: function(response) {
                        // Redirect to the index.php page
                        window.location.href = 'index.php';
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            }
        </script>
    </body>
</html>