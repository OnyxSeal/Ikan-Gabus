<?php

if (!class_exists('Database')) {
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

        private function __clone() {}

        public function __wakeup() {
            throw new \Exception("Cannot unserialize a singleton.");
        }
    }

    // Buat koneksi hanya sekali
    $db = Database::getInstance()->getConnection();
}