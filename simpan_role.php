<?php
include 'koneksi.php';

// Ambil inputan dari form
$nama_role = $_POST['nama_role'];

// Eksekusi query insert ke database
$query = mysqli_query($koneksi, "INSERT INTO role (nama_role) VALUES ('$nama_role')");

if ($query) {
    // Jika berhasil, alihkan kembali ke halaman role.php
    header("Location: role.php");
} else {
    echo "Gagal menyimpan data role: " . mysqli_error($koneksi);
}
?>