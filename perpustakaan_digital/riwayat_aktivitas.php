<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$conn = getConnection();
$stmt = $conn->prepare("SELECT * FROM riwayat_aktivitas ORDER BY waktu DESC");
$stmt->execute();
$result = $stmt->get_result();
$riwayat = [];

while ($row = $result->fetch_assoc()) {
    $riwayat[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Aktivitas Admin</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border : 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        a.button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Riwayat Aktivitas Admin</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Aktivitas</th>
            <th>Waktu</th>
        </tr>
        <?php foreach ($riwayat as $aktivitas): ?>
        <tr>
            <td><?php echo $aktivitas['id']; ?></td>
            <td><?php echo htmlspecialchars($aktivitas['user']); ?></td>
            <td><?php echo htmlspecialchars($aktivitas['aktivitas']); ?></td>
            <td><?php echo $aktivitas['waktu']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php" class="button">Kembali ke Halaman Utama</a>
</body>
</html>