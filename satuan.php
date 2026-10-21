<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_satuan = $_POST['nama_satuan'];
    mysqli_query($koneksi, "INSERT INTO satuan (nama_satuan, status) VALUES ('$nama_satuan', 1)");
    header("Location: satuan.php");
}

if (isset($_POST['update'])) {
    $id          = $_POST['idsatuan'];
    $nama_satuan = $_POST['nama_satuan'];
    mysqli_query($koneksi, "UPDATE satuan SET nama_satuan='$nama_satuan' WHERE idsatuan='$id'");
    header("Location: satuan.php");
}

if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM satuan WHERE idsatuan='$id'");
    header("Location: satuan.php");
}

$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan='$id'");
    $edit_data  = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Satuan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master Satuan</h2>

    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="satuan.php">
                <input type="hidden" name="idsatuan" value="<?= $edit_data['idsatuan'] ?? '' ?>">
                <div class="mb-3">
                    <label>Nama Satuan</label>
                    <input type="text" name="nama_satuan" class="form-control" value="<?= $edit_data['nama_satuan'] ?? '' ?>" required>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Satuan</button>
                    <a href="satuan.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah Satuan</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM v_satuan");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_satuan']; ?></td>
                <td>
                    <a href="satuan.php?action=edit&id=<?= $row['idsatuan']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="satuan.php?action=hapus&id=<?= $row['idsatuan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>