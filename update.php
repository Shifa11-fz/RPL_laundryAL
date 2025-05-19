<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
$tanggal = $_POST['tanggal'];
$berat = floatval($_POST['berat']);
$id_paket = intval($_POST['paket']);
$id_jenis = intval($_POST['jenis']);
$bayar = floatval($_POST['bayar']);

$query = "UPDATE pembelian SET 
            nama_pelanggan = '$nama', 
            telepon = '$telepon', 
            tanggal = '$tanggal', 
            berat = $berat, 
            id_paket = $id_paket, 
            id_jenis = $id_jenis, 
            bayar = $bayar 
          WHERE id = $id";

if (mysqli_query($conn, $query)) {
  echo "<script>alert('Data berhasil diupdate'); window.location.href='pemesanan.php';</script>";
} else {
  echo "<script>alert('Gagal update: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>