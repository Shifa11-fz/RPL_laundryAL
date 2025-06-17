<?php
include 'koneksi.php';

// Ambil dan validasi input
$id_paket = isset($_GET['id_paket']) ? intval($_GET['id_paket']) : 0;
$id_jenis = isset($_GET['id_jenis']) ? intval($_GET['id_jenis']) : 0;

header('Content-Type: application/json');

if ($id_paket > 0 && $id_jenis > 0) {
    $query = "SELECT harga, satuan FROM harga_layanan WHERE id_paket = $id_paket AND id_jenis = $id_jenis LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'harga' => floatval($row['harga']),
            'satuan' => $row['satuan']
        ]);
        exit;
    }
}

// Jika tidak ditemukan atau input tidak valid
echo json_encode(['harga' => 0, 'satuan' => 'Kg']);
