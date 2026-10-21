<?php
include 'koneksi.php';

// Ambil data role dari database
$query = mysqli_query($koneksi, "SELECT * FROM role ORDER BY idrole ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Role - Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #2c3e50; }
        .sidebar a { color: #bdc3c7; text-decoration: none; display: block; padding: 12px 20px; }
        .sidebar a:hover, .sidebar a.active { background-color: #34495e; color: #fff; }
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
                <a href="dashboard.php"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                <div class="text-secondary ps-3 my-2 small text-uppercase fw-bold">Master Data</div>
                <a href="role.php" class="active"><i class="fa-solid fa-user-shield me-2"></i> Data Role</a>
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
                <h1 class="h2">Master Data Role</h1>
                <a href="tambah_role.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Role</a>
            </div>

            <!-- Tabel Data Role -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">ID Role</th>
                                <th>Nama Role</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_assoc($query)) { 
                            ?>
                            <tr>
                                <td><?= $data['idrole']; ?></td>
                                <td><?= $data['nama_role']; ?></td>
                                <td class="text-center">
                                    <a href="edit_role.php?id=<?= $data['idrole']; ?>" class="btn btn-warning btn-sm me-1"><i class="fa-solid fa-pen"></i> Edit</a>
                                    <a href="hapus_role.php?id=<?= $data['idrole']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='3' class='text-center text-muted'>Belum ada data role.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>