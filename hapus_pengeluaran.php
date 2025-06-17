<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = "DELETE FROM pengeluaran WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan'); window.history.back();</script>";
}
