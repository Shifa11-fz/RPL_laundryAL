<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Home - Laundry AL</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .paket-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 40px;
      gap: 20px;
      margin-bottom: 40px;
    }

    .card {
      width: 300px;
  border: 1px solid #ddd;
  border-radius: 12px;
  padding: 15px;
  background-color: #FFF9F0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  
    .card h3 {
      margin-bottom: 10px;
      color: #081F5C;
    }

    .harga {
      font-size: 12px;
      font-weight: bold;
      color:rgb(160, 205, 12);
      margin-left: 15px;
    }

    .judul-paket {
      text-align: center;
      font-size: 24px;
      margin-top: 50px;
      color: #444;
    }

  .nama-paket {
  text-align: center;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 15px;
  color: #333;
}

.layanan-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
  font-size: 14px;
}

.layanan-item .jenis {
  text-align: left;
  flex: 1;
  color: #444;
}

.layanan-item .harga {
  text-align: right;
  white-space: nowrap;
  color: #28a745;
}

  </style>

</head>
<body class="home-bg">

  <div class="home-container">
    <img src="Foto/logo laundry.png" alt="Laundry AL" class="logo">

    <div class="home-buttons">
      <a href="pemesanan.php" class="btn">Pesan Sekarang</a>
    </div>


    <h2 class="judul-paket">Paket Layanan</h2>
<div class="paket-container">
  <?php
    $queryPaket = "SELECT * FROM paket";
    $resultPaket = mysqli_query($conn, $queryPaket);

    while ($paket = mysqli_fetch_assoc($resultPaket)) {






     echo '<div class="card">';
echo '<h3 class="nama-paket">' . htmlspecialchars($paket['nama_paket']) . '</h3>';

$id_paket = $paket['id_paket'];
$queryLayanan = "SELECT jl.nama_jenis, hl.harga, hl.satuan FROM harga_layanan hl
                 JOIN jenis_layanan jl ON hl.id_jenis = jl.id_jenis
                 WHERE hl.id_paket = $id_paket";
$resultLayanan = mysqli_query($conn, $queryLayanan);

while ($layanan = mysqli_fetch_assoc($resultLayanan)) {
  echo '<div class="layanan-item">';
  echo '<span class="jenis">' . htmlspecialchars($layanan['nama_jenis']) . '</span>';
  echo '<span class="harga">Rp ' . number_format($layanan['harga'], 0, ',', '.') . ' /' . $layanan['satuan'] . '</span>';
  echo '</div>';
}

echo '</div>';

    }
  ?>
</div>

  </div>

</body>
</html>