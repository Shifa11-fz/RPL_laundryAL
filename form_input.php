<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Form Pemesanan - Laundry AL</title>
    <link rel="icon" href="foto/mesincuci.png" type="image/x-icon" />
    <link rel="stylesheet" href="CSS/style_fi.css">
    
    <script>
        async function hitungTotal() {
            const beratInput = document.getElementById("berat");
            const id_paket = document.getElementById("paket").value;
            const id_jenis = document.getElementById("jenis").value;
            const satuanText = document.getElementById("satuanText");

            if (id_paket && id_jenis) {
                try {
                    const response = await fetch(`get_harga.php?id_paket=${id_paket}&id_jenis=${id_jenis}`);
                    const data = await response.json();
                    const harga = parseFloat(data.harga) || 0;
                    const satuan = data.satuan;

                    let total = 0;

                    if (satuan === "Kg") {
                        const berat = parseFloat(beratInput.value) || 0;
                        total = harga * berat;
                        beratInput.readOnly = false;
                    } else {
                        total = harga;
                        beratInput.value = 1;
                        beratInput.readOnly = true;
                    }

                    satuanText.textContent = "Harga per: " + satuan;
                    document.getElementById("totalBayar").value = total;

                } catch (err) {
                    console.error("Gagal mengambil harga:", err);
                    satuanText.textContent = "";
                }
            } else {
                satuanText.textContent = "";
                document.getElementById("totalBayar").value = "";
            }
        }

        function hitungKembalian() {
            const bayar = parseFloat(document.getElementById("bayar").value) || 0;
            const total = parseFloat(document.getElementById("totalBayar").value) || 0;
            const kembalian = bayar - total;
            document.getElementById("kembalian").value = kembalian > 0 ? kembalian : 0;
        }
    </script>
</head>

<body>
    <div class="sidebar">
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="pemesanan.php" class="nav-link">Daftar Pemesanan</a>
        <a href="form_input.php" class="nav-link active">Input Pemesanan</a>
        <a href="pengeluaran.php" class="nav-link">Data Pengeluaran</a>
    </div>

    <div class="content">
      <div class="container">
        <h2>Form Pemesanan Laundry</h2>
        <form action="submit.php" method="post">
            <input type="text" name="nama" placeholder="Nama" required />
            <input type="text" name="telepon" placeholder="Nomor Telepon" required />
            <input type="date" name="tanggal" required />
            <input type="number" id="berat" name="berat" placeholder="Berat (kg)" step="0.1" required
                oninput="hitungTotal()" />

            <!-- Paket -->
            <select name="paket" id="paket" required onchange="hitungTotal()">
                <option value="">-- Pilih Paket --</option>
                <?php
                $q = mysqli_query($conn, "SELECT id_paket, nama_paket FROM paket");
                while ($data = mysqli_fetch_assoc($q)) {
                    echo "<option value=\"{$data['id_paket']}\">{$data['nama_paket']}</option>";
                }
                ?>
            </select>

            <!-- Jenis Layanan -->
            <select name="jenis_layanan" id="jenis" required onchange="hitungTotal()">
                <option value="">-- Pilih Jenis --</option>
                <?php
                $q = mysqli_query($conn, "SELECT id_jenis, nama_jenis FROM jenis_layanan");
                while ($data = mysqli_fetch_assoc($q)) {
                    echo "<option value=\"{$data['id_jenis']}\">{$data['nama_jenis']}</option>";
                }
                ?>
            </select>


            <p id="satuanText" style="margin-top: -10px; margin-bottom: 10px; color: #555;"></p>

            <input type="text" id="totalBayar" name="bayar" placeholder="Total Bayar" readonly />
            <input type="number" id="bayar" name="nominal_dibayar" placeholder="Nominal Pembayaran" required
                oninput="hitungKembalian()" />
            <input type="text" id="kembalian" placeholder="Kembalian" readonly />

            <select name="metode_bayar" required>
                <option value="">-- Metode Pembayaran --</option>
                <option value="langsung">Bayar Sekarang</option>
                <option value="nanti">Bayar Saat Pengambilan</option>
            </select>

            <input type="submit" value="Simpan" class="btn" />
        </form>
       </div>
    </div>
</body>

</html>