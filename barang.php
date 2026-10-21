<?php
include 'koneksi.php';

// SIMPAN
if (isset($_POST['simpan'])) {
    $nama     = $_POST['nama'];
    $jenis    = $_POST['jenis'];
    $harga    = $_POST['harga'];
    $idsatuan = $_POST['idsatuan'];
    
    mysqli_query($koneksi, "INSERT INTO barang (jenis, nama, idsatuan, status, harga) VALUES ('$jenis', '$nama', '$idsatuan', 1, '$harga')");
    header("Location: barang.php");
}

// UPDATE
if (isset($_POST['update'])) {
    $id       = $_POST['idbarang'];
    $nama     = $_POST['nama'];
    $jenis    = $_POST['jenis'];
    $harga    = $_POST['harga'];
    $idsatuan = $_POST['idsatuan'];
    
    mysqli_query($koneksi, "UPDATE barang SET nama='$nama', jenis='$jenis', harga='$harga', idsatuan='$idsatuan' WHERE idbarang='$id'");
    header("Location: barang.php");
}

// HAPUS
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM barang WHERE idbarang='$id'");
    header("Location: barang.php");
}

// EDIT
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang='$id'");
    $edit_data  = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master Barang</h2>

    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="barang.php">
                <input type="hidden" name="idbarang" value="<?= $edit_data['idbarang'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" class="form-control" value="<?= $edit_data['nama'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Jenis</label>
                    <input type="text" name="jenis" class="form-control" value="<?= $edit_data['jenis'] ?? '' ?>" required maxlength="1">
                </div>

                <div class="mb-3">
                    <label>Harga Satuan</label>
                    <input type="number" name="harga" class="form-control" value="<?= $edit_data['harga'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Satuan</label>
                    <select name="idsatuan" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        <?php
                        $satuans = mysqli_query($koneksi, "SELECT * FROM satuan");
                        while ($s = mysqli_fetch_assoc($satuans)) :
                            $selected = ($edit_data && $edit_data['idsatuan'] == $s['idsatuan']) ? 'selected' : '';
                        ?>
                            <option value="<?= $s['idsatuan']; ?>" <?= $selected; ?>><?= $s['nama_satuan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Barang</button>
                    <a href="barang.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah Barang</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM v_barang");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?= $row['nama_satuan']; ?></td>
                <td>
                    <a href="barang.php?action=edit&id=<?= $row['idbarang']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="barang.php?action=hapus&id=<?= $row['idbarang']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>