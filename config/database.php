<?php
// config/database.php

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct() {
        // Menggunakan environment variables jika ada (untuk Vercel), jika tidak gunakan default lokal
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->db_name = getenv('DB_NAME') ?: "desa_jayapura";
        $this->username = getenv('DB_USER') ?: "root";
        $this->password = getenv('DB_PASS') ?: "";
    }
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            die("Koneksi database gagal: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>
