<?php
include 'db.php';
require('fpdf/fpdf.php');


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);


$pdf->Cell(0, 10, 'Laporan Produk Toko Roti', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Nama Produk', 1);
$pdf->Cell(60, 10, 'Harga Beli', 1);
$pdf->Cell(60, 10, 'Harga Jual', 1);
$pdf->Ln();


$query = "SELECT * FROM produk";
$result = $koneksi->query($query);

if (!$result) {
    die("Query failed: " . $koneksi->error);
}


$total_harga_beli = 0;
$total_harga_jual = 0;


$pdf->SetFont('Arial', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(60, 10, $row['nama_produk'], 1);
    $pdf->Cell(60, 10, 'Rp ' . number_format($row['harga_beli'], 0, ',', '.'), 1);
    $pdf->Cell(60, 10, 'Rp ' . number_format($row['harga_jual'], 0, ',', '.'), 1);
    $pdf->Ln();

    $total_harga_beli += $row['harga_beli'];
    $total_harga_jual += $row['harga_jual'];
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Total', 1);
$pdf->Cell(60, 10, 'Rp ' . number_format($total_harga_beli, 0, ',', '.'), 1); // Menghilangkan desimal
$pdf->Cell(60, 10, 'Rp ' . number_format($total_harga_jual, 0, ',', '.'), 1);
$pdf->Ln();

$pdf_output = $pdf->Output('S'); // 'S' untuk output sebagai string


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Preview Laporan Produk</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <center>
        <h1>Preview Laporan Produk</h1>
    </center>
    <iframe src="data:application/pdf;base64,<?php echo base64_encode($pdf_output); ?>" width="100%" height="600px"></iframe>

    <div class="button-container">
        <center><a href="index.php" class="button">Kembali Ke Produk</a></center>
    </div>
</body>

</html>