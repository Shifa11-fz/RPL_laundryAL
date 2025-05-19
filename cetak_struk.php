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
            pembelian.bayar
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
    <style>
        body {
            font-family: monospace;
        }

        .struk {
            width: 300px;
            margin: 20px auto;
            border: 1px solid #000;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        /* Tambahan agar hanya struk yang dicetak */
        @media print {
            @page {
                size: 80mm auto;
                /* lebar seperti struk kasir thermal */
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            .struk,
            .struk * {
                visibility: visible;
            }

            .struk {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                /* sama seperti ukuran kertas */
            }
        }
    </style>
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
        --------------------------<br>
        Total Bayar: Rp <?= number_format($row['bayar'], 0, ',', '.'); ?><br>
        <hr>
        <p class="center">Terima Kasih</p>
    </div>

    <!-- Elemen ini akan tampil di layar tapi tidak akan ikut tercetak -->
    <p><a href="pemesanan.php">Kembali ke Form Pemesanan</a></p>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>