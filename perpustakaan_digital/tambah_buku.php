<?php
session_start(); 
include 'db.php';

$daftar_genre = ['Fantasi', 'Horor', 'Sejarah', 'Dongeng', 'Romantis', 'Petualangan', 'Sains'];

$tahun_terbit = range(1945, (int)date('Y'));


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $tahun = trim($_POST['tahun']);
    $genre = trim($_POST['genre']);

    if (empty($judul) || empty($penulis) || empty($tahun) || empty($genre)) { //validation
        $error_message = "Semua field harus diisi!";
    } elseif (!is_numeric($tahun) || !in_array($tahun, array_map('strval', $tahun_terbit))) {
        $error_message = "Tahun harus dipilih dari daftar yang tersedia!";
    } elseif (!in_array($genre, $daftar_genre)) {
        $error_message = "Genre tidak valid!";
    } else {
        tambahBuku($judul, $penulis, $tahun, $genre);
        // Catat aktivitas pengguna
        catatAktivitas($_SESSION['user'], "Menambahkan buku: $judul");
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
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
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Buku</h1>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Judul Buku:</label>
            <input type="text" name="judul" required>
            <label>Penulis:</label>
            <input type="text" name="penulis" required>
            <label>Tahun Terbit:</label>
            <select name="tahun" required>
                <option value="">-- Pilih Tahun Terbit Buku  --</option>
                <?php foreach ($tahun_terbit as $tahun): ?>
                    <option value="<?php echo $tahun; ?>"><?php echo $tahun; ?></option>
                <?php endforeach; ?>
            </select>
            <label>Genre:</label>
            <select name="genre" required>
                <option value="">-- Pilih Genre --</option>
                <?php foreach ($daftar_genre as $item): ?>
                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Tambah Buku">
        </form>
        <a href="index.php">Kembali ke Daftar Buku</a>
    </div>
</body>
</html>
