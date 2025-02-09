<?php
session_start();
include 'db.php';
$buku = ambilSemuaBuku();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
        a.button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventaris Buku</h1>
        <table>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Genre</th>
            </tr>
            <?php foreach ($buku as $b): ?>
            <tr>
                <td><?php echo htmlspecialchars($b['judul']); ?></td>
                <td><?php echo htmlspecialchars($b['penulis']); ?></td>
                <td><?php echo htmlspecialchars($b['tahun']); ?></td>
                <td><?php echo htmlspecialchars($b['genre']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table> 
        <button onclick="window.print()">Cetak Laporan</button> 
        <a href="index.php" class="button">Kembali ke Daftar Buku</a>
    </div>
</body>
</html>
