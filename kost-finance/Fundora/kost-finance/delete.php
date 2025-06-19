<?php
// Koneksi ke database
include 'db.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Kembali ke halaman utama
header("Location: index.php");
exit();
?>
