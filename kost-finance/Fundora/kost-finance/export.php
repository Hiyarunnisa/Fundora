<?php
include 'db.php';

// Atur header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=transaksi_kost.xls");

echo "Tanggal\tDeskripsi\tJenis\tJumlah\n";

$query = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  echo "{$row['tanggal']}\t{$row['deskripsi']}\t{$row['jenis']}\t{$row['jumlah']}\n";
}
?>
