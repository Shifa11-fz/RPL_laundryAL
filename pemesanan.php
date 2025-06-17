<?php
include 'koneksi.php';

$search = '';
if (isset($_GET['cari'])) {
  $search = mysqli_real_escape_string($conn, $_GET['cari']);
  $query = "SELECT pembelian.id, pembelian.nama_pelanggan, pembelian.telepon, pembelian.berat, 
              paket.nama_paket, pembelian.bayar, pembelian.metode_bayar, pembelian.total, pembelian.tanggal
            FROM pembelian
            JOIN paket ON pembelian.id_paket = paket.id_paket
            WHERE pembelian.nama_pelanggan LIKE '%$search%' OR pembelian.telepon LIKE '%$search%'
            ORDER BY pembelian.id DESC";
} else {
  $query = "SELECT pembelian.id, pembelian.nama_pelanggan, pembelian.telepon, pembelian.berat, 
              paket.nama_paket, pembelian.bayar, pembelian.metode_bayar, pembelian.total, pembelian.tanggal
            FROM pembelian
            JOIN paket ON pembelian.id_paket = paket.id_paket
            ORDER BY pembelian.id DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Database Pembelian - Laundry AL</title>
  <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/style_p.css">

  <script>
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('show');
    }
  </script>
</head>

<body>
  <div class="hamburger" onclick="toggleSidebar()">☰ Menu</div>

  <nav class="sidebar">
    <a href="index.php" class="nav-link">Beranda</a>
    <a href="pemesanan.php" class="nav-link active">Daftar Pemesanan</a>
    <a href="form_input.php" class="nav-link">Input Pemesanan</a>
    <a href="pengeluaran.php" class="nav-link">Data Pengeluaran</a>
  </nav>

  <div class="main">
    <h1>Data Pembelian Laundry AL</h1>

    <form method="get" class="search-form">
      <input type="text" name="cari" placeholder="Cari nama / telepon..." value="<?= htmlspecialchars($search) ?>">
      <input type="submit" class="btn" value="Cari">
      <button type="button" class="btn" onclick="window.location.href='pemesanan.php'">Reset</button>
    </form>

    <table>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Berat (Kg)</th>
        <th>Paket</th>
        <th>Nominal</th>
        <th>Keterangan</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($result)) {
        $status = (trim(strtolower($row['metode_bayar'])) === 'langsung') ? 'Lunas' : 'Belum';
        $tanggal = date('d-m-Y', strtotime($row['tanggal']));
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_pelanggan']}</td>
                <td>{$row['telepon']}</td>
                <td>{$row['berat']}</td>
                <td>{$row['nama_paket']}</td>
                <td>Rp " . number_format($row['bayar'], 0, ',', '.') . "</td>
                <td>{$status}</td>
                <td>{$tanggal}</td>
                <td>
                  <form action='edit.php' method='get' style='display:inline-block'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button class='btn-aksi'>Edit</button>
                  </form>
                  <form action='hapus.php' method='get' onsubmit=\"return confirm('Yakin ingin menghapus?')\" style='display:inline-block'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button class='btn-aksi red'>Hapus</button>
                  </form>
                  <form action='cetak_struk.php' method='get' target='_blank' style='display:inline-block'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button class='btn-aksi green'>Struk</button>
                  </form>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </table>
  </div>
</body>

</html>
