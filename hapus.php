<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM pembelian WHERE id = $id";

if (mysqli_query($conn, $query)) {
  echo "<script>alert('Data berhasil dihapus'); window.location.href='pemesanan.php';</script>";
} else {
  echo "<script>alert('Gagal menghapus data'); window.history.back();</script>";
}
?>
