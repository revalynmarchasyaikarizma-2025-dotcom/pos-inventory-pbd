<?php
include 'koneksi.php';

// 1. SIMPAN
if (isset($_POST['simpan'])) {
    $nama_vendor  = $_POST['nama_vendor'];
    $badan_hukum  = $_POST['badan_hukum'];
    
    mysqli_query($koneksi, "INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES ('$nama_vendor', '$badan_hukum', '1')");
    header("Location: vendor.php");
}

// 2. UPDATE
if (isset($_POST['update'])) {
    $id           = $_POST['idvendor'];
    $nama_vendor  = $_POST['nama_vendor'];
    $badan_hukum  = $_POST['badan_hukum'];
    
    mysqli_query($koneksi, "UPDATE vendor SET nama_vendor='$nama_vendor', badan_hukum='$badan_hukum' WHERE idvendor='$id'");
    header("Location: vendor.php");
}

// 3. HAPUS
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM vendor WHERE idvendor='$id'");
    header("Location: vendor.php");
}

// EDIT
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM vendor WHERE idvendor='$id'");
    $edit_data  = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Vendor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master Vendor</h2>

    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="vendor.php">
                <input type="hidden" name="idvendor" value="<?= $edit_data['idvendor'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Nama Vendor</label>
                    <input type="text" name="nama_vendor" class="form-control" value="<?= $edit_data['nama_vendor'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Badan Hukum</label>
                    <select name="badan_hukum" class="form-control" required>
                        <option value="Y" <?= ($edit_data && $edit_data['badan_hukum'] == 'Y') ? 'selected' : '' ?>>Ya (PT/CV)</option>
                        <option value="N" <?= ($edit_data && $edit_data['badan_hukum'] == 'N') ? 'selected' : '' ?>>Tidak (Perorangan/Toko)</option>
                    </select>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Vendor</button>
                    <a href="vendor.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah Vendor</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Vendor</th>
                <th>Badan Hukum</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM v_vendor");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_vendor']; ?></td>
                <td><?= $row['badan_hukum'] == 'Y' ? 'Ya' : 'Tidak'; ?></td>
                <td>
                    <a href="vendor.php?action=edit&id=<?= $row['idvendor']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="vendor.php?action=hapus&id=<?= $row['idvendor']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>