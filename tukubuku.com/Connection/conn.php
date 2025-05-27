<?php

class Database {
    private static $instance = null; // Menyimpan satu-satunya instance koneksi
    private $connection; // Menyimpan objek koneksi MySQLi

    // Konstruktor disembunyikan (private) agar tidak bisa diinstansiasi langsung dari luar
    private function __construct() {
        // Detail koneksi database
        $host = "localhost";
        $username = "root";
        $password = ""; // Kosong jika tidak ada password
        $database = "fasilkomlib";

        // Buat koneksi MySQLi
        $this->connection = new mysqli($host, $username, $password, $database);

        // Periksa koneksi
        if ($this->connection->connect_error) {
            die("Koneksi database gagal: " . $this->connection->connect_error);
        }
        // Opsional: Atur charset jika diperlukan, contoh:
        // $this->connection->set_charset("utf8mb4");
    }

    // Metode untuk mendapatkan satu-satunya instance koneksi
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database(); // Buat instance baru jika belum ada
        }
        return self::$instance;
    }

    // Metode untuk mendapatkan objek koneksi MySQLi yang sebenarnya
    public function getConnection() {
        return $this->connection;
    }

    // Metode disembunyikan (private) agar instance tidak bisa di-clone
    private function __clone() {}

    // Metode disembunyikan (private) agar instance tidak bisa di-unserialize
    private function __wakeup() {}
}

// Cara penggunaan:
// Untuk mendapatkan instance Database (dan koneksi):
$dbInstance = Database::getInstance();

// Untuk mendapatkan objek koneksi MySQLi yang sebenarnya untuk query:
$koneksi = $dbInstance->getConnection();

// Contoh penggunaan koneksi:
// $query = "SELECT * FROM users";
// $result = $koneksi->query($query);
// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         echo $row['username'] . "<br>";
//     }
// } else {
//     echo "Error: " . $koneksi->error;
// }

// Jangan lupa untuk menutup koneksi jika aplikasi selesai (opsional, PHP akan menutupnya secara otomatis di akhir skrip)
// $koneksi->close();

?>