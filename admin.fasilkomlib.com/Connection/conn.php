<?php

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "fasilkomlib");

        if (mysqli_connect_errno()) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    // Mencegah cloning
    private function __clone() {}

    // Mencegah unserializing (untuk PHP 8+)
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}

// Untuk dipakai langsung:
$db = Database::getInstance()->getConnection();