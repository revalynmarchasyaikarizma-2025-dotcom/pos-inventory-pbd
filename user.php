<?php
include 'koneksi.php';

// 1. PROSES SIMPAN / TAMBAH DATA
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idrole   = $_POST['idrole'];
    
    mysqli_query($koneksi, "INSERT INTO user (username, password, idrole) VALUES ('$username', '$password', '$idrole')");
    header("Location: user.php");
}

// 2. PROSES UPDATE / EDIT DATA
if (isset($_POST['update'])) {
    $id       = $_POST['iduser'];
    $username = $_POST['username'];
    $idrole   = $_POST['idrole'];
    
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password', idrole='$idrole' WHERE iduser='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE user SET username='$username', idrole='$idrole' WHERE iduser='$id'");
    }
    header("Location: user.php");
}

// 3. PROSES HAPUS DATA
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM user WHERE iduser='$id'");
    header("Location: user.php");
}

// CEK MODE EDIT
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = $_GET['id'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser='$id'");
    $edit_data  = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2>Data Master User</h2>

    <div class="card my-3">
        <div class="card-body">
            <form method="POST" action="user.php">
                <input type="hidden" name="iduser" value="<?= $edit_data['iduser'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $edit_data['username'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password <?= $edit_data ? '<small class="text-muted">(Kosongkan jika tidak diubah)</small>' : '' ?></label>
                    <input type="password" name="password" class="form-control" <?= $edit_data ? '' : 'required' ?>>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="idrole" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <?php
                        $roles = mysqli_query($koneksi, "SELECT * FROM role");
                        while ($r = mysqli_fetch_assoc($roles)) :
                            $selected = ($edit_data && $edit_data['idrole'] == $r['idrole']) ? 'selected' : '';
                        ?>
                            <option value="<?= $r['idrole']; ?>" <?= $selected; ?>><?= $r['nama_role']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <?php if ($edit_data): ?>
                    <button type="submit" name="update" class="btn btn-warning">Update User</button>
                    <a href="user.php" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn btn-primary">Tambah User</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM v_user");
            while ($row = mysqli_fetch_assoc($data)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['username']; ?></td>
                <td><?= $row['nama_role']; ?></td>
                <td>
                    <a href="user.php?action=edit&id=<?= $row['iduser']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="user.php?action=hapus&id=<?= $row['iduser']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>