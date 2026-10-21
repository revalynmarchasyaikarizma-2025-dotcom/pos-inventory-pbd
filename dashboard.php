<?php
include 'koneksi.php';

// Menghitung ringkasan data master
$total_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$total_vendor = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM vendor"));
$total_user   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Informasi Penjualan & Pengadaan</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #2c3e50; }
        .sidebar a { color: #bdc3c7; text-decoration: none; display: block; padding: 12px 20px; }
        .sidebar a:hover, .sidebar a.active { background-color: #34495e; color: #fff; }
        .card-box { border-radius: 10px; color: #fff; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Menu Navigasi -->
        <nav class="col-md-2 d-none d-md-block sidebar p-0">
            <div class="p-3 text-white text-center fw-bold fs-5 border-bottom border-secondary">
                <i class="fa-solid fa-store me-2"></i>POS & Inventory
            </div>
            <div class="mt-3">
                <a href="dashboard.php" class="active"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                <div class="text-secondary ps-3 my-2 small text-uppercase fw-bold">Master Data</div>
                <a href="role.php"><i class="fa-solid fa-user-shield me-2"></i> Data Role</a>
                <a href="user.php"><i class="fa-solid fa-users me-2"></i> Data User</a>
                <a href="satuan.php"><i class="fa-solid fa-boxes-packing me-2"></i> Data Satuan</a>
                <a href="barang.php"><i class="fa-solid fa-box me-2"></i> Data Barang</a>
                <a href="vendor.php"><i class="fa-solid fa-truck-field me-2"></i> Data Vendor</a>
                <a href="margin.php"><i class="fa-solid fa-percent me-2"></i> Margin Penjualan</a>
                <div class="text-secondary ps-3 my-2 small text-uppercase fw-bold">Transaksi</div>
                <a href="pengadaan.php"><i class="fa-solid fa-cart-shopping me-2"></i> Pengadaan</a>
                <a href="penerimaan.php"><i class="fa-solid fa-boxes-stacked me-2"></i> Penerimaan</a>
                <a href="penjualan.php"><i class="fa-solid fa-cash-register me-2"></i> Penjualan</a>
                <a href="retur.php"><i class="fa-solid fa-rotate-left me-2"></i> Retur Barang</a>
                <a href="kartu_stok.php"><i class="fa-solid fa-clipboard-list me-2"></i> Kartu Stok</a>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="col-md-10 ms-sm-auto p-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-4 border-bottom">
                <h1 class="h2">Dashboard Utama</h1>
                <span class="badge bg-primary fs-6">Sistem Informasi Aktif</span>
            </div>

            <!-- Card Info / Stat Summary -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-box bg-primary p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Total Barang</h5>
                                <h2><?= $total_barang; ?></h2>
                            </div>
                            <i class="fa-solid fa-box fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-box bg-success p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Total Vendor</h5>
                                <h2><?= $total_vendor; ?></h2>
                            </div>
                            <i class="fa-solid fa-truck-field fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-box bg-warning text-dark p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5>Total User</h5>
                                <h2><?= $total_user; ?></h2>
                            </div>
                            <i class="fa-solid fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selamat Datang Box -->
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Selamat Datang di Proyek PBD!</h5>
                    <p class="card-text text-muted">Gunakan menu di sebelah kiri untuk mengelola master data (Role, User, Barang, Vendor, Margin) serta melakukan transaksi Pengadaan, Penerimaan, Penjualan, dan Kartu Stok.</p>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>