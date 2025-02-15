<?php
session_start();
if (!isset($_SESSION['nama']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat datang <?php echo htmlspecialchars($_SESSION['nama']); ?>, Anda login sebagai <?php echo htmlspecialchars($_SESSION['role']); ?>.</h1>
</body>
</html>
