<!DOCTYPE html>

<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Database Pembelian - Laundry AL</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f6fa;
      margin: 0;
      padding: 0;
    }

    .container {
      padding: 40px;
      max-width: 1000px;
      margin: auto;
    }

    .navbar {
      background-color: #07568f;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 10px 30px;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .nav-container {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .nav-links {
      display: flex;
      gap: 20px;
    }

    .nav-link {
      text-decoration: none;
      color: #fafbfc;
      font-weight: 500;
      padding: 10px;
      border-radius: 6px;
      transition: background-color 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      background-color: #81d4fa;
      color: #003f6b;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .btn {
      background-color: #81d4fa;
      color: #003f6b;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .btn:hover {
      background-color: #4fc3f7;
    }

    /* Tabel tetap seperti semula tapi dengan kolom lebih rapih */

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th,
    td {
      padding: 12px 10px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
      /* Rapihkan lebar kolom */
      max-width: 160px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    th {
      background-color: #81d4fa;
      color: #003f6b;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #e3f2fd;
    }

    /* Tombol aksi rapih satu baris dan ukuran sama */

    .btn-aksi {
      padding: 6px 12px;
      margin: 0 3px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.85rem;
      min-width: 60px;
      text-align: center;
      display: inline-block;
      transition: background-color 0.3s;
    }

    .btn-aksi:hover {
      background-color: #2980b9;
    }

    .btn-aksi.red {
      background-color: #e74c3c;
    }

    .btn-aksi.red:hover {
      background-color: #c0392b;
    }

    .btn-aksi.green {
      background-color: #27ae60;
    }

    .btn-aksi.green:hover {
      background-color: #1e8449;
    }

    td form {
      display: inline-block;
      margin: 0;
      padding: 0;
    }

    /* Modal sama seperti semula */

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      max-height: 90vh;
      overflow-y: auto;
    }

    .modal-content input,
    .modal-content select {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .close-btn {
      background-color: #f44336;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
  <script>
    function openModal() {
      document.getElementById('inputModal').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('inputModal').style.display = 'none';
    }
  </script>
</head>

<body>
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-links">
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="pemesanan.php" class="nav-link active">Form Pemesanan</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <h1>Data Pembelian Laundry AL</h1>
    <button class="btn" onclick="openModal()">Input Data</button>

    <table>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Tanggal</th>
        <th>Berat (kg)</th>
        <th>Paket</th>
        <th>Jenis</th>
        <th>Bayar</th>
        <th>Aksi</th>
      </tr>

      <?php
      include 'koneksi.php';
      $query = "SELECT 
              pembelian.id, 
              pembelian.nama_pelanggan, 
              pembelian.telepon, 
              pembelian.tanggal, 
              pembelian.berat, 
              paket.nama_paket, 
              jenis_layanan.nama_jenis, 
              pembelian.bayar 
            FROM pembelian
            JOIN paket ON pembelian.id_paket = paket.id_paket
            JOIN jenis_layanan ON pembelian.id_jenis = jenis_layanan.id_jenis
            ORDER BY pembelian.id DESC";

      $result = mysqli_query($conn, $query);
      $i = 1;

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>{$row['nama_pelanggan']}</td>";
        echo "<td>{$row['telepon']}</td>";
        echo "<td>{$row['tanggal']}</td>";
        echo "<td>{$row['berat']}</td>";
        echo "<td>{$row['nama_paket']}</td>";
        echo "<td>{$row['nama_jenis']}</td>";
        echo "<td>Rp " . number_format($row['bayar'], 0, ',', '.') . "</td>";
        echo "<td>
          <form action='edit.php' method='get'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <button class='btn-aksi'>Edit</button>
          </form>
          <form action='hapus.php' method='get' onsubmit='return confirm(\"Yakin ingin menghapus?\")'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <button class='btn-aksi red'>Hapus</button>
          </form>
          <form action='cetak_struk.php' method='get' target='_blank'>
            <input type='hidden' name='id' value='{$row['id']}'>
            <button class='btn-aksi green'>Struk</button>
          </form>
        </td>";
        echo "</tr>";
        $i++;
      }

      mysqli_close($conn);
      ?>
    </table>
  </div>

  <div class="modal" id="inputModal">
    <div class="modal-content">
      <h3>Input Pemesanan</h3>
      <form action="submit.php" method="post">
        <?php include 'koneksi.php'; ?>
        <input type="text" name="nama" placeholder="Nama" required />
        <input type="text" name="telepon" placeholder="Nomor Telepon" required />
        <input type="date" name="tanggal" required />
        <input type="number" name="berat" placeholder="Berat (kg)" step="0.1" required />

        <select name="paket" required>
          <option value="">-- Pilih Paket --</option>
          <?php
          $paketQ = mysqli_query($conn, "SELECT nama_paket FROM paket");
          while ($paket = mysqli_fetch_assoc($paketQ)) {
            echo "<option value=\"{$paket['nama_paket']}\">{$paket['nama_paket']}</option>";
          }
          ?>
        </select>

        <select name="jenis" required>
          <option value="">-- Pilih Jenis Layanan --</option>
          <?php
          $jenisQ = mysqli_query($conn, "SELECT nama_jenis FROM jenis_layanan");
          while ($jenis = mysqli_fetch_assoc($jenisQ)) {
            echo "<option value=\"{$jenis['nama_jenis']}\">{$jenis['nama_jenis']}</option>";
          }
          ?>
        </select>

        <input type="number" name="bayar" placeholder="Nominal Pembayaran" required />
        <input type="submit" value="Simpan" class="btn" />
        <button type="button" class="close-btn" onclick="closeModal()">Batal</button>
      </form>
    </div>
  </div>
</body>

</html>