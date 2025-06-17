<?php
include 'koneksi.php';

// Inisialisasi variabel pencarian
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

// Proses input pengeluaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keterangan = $_POST['keterangan'];
    $jumlah = (int)$_POST['jumlah'];
    $harga_satuan = (int)$_POST['harga_satuan'];
    $tanggal = date('Y-m-d');

    $query = "INSERT INTO pengeluaran (tanggal, keterangan, jumlah, harga_satuan) 
              VALUES ('$tanggal', '$keterangan', $jumlah, $harga_satuan)";
    mysqli_query($conn, $query);
    header("Location: pengeluaran.php");
    exit();
}

// Query pengeluaran (dengan atau tanpa pencarian)
if (!empty($search)) {
    $query = "SELECT * FROM pengeluaran WHERE keterangan LIKE '%$search%' ORDER BY id DESC";
} else {
    $query = "SELECT * FROM pengeluaran ORDER BY id ASC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Data Pengeluaran - Laundry AL</title>
    <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/style_keluar.css">

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }

        function hitungTotal() {
            const jumlah = document.getElementById('jumlah').value;
            const harga = document.getElementById('harga_satuan').value;
            const total = jumlah * harga;
            document.getElementById('total').value = total;
        }
    </script>
</head>

<body>
    <div class="hamburger" onclick="toggleSidebar()">☰ Menu</div>

    <nav class="sidebar">
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="pemesanan.php" class="nav-link">Daftar Pemesanan</a>
        <a href="form_input.php" class="nav-link">Input Pemesanan</a>
        <a href="pengeluaran.php" class="nav-link active">Data Pengeluaran</a>
    </nav>

    <div class="main">
        <h1>Data Pengeluaran</h1>

        <form method="get" class="search-form">
            <input type="text" name="cari" placeholder="Cari nama barang..." value="<?= htmlspecialchars($search) ?>">
            <input type="submit" class="btn" value="Cari">
            <button type="button" class="btn" onclick="window.location.href='pengeluaran.php'">Reset</button>
        </form>

        <!-- Form Input Pengeluaran -->
        <div class="form-container">
            <form action="pengeluaran.php" method="post">
                <input type="text" name="keterangan" placeholder="Nama Barang" required />
                <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" required oninput="hitungTotal()" />
                <input type="number" id="harga_satuan" name="harga_satuan" placeholder="Harga Satuan (Rp)" required oninput="hitungTotal()" />
                <input type="number" id="total" name="total" placeholder="Total (Rp)" readonly required />
                <input type="submit" name="submit_pengeluaran" value="Simpan" class="btn" />
            </form>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>{$no}</td>
                <td>{$row['keterangan']}</td>
                <td>{$row['jumlah']}</td>
                <td>Rp " . number_format($row['harga_satuan'], 0, ',', '.') . "</td>
                <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
                <td>
                    <form action='edit_pengeluaran.php' method='get' style='display:inline-block'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn-aksi'>Edit</button>
                    </form>
                    <form action='hapus_pengeluaran.php' method='get' onsubmit='return confirm(\"Yakin ingin menghapus?\")' style='display:inline-block'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button class='btn-aksi red'>Hapus</button>
                    </form>
                </td>
            </tr>";
                $no++;
            }
            ?>
        </table>
    </div>
</body>

</html>