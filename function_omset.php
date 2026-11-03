<?php
include 'koneksi.php';

// Memanggil Stored Function f_hitung_total_penjualan(iduser)
$query = "SELECT iduser, nama, f_hitung_total_penjualan(iduser) AS total_omset FROM user";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Omset Kasir - Function</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fff0f5; padding: 20px; }
        .container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #db7093; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ffb6c1; }
        th { background-color: #db7093; color: white; }
        tr:hover { background-color: #ffe4e1; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Total Omset (Menggunakan Stored Function)</h2>
        <p>Data di bawah ini dihitung secara dinamis dari fungsi SQL <code>f_hitung_total_penjualan()</code>.</p>
        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama Kasir / User</th>
                    <th>Total Omset Penjualan</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['iduser'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><strong>Rp <?= number_format($row['total_omset'], 0, ',', '.') ?></strong></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <a href="dashboard.php" style="color: #db7093; text-decoration: none;">&larr; Kembali ke Dashboard</a>
    </div>
</body>
</html>