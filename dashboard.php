<?php
include 'koneksi.php';

// Mengambil jumlah total data dari database untuk statistik di dashboard
$total_role   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM role"));
$total_user   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
$total_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$total_vendor = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM vendor"));
$total_jual   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM penjualan"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pink - Sistem Informasi Penjualan (db_uts_2)</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { display: flex; min-height: 100vh; background-color: #fcf4f7; }
        
        /* SIDEBAR PINK TEMA */
        .sidebar { width: 250px; background-color: #d81b60; color: #fff; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar h2 { text-align: center; font-size: 20px; margin-bottom: 25px; color: #fff; font-weight: bold; letter-spacing: 1px; }
        .sidebar ul { list-style: none; }
        .sidebar ul li a { display: block; padding: 12px 20px; color: #f8bbd0; text-decoration: none; font-size: 14px; border-bottom: 1px solid #e91e63; transition: 0.3s; }
        .sidebar ul li a:hover { background-color: #c2185b; color: #fff; padding-left: 25px; }
        .sidebar .menu-header { padding: 12px 20px 5px; font-size: 11px; text-transform: uppercase; color: #f48fb1; font-weight: bold; }

        /* KONTEN UTAMA */
        .content { flex: 1; padding: 30px; }
        .header-title { margin-bottom: 25px; }
        .header-title h1 { font-size: 26px; color: #880e4f; }
        .header-title p { color: #ad1457; font-size: 14px; }

        /* KARTU STATISTIK PINK */
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(216, 27, 96, 0.08); border-left: 5px solid #ec407a; }
        .card h4 { font-size: 12px; color: #ad1457; text-transform: uppercase; margin-bottom: 10px; }
        .card .value { font-size: 24px; font-weight: bold; color: #880e4f; }

        /* PANEL DESKRIPSI */
        .panel { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(216, 27, 96, 0.08); border: 1px solid #f8bbd0; }
        .panel h3 { margin-bottom: 15px; color: #880e4f; font-size: 18px; }
        .panel p { font-size: 14px; color: #4a148c; line-height: 1.6; }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGASI TEMA PINK -->
    <div class="sidebar">
        <h2>PBD PROJECT</h2>
        <ul>
            <li><a href="dashboard.php" style="background-color: #c2185b; color: #fff;"> Dashboard</a></li>
            
            <div class="menu-header">Data Master</div>
            <li><a href="role.php"> Data Role</a></li>
            <li><a href="user.php"> Data User</a></li>
            <li><a href="satuan.php"> Data Satuan</a></li>
            <li><a href="vendor.php"> Data Vendor</a></li>
            <li><a href="barang.php"> Data Barang</a></li>
            <li><a href="margin.php"> Data Margin</a></li>

            <div class="menu-header">Transaksi & Logic</div>
            <li><a href="penjualan.php"> Input Penjualan (SP)</a></li>
            
            <div class="menu-header">Laporan</div>
            <li><a href="views.php"> 15 View Laporan</a></li>
        </ul>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content">
        <div class="header-title">
            <h1>Dashboard Utama</h1>
            <p>Sistem Pengelolaan Database <code>db_uts_2</code></p>
        </div>

        <!-- STATISTIK KARTU PINK -->
        <div class="card-grid">
            <div class="card" style="border-left-color: #ec407a;">
                <h4>Total User</h4>
                <div class="value"><?php echo $total_user; ?></div>
            </div>
            <div class="card" style="border-left-color: #f06292;">
                <h4>Total Barang</h4>
                <div class="value"><?php echo $total_barang; ?></div>
            </div>
            <div class="card" style="border-left-color: #ff80ab;">
                <h4>Total Vendor</h4>
                <div class="value"><?php echo $total_vendor; ?></div>
            </div>
            <div class="card" style="border-left-color: #ff4081;">
                <h4>Total Transaksi Penjualan</h4>
                <div class="value"><?php echo $total_jual; ?></div>
            </div>
        </div>

        <!-- INFORMASI SISTEM -->
        <div class="panel">
            <h3>Selamat Datang di Sistem Informasi Penjualan</h3>
            <p>Aplikasi antarmuka ini terhubung langsung dengan basis data MySQL <strong>db_uts_2</strong>. Gunakan menu di sebelah kiri untuk mengelola data master, menjalankan <em>Stored Procedure</em> transaksi penjualan, dan melihat 15 rekap tampilan data (<em>View</em>).</p>
        </div>
    </div>

</body>
</html>