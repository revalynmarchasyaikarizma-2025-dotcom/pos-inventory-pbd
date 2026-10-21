<?php
include 'koneksi.php';

$idrole = $_GET['id'];

// Eksekusi query delete ke database
$query = mysqli_query($koneksi, "DELETE FROM role WHERE idrole = '$idrole'");

if ($query) {
    header("Location: role.php");
} else {
    echo "Gagal menghapus data role: " . mysqli_error($koneksi);
}
?>