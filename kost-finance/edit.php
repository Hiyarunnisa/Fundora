<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT * FROM transaksi WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $tanggal = $_POST['tanggal'];

    $update = "UPDATE transaksi SET deskripsi='$deskripsi', jumlah='$jumlah', jenis='$jenis', tanggal='$tanggal' WHERE id=$id";
    mysqli_query($conn, $update);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Transaksi</title>
</head>
<body>
  <h2>Edit Transaksi</h2>
  <form method="POST">
    <label>Deskripsi:</label><br>
    <input type="text" name="deskripsi" value="<?= $data['deskripsi'] ?>" required><br><br>

    <label>Jumlah:</label><br>
    <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required><br><br>

    <label>Jenis:</label><br>
    <select name="jenis" required>
      <option value="pemasukan" <?= $data['jenis'] == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
      <option value="pengeluaran" <?= $data['jenis'] == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
    </select><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required><br><br>

    <button type="submit" name="submit">Simpan</button>
  </form>
</body>
</html>
