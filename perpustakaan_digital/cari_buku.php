<?php
session_start();
include 'db.php';

$hasil_cari = [];
if (isset($_POST['cari'])) {
    $keyword = $_POST['keyword'];
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ?");
    $keyword = "%$keyword%";
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $hasil_cari[] = $row;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Buku</title>
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
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 89%;
            padding: 10px;
            margin-right:  10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
        <h1>Cari Buku</h1>
        <form method="POST">
            <input type="text" name="keyword" placeholder="Masukkan kata kunci pencarian" required>
            <input type="submit" name="cari" value="Cari">
        </form>
        <h2>Hasil Pencarian:</h2>
        <table>
            <tr>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Genre</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($hasil_cari as $b): ?>
            <tr>
                <td><?php echo htmlspecialchars($b['judul']); ?></td>
                <td><?php echo htmlspecialchars($b['penulis']); ?></td>
                <td><?php echo htmlspecialchars($b['tahun']); ?></td>
                <td><?php echo htmlspecialchars($b['genre']); ?></td>
                <td>
                    <a href="edit_buku.php?id=<?php echo $b['id']; ?>">Edit</a>
                    <a href="hapus_buku.php?id=<?php echo $b['id']; ?>">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.php" class="button">Kembali ke Daftar Buku</a>
    </div>
</body>
</html>