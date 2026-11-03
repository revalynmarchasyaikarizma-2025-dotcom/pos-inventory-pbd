<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan View Database</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
        h3 { color: #333; margin-top: 25px; }
    </style>
</head>
<body>

    <h1>Halaman Laporan View (db_uts_2)</h1>

    <!-- 1. View Master Barang -->
    <h3>1. View Master Barang (`view_master_barang`)</h3>
    <table>
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>Harga</th>
        </tr>
        <?php
        $res = mysqli_query($koneksi, "SELECT * FROM view_master_barang");
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>".$row['idbarang']."</td>
                    <td>".$row['nama_barang']."</td>
                    <td>".$row['jenis']."</td>
                    <td>".$row['nama_satuan']."</td>
                    <td>Rp ".number_format($row['harga'])."</td>
                  </tr>";
        }
        ?>
    </table>

    <!-- 2. View Kartu Stok -->
    <h3>2. View Kartu Stok (`view_kartu_stok`)</h3>
    <table>
        <tr>
            <th>ID Kartu Stok</th>
            <th>Waktu</th>
            <th>Nama Barang</th>
            <th>Jenis Transaksi</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok Akhir</th>
        </tr>
        <?php
        $res2 = mysqli_query($koneksi, "SELECT * FROM view_kartu_stok");
        while ($row = mysqli_fetch_assoc($res2)) {
            echo "<tr>
                    <td>".$row['idkartu_stok']."</td>
                    <td>".$row['created_at']."</td>
                    <td>".$row['nama_barang']."</td>
                    <td>".$row['jenis_transaksi']."</td>
                    <td>".$row['masuk']."</td>
                    <td>".$row['keluar']."</td>
                    <td>".$row['stok_akhir']."</td>
                  </tr>";
        }
        ?>
    </table>

</body>
</html>