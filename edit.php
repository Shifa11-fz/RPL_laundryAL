<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  die("ID tidak valid.");
}

$query = "SELECT * FROM pembelian WHERE id = $id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
  die("Data tidak ditemukan.");
}
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Pemesanan - Laundry AL</title>
  <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
  <link rel="stylesheet" href="CSS/style_e.css">
</head>

<body>
  <div class="sidebar">
    <a href="index.php">Beranda</a>
    <a href="pemesanan.php" class="active">Daftar Pemesanan</a>
    <a href="form_input.php">Input Pemesanan</a>
    <a href="pengeluaran.php">Daftar Pengeluaran</a>
  </div>
  <div class="content">
    <div class="container">
      <h1>Edit Data Pemesanan</h1>
      <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <label>Nama Pelanggan</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_pelanggan']) ?>" required>

        <label>Nomor Telepon</label>
        <input type="text" name="telepon" value="<?= htmlspecialchars($data['telepon']) ?>" required>

        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?= htmlspecialchars($data['tanggal']) ?>" required>

        <label>Berat (kg)</label>
        <input type="number" id="berat" name="berat" step="0.1" value="<?= htmlspecialchars($data['berat']) ?>" required oninput="hitungTotal()">

        <label>Paket</label>
        <select id="paket" name="paket" required onchange="hitungTotal()">
          <option value="">-- Pilih Paket --</option>
          <?php
          $pakets = mysqli_query($conn, "SELECT id_paket, nama_paket FROM paket");
          while ($pkt = mysqli_fetch_assoc($pakets)) {
            $sel = ($pkt['id_paket'] == $data['id_paket']) ? 'selected' : '';
            echo "<option value='{$pkt['id_paket']}' $sel>{$pkt['nama_paket']}</option>";
          }
          ?>
        </select>

        <label>Jenis Layanan</label>
        <select id="jenis" name="jenis" required onchange="hitungTotal()">
          <option value="">-- Pilih Jenis --</option>
          <?php
          $jeniss = mysqli_query($conn, "SELECT id_jenis, nama_jenis FROM jenis_layanan");
          while ($jns = mysqli_fetch_assoc($jeniss)) {
            $sel = ($jns['id_jenis'] == $data['id_jenis']) ? 'selected' : '';
            echo "<option value='{$jns['id_jenis']}' $sel>{$jns['nama_jenis']}</option>";
          }
          ?>
        </select>

        <label>Total Bayar</label>
        <input type="text" id="totalBayar" name="bayar" placeholder="Total Bayar" readonly />

        <label>Nominal Pembayaran</label>
        <input type="number" id="bayar" name="nominal_dibayar" placeholder="Nominal Pembayaran" value="<?= $data['nominal_dibayar'] ?>" required oninput="hitungKembalian()">

        <label>Kembalian</label>
        <input type="text" id="kembalian" value="0" readonly>

        <label>Metode Pembayaran</label>
        <select name="metode_bayar" required>
          <option value="">-- Metode Pembayaran --</option>
          <option value="langsung" <?= ($data['metode_bayar'] == 'langsung') ? 'selected' : '' ?>>Bayar Sekarang</option>
          <option value="nanti" <?= ($data['metode_bayar'] == 'nanti') ? 'selected' : '' ?>>Bayar Saat Pengambilan</option>
        </select>

        <div class="form-actions">
          <a href="pemesanan.php" class="btn btn-cancel">Batal</a>
          <button type="submit" class="btn btn-update">Update</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    async function fetchHarga(paketId, jenisId) {
      if (!paketId || !jenisId) return 0;
      try {
        const res = await fetch(`get_harga.php?id_paket=${paketId}&id_jenis=${jenisId}`);
        const data = await res.json();
        return parseFloat(data.harga || 0);
      } catch (e) {
        console.error("Gagal mengambil harga:", e);
        return 0;
      }
    }

    async function hitungTotal() {
      const berat = parseFloat(document.getElementById('berat').value) || 0;
      const paket = document.getElementById('paket').value;
      const jenis = document.getElementById('jenis').value;

      const harga = await fetchHarga(paket, jenis);
      const total = berat * harga;

      document.getElementById('totalBayar').value = isNaN(total) ? '' : total.toFixed(0);
      hitungKembalian();
    }

    function hitungKembalian() {
      const bayar = parseFloat(document.getElementById('bayar').value) || 0;
      const total = parseFloat(document.getElementById('totalBayar').value) || 0;
      document.getElementById('kembalian').value = bayar > total ? bayar - total : 0;
    }

    window.addEventListener("DOMContentLoaded", () => {
      hitungTotal();
    });
  </script>
</body>

</html>