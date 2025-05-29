<?php
include_once "connection/conn.php";

// Ambil username yang dikirim dari permintaan AJAX
$username = $_GET['username'];

// Query untuk memeriksa apakah username telah digunakan
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($db, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    // Username telah digunakan
    echo "Username telah digunakan";
} else {
    // Username tersedia
    echo "Username tersedia";
}

// Tutup koneksi ke database
mysqli_close($db);
?>
