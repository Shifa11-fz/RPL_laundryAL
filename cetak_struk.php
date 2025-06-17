<?php
include 'koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Pembelian tidak valid.");
}

$id = $_GET['id'];

$query = "SELECT 
            pembelian.id, 
            pembelian.nama_pelanggan, 
            pembelian.telepon, 
            pembelian.tanggal, 
            pembelian.berat, 
            paket.nama_paket, 
            jenis_layanan.nama_jenis, 
            pembelian.bayar,
            pembelian.metode_bayar
          FROM pembelian
          JOIN paket ON pembelian.id_paket = paket.id_paket
          JOIN jenis_layanan ON pembelian.id_jenis = jenis_layanan.id_jenis
          WHERE pembelian.id = $id";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Data pembelian tidak ditemukan.");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/style_cs.css">
</head>

<body>

    <div class="struk">
        <h3 class="center">Laundry AL</h3>
        <p class="center">Alamat: Mahkota Regency Block D1 No 1</p>
        <hr>
        No. Transaksi: <?= $row['id']; ?><br>
        Tanggal: <?= $row['tanggal']; ?><br>
        Nama Pelanggan: <?= $row['nama_pelanggan']; ?><br>
        Telepon: <?= $row['telepon']; ?><br>
        Berat: <?= $row['berat']; ?> kg<br>
        Paket: <?= $row['nama_paket']; ?><br>
        Jenis Layanan: <?= $row['nama_jenis']; ?><br>
        Metode bayar: <?= $row['metode_bayar']; ?><br>
        --------------------------<br>
        Total Bayar: Rp <?= number_format($row['bayar'], 0, ',', '.'); ?><br>
        <hr>
        <p class="center">Terima Kasih</p>
    </div>

    <p><a href="pemesanan.php">Kembali ke Form Pemesanan</a></p>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>