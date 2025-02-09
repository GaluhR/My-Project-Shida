<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$buku = ambilSemuaBuku();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        a.button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku</h1>
    <a href="tambah_buku.php" class="button">Tambah Buku</a>
    <a href="cari_buku.php" class="button">Cari Buku</a>
    <a href="laporan.php" class="button">Laporan Buku</a>
    <a href="dashboard.php" class="button">Kembali ke halaman utama</a>
    <table>
        <tr>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Tahun Terbit</th>
            <th>Genre</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($buku as $b): ?>
        <tr>
            <td><?php echo $b['judul']; ?></td>
            <td><?php echo $b['penulis']; ?></td>
            <td><?php echo $b['tahun']; ?></td>
            <td><?php echo $b['genre']; ?></td>
            <td>
                <a href="edit_buku.php?id=<?php echo $b['id']; ?>">Edit</a>
                <a href="hapus_buku.php?id=<?php echo $b['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>