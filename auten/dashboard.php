<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat datang, <?php echo $_SESSION['user']; ?>!</h1>
    <a href="logout.php">Logout</a>
</body>
</html>
