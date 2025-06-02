<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan ke halaman login setelah logout
header("Location: index.php");
exit();
?>