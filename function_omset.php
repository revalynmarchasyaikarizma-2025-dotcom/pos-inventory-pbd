<?php
include 'koneksi.php';

// Memanggil Stored Function f_hitung_total_penjualan(iduser) menggunakan kolom username
$query = "SELECT iduser, username, f_hitung_total_penjualan(iduser) AS total_omset FROM user";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Omset Kasir - Function</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { display: flex; min-height: 100vh; background-color: #fcf4f7; }

        /* SIDEBAR PINK */
        .sidebar { width: 250px; background-color: #d81b60; color: #fff; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar h2 { text-align: center; font-size: 20px; margin-bottom: 25px; color: #fff; font-weight: bold; }
        .sidebar ul { list-style: none; }
        .sidebar ul li a { display: block; padding: 12px 20px; color: #f8bbd0; text-decoration: none; font-size: 14px; border-bottom: 1px solid #e91e63; transition: 0.3s; }
        .sidebar ul li a:hover { background-color: #c2185b; color: #fff; padding-left: 25px; }
        .sidebar .menu-header { padding: 12px 20px 5px; font-size: 11px; text-transform: uppercase; color: #f48fb1; font-weight: bold; }

        /* KONTEN UTAMA */
        .content { flex: 1; padding: 30px; }
        h1 { font-size: 26px; color: #880e4f; margin-bottom: 10px; }
        p { color: #ad1457; font-size: 14px; margin-bottom: 20px; }

        .card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(216, 27, 96, 0.08); border: 1px solid #f8bbd0; }

        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ffb6c1; }
        th { background-color: #d81b60; color: white; }
        tr:hover { background-color: #ffe4e1; }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGASI PINK -->
    <div class="sidebar">
        <h2>PBD PROJECT</h2>
        <ul>
            <li><a href="dashboard.php"> Dashboard</a></li>
            
            <div class="menu-header">Data Master</div>
            <li><a href="role.php"> Data Role</a></li>
            <li><a href="user.php"> Data User</a></li>
            <li><a href="satuan.php"> Data Satuan</a></li>
            <li><a href="vendor.php"> Data Vendor</a></li>
            <li><a href="barang.php"> Data Barang</a></li>
            <li><a href="margin.php"> Data Margin</a></li>

            <div class="menu-header">Transaksi & Logic</div>
            <li><a href="penjualan.php"> Input Penjualan (SP)</a></li>
            <li><a href="function_omset.php" style="background-color: #c2185b; color: #fff;"> Laporan Omset (Function)</a></li>
            <li><a href="trigger_stok.php"> Log Kartu Stok (Trigger)</a></li>
            
            <div class="menu-header">Laporan</div>
            <li><a href="views.php"> 15 View Laporan</a></li>
        </ul>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content">
        <h1>Laporan Total Omset Kasir</h1>
        <p>Data dihitung secara dinamis dari Stored Function SQL <code>f_hitung_total_penjualan()</code>.</p>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">ID User</th>
                        <th style="width: 45%;">Username Kasir</th>
                        <th style="width: 40%;">Total Omset Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['iduser'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><strong>Rp <?= number_format($row['total_omset'], 0, ',', '.') ?></strong></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>