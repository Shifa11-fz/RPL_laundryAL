<?php
include 'koneksi.php';

if (
  isset(
    $_POST['id'],
    $_POST['nama'],
    $_POST['telepon'],
    $_POST['tanggal'],
    $_POST['berat'],
    $_POST['paket'],
    $_POST['jenis'],
    $_POST['nominal_dibayar'],
    $_POST['metode_bayar']
  )
) {
  $id        = intval($_POST['id']);
  $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
  $telepon   = mysqli_real_escape_string($conn, $_POST['telepon']);
  $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
  $berat     = floatval($_POST['berat']);
  $id_paket  = intval($_POST['paket']);
  $id_jenis  = intval($_POST['jenis']);
  $nominal_dibayar = floatval($_POST['nominal_dibayar']);
  $metode = mysqli_real_escape_string($conn, $_POST['metode_bayar']);

  // Ambil harga dari database berdasarkan id_paket dan id_jenis
  $harga_query = "SELECT harga FROM harga_layanan WHERE id_paket = $id_paket AND id_jenis = $id_jenis LIMIT 1";
  $harga_result = mysqli_query($conn, $harga_query);

  if (!$harga_result || mysqli_num_rows($harga_result) == 0) {
    echo "<script>alert('Harga tidak ditemukan.'); window.history.back();</script>";
    exit;
  }

  $harga = floatval(mysqli_fetch_assoc($harga_result)['harga']);
  $bayar = $berat * $harga;

  // Update ke database
  $query = "UPDATE pembelian SET 
                nama_pelanggan = '$nama',
                telepon = '$telepon',
                tanggal = '$tanggal',
                berat = $berat,
                id_paket = $id_paket,
                id_jenis = $id_jenis,
                bayar = $bayar,
                nominal_dibayar = $nominal_dibayar,
                metode_bayar = '$metode'
              WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data berhasil diupdate'); window.location.href='pemesanan.php';</script>";
  } else {
    echo "<script>alert('Gagal update: " . mysqli_error($conn) . "'); window.history.back();</script>";
  }
} else {
  echo "<script>alert('Data tidak lengkap. Silakan isi semua field.'); window.history.back();</script>";
}
