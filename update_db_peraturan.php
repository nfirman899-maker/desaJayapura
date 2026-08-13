<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    $query = "CREATE TABLE IF NOT EXISTS peraturan_desa (
        id INT PRIMARY KEY AUTO_INCREMENT,
        tahun INT NOT NULL,
        no_tgl_peraturan TEXT,
        tentang TEXT,
        uraian_singkat TEXT,
        no_tgl_persetujuan TEXT,
        no_tgl_dilaporkan TEXT,
        keterangan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($query);
    echo "Tabel peraturan_desa berhasil dibuat.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
