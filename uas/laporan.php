<?php
require('fpdf/fpdf.php');
include 'koneksi.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Report Mahasiswa', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nama', 1);
$pdf->Cell(70, 10, 'Alamat', 1);
$pdf->Cell(50, 10, 'No HP', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

$query = "SELECT * FROM mahasiswa";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, $row['nama'], 1);
    $pdf->Cell(70, 10, $row['alamat'], 1);
    $pdf->Cell(50, 10, $row['no_hp'], 1);
    $pdf->Ln();
}

$pdf->Output('I', 'Report_Mahasiswa.pdf');
?>
