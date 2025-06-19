<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
?>
<?php
include 'db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$conditions = [];

if ($filter === 'pemasukan' || $filter === 'pengeluaran') {
  $conditions[] = "LOWER(jenis) = '" . strtolower($filter) . "'";
}

if (!empty($search)) {
  $search = mysqli_real_escape_string($conn, $search);
  $conditions[] = "deskripsi LIKE '%$search%'";
}

$where = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

$query = "SELECT * FROM transaksi $where ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

// Total saldo, pemasukan, pengeluaran
$totalQuery = "SELECT 
    SUM(CASE WHEN jenis='pemasukan' THEN jumlah ELSE 0 END) AS total_pemasukan,
    SUM(CASE WHEN jenis='pengeluaran' THEN jumlah ELSE 0 END) AS total_pengeluaran
    FROM transaksi";
$totalResult = mysqli_query($conn, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult);

$totalSaldo = ($totalData['total_pemasukan'] ?? 0) - ($totalData['total_pengeluaran'] ?? 0);
$totalPemasukan = $totalData['total_pemasukan'] ?? 0;
$totalPengeluaran = $totalData['total_pengeluaran'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>FUNDORA</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/kost-finance/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
 <body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-brand"><i class="fas fa-wallet"></i> FUNDORA</div>
    <ul class="navbar-menu">
      <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
      <li><a href="#"><i class="fas fa-user-circle"></i> Profil</a></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout (<?= $_SESSION['username'] ?>)</a></li>
    </ul>
  </nav>
  <h1>FUNDORA</h1>
  <h3>FUN & DO IT: Organize Resources & Assets</h3>
  <!-- Form Tambah Transaksi -->
  <form action="add.php" method="POST">
    <input type="text" name="deskripsi" placeholder="Deskripsi" required>
    <input type="number" name="jumlah" placeholder="Jumlah" required>
    <select name="jenis" required>
      <option value="">Pilih Jenisnya di sini!</option>
      <option value="pemasukan">Pemasukan</option>
      <option value="pengeluaran">Pengeluaran</option>
    </select>
    <input type="date" name="tanggal" required>
    <button type="submit" class="btn">Submit Transaksi</button>
  </form>

  <!-- Filter & Search -->
  <form method="GET" style="margin: 20px 0;">
    <label for="filter">Tampilkan:</label>
    <select name="filter" onchange="this.form.submit()">
      <option value="">Semua</option>
      <option value="pemasukan" <?= $filter == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
      <option value="pengeluaran" <?= $filter == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
    </select>
    <input type="text" name="search" placeholder="Cari deskripsi..." value="<?= htmlspecialchars($search) ?>">
   <button type="submit"><i class="fas fa-search"></i> Cari</button>
  </form>

  <!-- Export -->
  <a class="btn-export" href="export.php"><i class="fas fa-file-excel"></i>  Unduh Riwayat Kas</a>

  <!-- List Transaksi -->
  <ul class="transaksi-list">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <li class="transaksi-item <?= $row['jenis'] === 'pemasukan' ? 'plus' : 'minus' ?>">
          <div class="transaksi-left">
            <img src="<?= $row['jenis'] === 'pemasukan' ? 'icons/plus.png' : 'icons/minus.png' ?>" class="transaksi-icon">
            <div>
              <strong><?= ucfirst($row['jenis']) ?></strong> - <?= htmlspecialchars($row['deskripsi']) ?>
              <div>Rp <?= number_format($row['jumlah'], 0, ',', '.') ?> | <?= date('d M Y', strtotime($row['tanggal'])) ?></div>
            </div>
          </div>
          <div class="transaksi-aksi">
            <a href="edit.php?id=<?= $row['id'] ?>" class="edit">✎</a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus transaksi ini?')">✖</a>
          </div>
        </li>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align: center;">Tidak ada data yang ditemukan.</p>
    <?php endif; ?>
  </ul>

  <!-- Total Saldo -->
  <h3>Total Saldo: Rp <?= number_format($totalSaldo, 0, ',', '.') ?></h3>

  <!-- Grafik -->
  <h2>Grafik Keuangan</h2>
  <canvas id="grafikKeuangan" width="400" height="200"></canvas>

  <script>
    const ctx = document.getElementById('grafikKeuangan').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Pemasukan', 'Pengeluaran'],
        datasets: [{
          label: 'Jumlah (Rp)',
          data: [<?= $totalPemasukan ?>, <?= $totalPengeluaran ?>],
          backgroundColor: ['#28a745', '#dc3545']
        }]
      },
      options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
