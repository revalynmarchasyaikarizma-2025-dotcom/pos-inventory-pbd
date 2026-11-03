<?php
include 'koneksi.php';

// PROSES TAMBAH PENJUALAN MENGGUNAKAN STORED PROCEDURE
if (isset($_POST['simpan_penjualan'])) {
    $subtotal = $_POST['subtotal'];
    $iduser   = $_POST['iduser'];
    $idmargin = $_POST['idmargin'];

    // Memanggil Stored Procedure sp_tambah_penjualan
    $query = "CALL sp_tambah_penjualan($subtotal, $iduser, $idmargin)";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $id_baru = $row['idpenjualan_baru'];
        echo "<script>alert('Transaksi Penjualan Berhasil! ID Penjualan: $id_baru'); window.location='penjualan.php';</script>";
    } else {
        echo "<script>alert('Gagal memproses penjualan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan (SP)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 400px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <h2>Input Penjualan (Stored Procedure)</h2>
    
    <div class="card">
        <form action="" method="POST">
            <div class="form-group">
                <label>Subtotal Nilai (Rp):</label>
                <input type="number" name="subtotal" required placeholder="Contoh: 100000">
            </div>

            <div class="form-group">
                <label>Pilih Kasir (User):</label>
                <select name="iduser" required>
                    <?php
                    $users = mysqli_query($koneksi, "SELECT * FROM user WHERE idrole = 2");
                    while ($u = mysqli_fetch_assoc($users)) {
                        echo "<option value='".$u['iduser']."'>".$u['username']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Pilih Margin Penjualan:</label>
                <select name="idmargin" required>
                    <?php
                    $margins = mysqli_query($koneksi, "SELECT * FROM margin_penjualan WHERE status = 1");
                    while ($m = mysqli_fetch_assoc($margins)) {
                        echo "<option value='".$m['idmargin_penjualan']."'>Margin ".$m['persen']."%</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="simpan_penjualan">Proses Penjualan</button>
        </form>
    </div>

    <h2>Riwayat Penjualan (View: `view_penjualan`)</h2>
    <table>
        <tr>
            <th>ID Penjualan</th>
            <th>Waktu</th>
            <th>Kasir</th>
            <th>Margin (%)</th>
            <th>Subtotal</th>
            <th>PPN (11%)</th>
            <th>Total Nilai</th>
        </tr>
        <?php
        // Memanggil data dari View view_penjualan
        $data_penjualan = mysqli_query($koneksi, "SELECT * FROM view_penjualan");
        while ($row = mysqli_fetch_assoc($data_penjualan)) {
            echo "<tr>
                    <td>".$row['idpenjualan']."</td>
                    <td>".$row['created_at']."</td>
                    <td>".$row['kasir']."</td>
                    <td>".$row['margin_persen']."%</td>
                    <td>Rp ".number_format($row['subtotal_nilai'])."</td>
                    <td>Rp ".number_format($row['ppn'])."</td>
                    <td>Rp ".number_format($row['total_nilai'])."</td>
                  </tr>";
        }
        ?>
    </table>

</body>
</html>