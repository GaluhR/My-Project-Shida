<?php
session_start();
$conn = new mysqli("localhost", "root", "", "auten");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='index.php';</script>";
    }
}
?>
