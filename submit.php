<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "laundry_al";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil dan bersihkan data dari form
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
$tanggal = $_POST['tanggal'];
$berat = floatval($_POST['berat']);
$paket = strtolower(trim($_POST['paket']));
$jenis = strtolower(trim($_POST['jenis']));
$bayar = floatval($_POST['bayar']);

// Ambil id_paket dari nama_paket
$queryPaket = "SELECT id_paket FROM paket WHERE LOWER(nama_paket) = '$paket'";
$resultPaket = mysqli_query($conn, $queryPaket);
if (mysqli_num_rows($resultPaket) > 0) {
    $rowPaket = mysqli_fetch_assoc($resultPaket);
    $id_paket = $rowPaket['id_paket'];
} else {
    die("<script>alert('Paket tidak ditemukan.'); window.history.back();</script>");
}

// Ambil id_jenis dari nama_jenis
$queryJenis = "SELECT id_jenis FROM jenis_layanan WHERE LOWER(nama_jenis) = '$jenis'";
$resultJenis = mysqli_query($conn, $queryJenis);
if (mysqli_num_rows($resultJenis) > 0) {
    $rowJenis = mysqli_fetch_assoc($resultJenis);
    $id_jenis = $rowJenis['id_jenis'];
} else {
    die("<script>alert('Jenis layanan tidak ditemukan.'); window.history.back();</script>");
}

// Simpan ke tabel pembelian
$query = "INSERT INTO pembelian (nama_pelanggan, telepon, tanggal, berat, id_paket, id_jenis, bayar)
          VALUES ('$nama', '$telepon', '$tanggal', $berat, $id_paket, $id_jenis, $bayar)";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data berhasil disimpan!'); window.location.href='pemesanan.php';</script>";
} else {
    echo "<script>alert('Error saat menyimpan: " . mysqli_error($conn) . "'); window.history.back();</script>";
}

mysqli_close($conn);
?>