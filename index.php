<?php
include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM role");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Role - Proyek PBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Data Master Role</h2>
    <a href="tambah_role.php" class="btn btn-primary mb-3">+ Tambah Role</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Role</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($data = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $data['idrole']; ?></td>
                <td><?= $data['nama_role']; ?></td>
                <td>
                    <a href="edit_role.php?id=<?= $data['idrole']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_role.php?id=<?= $data['idrole']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
