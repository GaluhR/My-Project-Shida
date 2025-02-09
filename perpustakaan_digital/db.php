<?php

include 'koneksi.php';

function tambahBuku($judul, $penulis, $tahun, $genre) {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, tahun, genre) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", htmlspecialchars($judul), htmlspecialchars($penulis), htmlspecialchars($tahun), htmlspecialchars($genre));
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function ambilSemuaBuku() {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM buku");
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = [];
    while ($row = $result->fetch_assoc()) {
        $buku[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $buku;
}

function cariBuku($keyword) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ?");
    $keyword = "%" . htmlspecialchars($keyword) . "%";
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    $hasil_cari = [];
    while ($row = $result->fetch_assoc()) {
        $hasil_cari[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $hasil_cari;
}

function catatAktivitas($user, $aktivitas) {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO riwayat_aktivitas (user, aktivitas) VALUES (?, ?)");
    $stmt->bind_param("ss", htmlspecialchars($user), htmlspecialchars($aktivitas));
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

?>