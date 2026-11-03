<?php
include 'koneksi.php';

// Menampilkan data tabel kartu_stok yang diisi otomatis oleh Trigger
$query = "SELECT * FROM kartu_stok ORDER BY idkartu_stok DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Audit Log Stok - Trigger</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fff0f5; padding: 20px; }
        .container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #db7093; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ffb6c1; }
        th { background-color: #db7093; color: white; }
        tr:hover { background-color: #ffe4e1; }
        .badge { background: #e6e6fa; color: #4b0082; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Audit Log Kartu Stok (Otomatis dari Trigger)</h2>
        <p>Tabel ini mencatat mutasi stok secara otomatis via Trigger SQL <code>trg_penerimaan_kartu_stok</code> saat terjadi penerimaan barang.</p>
        <table>
            <thead>
                <tr>
                    <th>ID Kartu Stok</th>
                    <th>Jenis Transaksi</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                    <th>Waktu Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['idkartu_stok'] ?></td>
                    <td><span class="badge"><?= $row['jenis_transaksi'] ?></span></td>
                    <td style="color: green;">+<?= $row['masuk'] ?></td>
                    <td style="color: red;"><?= $row['keluar'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="dashboard.php" style="color: #db7093; text-decoration: none;">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html>