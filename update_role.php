<?php
include 'koneksi.php';

$idrole    = $_POST['idrole'];
$nama_role = $_POST['nama_role'];

// Eksekusi query update ke database
$query = mysqli_query($koneksi, "UPDATE role SET nama_role = '$nama_role' WHERE idrole = '$idrole'");

if ($query) {
    header("Location: role.php");
} else {
    echo "Gagal mengupdate data role: " . mysqli_error($koneksi);
}
?>