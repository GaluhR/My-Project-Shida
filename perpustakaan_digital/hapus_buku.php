<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: index.php");
}

catatAktivitas($_SESSION['user'], "Menghapus buku dengan ID: $id");
?>