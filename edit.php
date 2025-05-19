<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = "SELECT * FROM pembelian WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
  die("Data tidak ditemukan.");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Pemesanan</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f6fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #003f6b;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }

    .btn {
      background-color: #81d4fa;
      color: #003f6b;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      margin-right: 10px;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #4fc3f7;
    }

    .form-actions {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Edit Data Pemesanan</h1>
    <form action="update.php" method="post">
      <input type="hidden" name="id" value="<?= $data['id'] ?>">

      <label for="nama">Nama Pelanggan</label>
      <input type="text" name="nama" id="nama" value="<?= $data['nama_pelanggan'] ?>" required>

      <label for="telepon">Telepon</label>
      <input type="text" name="telepon" id="telepon" value="<?= $data['telepon'] ?>" required>

      <label for="tanggal">Tanggal</label>
      <input type="date" name="tanggal" id="tanggal" value="<?= $data['tanggal'] ?>" required>

      <label for="berat">Berat (kg)</label>
      <input type="number" name="berat" id="berat" step="0.1" value="<?= $data['berat'] ?>" required>

      <label for="paket">Paket</label>
      <select name="paket" id="paket" required>
        <option value="">-- Pilih Paket --</option>
        <?php
        $paketQ = mysqli_query($conn, "SELECT * FROM paket");
        while ($paket = mysqli_fetch_assoc($paketQ)) {
          $selected = ($paket['id_paket'] == $data['id_paket']) ? "selected" : "";
          echo "<option value='{$paket['id_paket']}' $selected>{$paket['nama_paket']}</option>";
        }
        ?>
      </select>

      <label for="jenis">Jenis Layanan</label>
      <select name="jenis" id="jenis" required>
        <option value="">-- Pilih Jenis --</option>
        <?php
        $jenisQ = mysqli_query($conn, "SELECT * FROM jenis_layanan");
        while ($jenis = mysqli_fetch_assoc($jenisQ)) {
          $selected = ($jenis['id_jenis'] == $data['id_jenis']) ? "selected" : "";
          echo "<option value='{$jenis['id_jenis']}' $selected>{$jenis['nama_jenis']}</option>";
        }
        ?>
      </select>

      <label for="bayar">Total Bayar (Rp)</label>
      <input type="number" name="bayar" id="bayar" value="<?= $data['bayar'] ?>" required>

      <div class="form-actions">
        <input type="submit" value="Update" class="btn">
        <a href="pemesanan.php" class="btn">Batal</a>
      </div>
    </form>
  </div>
</body>

</html>