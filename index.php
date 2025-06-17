<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Home - Laundry AL</title>
  <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
  <link rel="stylesheet" href="CSS/style_i.css" />
</head>

<body class="home-bg">

  <div class="home-container">
    <img src="Foto/logo laundry.png" alt="Laundry AL" class="logo">

    <div class="home-buttons">
      <a href="pemesanan.php" class="btn">LAUNDRY</a>
    </div>

    <h2 class="judul-paket">Paket Layanan</h2>
    <div class="paket-container">
      <?php
      $queryPaket = "SELECT * FROM paket";
      $resultPaket = mysqli_query($conn, $queryPaket);

      while ($paket = mysqli_fetch_assoc($resultPaket)) {
        echo '<div class="card">';
        echo '  <h3 class="nama-paket">' . htmlspecialchars($paket['nama_paket']) . '</h3>';

        $id_paket = $paket['id_paket'];
        $queryLayanan = "SELECT jl.nama_jenis, hl.harga, hl.satuan 
                           FROM harga_layanan hl
                           JOIN jenis_layanan jl ON hl.id_jenis = jl.id_jenis
                           WHERE hl.id_paket = $id_paket";
        $resultLayanan = mysqli_query($conn, $queryLayanan);

        echo '<div class="layanan-list">';
        while ($layanan = mysqli_fetch_assoc($resultLayanan)) {
          echo '<div class="layanan-item">';
          echo '  <span class="jenis">' . htmlspecialchars($layanan['nama_jenis']) . '</span>';
          echo '  <span class="harga">Rp ' . number_format($layanan['harga'], 0, ',', '.') . ' /' . htmlspecialchars($layanan['satuan']) . '</span>';
          echo '</div>';
        }
        echo '</div>'; // .layanan-list

        echo '</div>'; // .card
      }
      ?>
    </div>
  </div>

</body>

</html>