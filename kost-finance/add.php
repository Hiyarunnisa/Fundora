<?php
// Koneksi ke database
include 'db.php';

// Ambil data dari form
$deskripsi = $_POST['deskripsi'];
$jumlah = $_POST['jumlah'];
$jenis = $_POST['jenis']; // Tambahan: ambil data jenis
$tanggal = $_POST['tanggal']; // Tambahan: ambil data tanggal

// Cek validitas
if (!empty($deskripsi) && is_numeric($jumlah) && !empty($jenis) && !empty($tanggal)) {
  $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (deskripsi, jumlah, jenis, tanggal) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "siss", $deskripsi, $jumlah, $jenis, $tanggal);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Balik ke halaman utama
header("Location: index.php");
exit();
?>
