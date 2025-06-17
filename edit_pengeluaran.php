<?php
include 'koneksi.php';

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location.href='pengeluaran.php';</script>";
    exit();
}

$id = (int)$_GET['id'];
$query = "SELECT * FROM pengeluaran WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location.href='pengeluaran.php';</script>";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keterangan = $_POST['keterangan'];
    $jumlah = (int)$_POST['jumlah'];
    $harga_satuan = (int)$_POST['harga_satuan'];
    $total = $jumlah * $harga_satuan;

    $update = "UPDATE pengeluaran 
               SET keterangan = '$keterangan', jumlah = $jumlah, harga_satuan = $harga_satuan, total = $total 
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='pengeluaran.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pengeluaran</title>
    <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/style_ep.css">
</head>

<body>

    <div class="form-container">
        <h2>Edit Pengeluaran</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input
                    type="text"
                    id="keterangan"
                    name="keterangan"
                    value="<?= htmlspecialchars($data['keterangan']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    value="<?= $data['jumlah'] ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="harga_satuan">Harga Satuan</label>
                <input
                    type="number"
                    id="harga_satuan"
                    name="harga_satuan"
                    value="<?= $data['harga_satuan'] ?>"
                    required>
            </div>

            <div class="form-buttons">
                <a href="pengeluaran.php" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-update">Update</button>
            </div>
        </form>
    </div>

</body>

</html>