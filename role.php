<?php
include 'koneksi.php';

// 1. PROSES SIMPAN / TAMBAH DATA
if (isset($_POST['simpan'])) {
    $nama_role = $_POST['nama_role'];
    mysqli_query($koneksi, "INSERT INTO role (nama_role) VALUES ('$nama_role')");
    header("Location: role.php");
}

// 2. PROSES UPDATE / EDIT DATA
if (isset($_POST['update'])) {
    $id = $_POST['id_role'];
    $nama_role = $_POST['nama_role'];
    mysqli_query($koneksi, "UPDATE role SET nama_role='$nama_role' WHERE id_role='$id'");
    header("Location: role.php");
}

// 3. PROSES HAPUS DATA
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM role WHERE id_role='$id'");
    header("Location: role.php");
}

// CEK APAKAH LAGI MODE EDIT
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM role WHERE id_role='$id'");
    $edit_data = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Role</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master Role</h2>

    <!-- FORM TAMBAH / EDIT -->
    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="role.php">
                <input type="hidden" name="id_role" value="<?= $edit_data['id_role'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Nama Role</label>
                    <input type="text" name="nama_role" class="form-control" value="<?= $edit_data['nama_role'] ?? '' ?>" required>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update Role</button>
                    <a href="role.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah Role</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- TABEL MENAMPILKAN DATA -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM role");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_role']; ?></td>
                <td>
                    <a href="role.php?action=edit&id=<?= $row['id_role']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="role.php?action=hapus&id=<?= $row['id_role']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>