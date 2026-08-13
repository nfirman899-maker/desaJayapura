<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    $query = "CREATE TABLE IF NOT EXISTS arsip_surat (
        id INT PRIMARY KEY AUTO_INCREMENT,
        jenis_surat ENUM('masuk', 'keluar') NOT NULL,
        nomor_surat VARCHAR(100) NOT NULL,
        tanggal_surat DATE NOT NULL,
        asal_tujuan VARCHAR(255) NOT NULL,
        perihal VARCHAR(255) NOT NULL,
        file_surat VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($query);
    echo "Tabel arsip_surat berhasil dibuat.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
