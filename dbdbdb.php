<?php
$servername = "localhost"; // Lokasi server MySQL
$username = "root"; // Nama pengguna MySQL
$password = ""; // Kata sandi MySQL
$database = "elevent"; // Nama database MySQL

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil";
?>
