<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    $query = "CREATE TABLE IF NOT EXISTS arsip (
        id INT PRIMARY KEY AUTO_INCREMENT,
        judul VARCHAR(255) NOT NULL,
        link_gdrive VARCHAR(255) NOT NULL,
        keterangan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($query);
    echo "Tabel arsip berhasil dibuat.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
