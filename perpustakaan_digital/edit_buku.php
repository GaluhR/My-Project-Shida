<?php
session_start();
include 'db.php';

$daftar_genre = ['Fantasi', 'Horor', 'Sejarah', 'Dongeng', 'Romantis', 'Petualangan', 'Sains'];

$tahun_terbit = range(1945, (int)date('Y'));

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM buku WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $tahun = trim($_POST['tahun']);
    $genre = trim($_POST['genre']);

    if (empty($judul) || empty($penulis) || empty($tahun) || empty($genre)) {
        $error_message = "Semua field harus diisi!";
    } elseif (!is_numeric($tahun) || !in_array($tahun, array_map('strval', $tahun_terbit))) {
        $error_message = "Tahun harus dipilih dari daftar yang tersedia!";
    } elseif (!in_array($genre, $daftar_genre)) {
        $error_message = "Genre tidak valid!";
    } else {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE buku SET judul = ?, penulis = ?, tahun = ?, genre = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $judul, $penulis, $tahun, $genre, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        catatAktivitas($_SESSION['user'], "Mengedit buku: $judul");
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Buku</h1>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="judul">Judul Buku:</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
            </div>
            <div class="form-group">
                <label for="penulis">Penulis:</label>
                <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo htmlspecialchars($buku['penulis']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun Terbit:</label>
                <select class="form-control" id="tahun" name="tahun" required>
                    <option value="">-- Pilih Tahun Terbit --</option>
                    <?php foreach ($tahun_terbit as $tahun): ?>
                        <option value="<?php echo $tahun; ?>" <?php echo ($tahun == $buku['tahun']) ? 'selected' : ''; ?>>
                            <?php echo $tahun; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select class="form-control" id="genre" name="genre" required>
                    <option value="">-- Pilih Genre --</option>
                    <?php foreach ($daftar_genre as $item): ?>
                        <option value="<?php echo $item; ?>" <?php echo ($item == $buku['genre']) ? 'selected' : ''; ?>>
                            <?php echo $item; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Buku</button>
        </form>
        <a href="index.php" class="btn btn-secondary btn-block mt-3">Kembali ke Daftar Buku</a>
    </div>
</body>
</html>
