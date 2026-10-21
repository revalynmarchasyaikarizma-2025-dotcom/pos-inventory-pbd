<?php
include 'koneksi.php';

// SIMPAN
if (isset($_POST['simpan'])) {
    $persen = $_POST['persen'];
    $iduser = $_POST['iduser'];
    
    mysqli_query($koneksi, "INSERT INTO margin_penjualan (persen, status, iduser) VALUES ('$persen', 1, '$iduser')");
    header("Location: margin.php");
}

// UPDATE
if (isset($_POST['update'])) {
    $id     = $_POST['idmargin_penjualan'];
    $persen = $_POST['persen'];
    
    mysqli_query($koneksi, "UPDATE margin_penjualan SET persen='$persen' WHERE idmargin_penjualan='$id'");
    header("Location: margin.php");
}

// HAPUS
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM margin_penjualan WHERE idmargin_penjualan='$id'");
    header("Location: margin.php");
}

// EDIT
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM margin_penjualan WHERE idmargin_penjualan='$id'");
    $edit_data  = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Margin Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master Margin Penjualan</h2>

    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="margin.php">
                <input type="hidden" name="idmargin_penjualan" value="<?= $edit_data['idmargin_penjualan'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Persentase Margin (%)</label>
                    <input type="number" step="0.1" name="persen" class="form-control" value="<?= $edit_data['persen'] ?? '' ?>" required>
                </div>

                <?php if (!$edit_data): ?>
                <div class="mb-3">
                    <label>User Pembuat</label>
                    <select name="iduser" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        <?php
                        $users = mysqli_query($koneksi, "SELECT * FROM user");
                        while ($u = mysqli_fetch_assoc($users)) :
                        ?>
                            <option value="<?= $u['iduser']; ?>"><?= $u['username']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <?php endif; ?>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Margin</button>
                    <a href="margin.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah Margin</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Persen Margin</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM v_margin");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['persen']; ?>%</td>
                <td><?= $row['status'] == 1 ? 'Aktif' : 'Non-Aktif'; ?></td>
                <td>
                    <a href="margin.php?action=edit&id=<?= $row['idmargin_penjualan']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="margin.php?action=hapus&id=<?= $row['idmargin_penjualan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>