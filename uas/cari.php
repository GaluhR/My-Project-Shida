<form method="GET" action="">
    <input type="text" name="keyword" placeholder="Cari Nama, Alamat, atau Nomor HP" required>
    <button type="submit">Cari</button>
</form>

<?php
include 'koneksi.php';
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';

$query = "SELECT * FROM mahasiswa WHERE nama LIKE ? OR alamat LIKE ? OR no_hp LIKE ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $keyword, $keyword, $keyword);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>";
echo "<tr><th>Nama</th><th>Alamat</th><th>No HP</th><th>Aksi</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['nama']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['no_hp']}</td>
            <td>
                <a href='update.php?id={$row['id']}'>Update</a> | 
                <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
            </td>
          </tr>";
}
echo "</table>";
?>
