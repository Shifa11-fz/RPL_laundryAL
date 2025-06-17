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

// Validasi input yang wajib diisi
if (
    !isset($_POST['nama'], $_POST['telepon'], $_POST['tanggal'], $_POST['berat'], $_POST['bayar'],
        $_POST['nominal_dibayar'], $_POST['metode_bayar'], $_POST['paket'], $_POST['jenis_layanan']) ||
    empty($_POST['paket']) || empty($_POST['jenis_layanan'])
) {
    echo "<script>alert('Mohon lengkapi semua data terutama Paket dan Jenis Layanan.'); window.history.back();</script>";
    exit;
}


// Ambil dan bersihkan data dari form
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
$tanggal = $_POST['tanggal'];
$berat = floatval($_POST['berat']);
$bayar = floatval($_POST['bayar']);
$nominal_dibayar = floatval($_POST['nominal_dibayar']);
$metode = mysqli_real_escape_string($conn, $_POST['metode_bayar']);

$id_paket = intval($_POST['paket']);
$id_jenis = intval($_POST['jenis_layanan']);

// Simpan ke tabel pembelian
$query = "INSERT INTO pembelian (nama_pelanggan, telepon, tanggal, berat, id_paket, id_jenis, bayar, nominal_dibayar, metode_bayar)
          VALUES ('$nama', '$telepon', '$tanggal', $berat, $id_paket, $id_jenis, $bayar, $nominal_dibayar, '$metode')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Data berhasil disimpan!'); window.location.href='pemesanan.php';</script>";
} else {
    echo "<script>alert('Error saat menyimpan: " . mysqli_error($conn) . "'); window.history.back();</script>";
}

mysqli_close($conn);
?>
