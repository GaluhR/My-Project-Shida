<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $query = "SELECT * FROM mahasiswa WHERE username = ? AND password = MD5(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Form Login</h1>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>


