<?php
$servername = "localhost";
$username = "root"; // ganti dengan username DB Anda
$password = ""; // ganti dengan password DB Anda
$dbname = "crud_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>