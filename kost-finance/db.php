<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "keuangan_kost";

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>