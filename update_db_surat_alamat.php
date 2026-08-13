<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    // Tambahkan kolom alamat ke tabel surat
    $query = "ALTER TABLE surat ADD COLUMN alamat TEXT AFTER keterangan";
    
    $db->exec($query);
    echo "Kolom alamat berhasil ditambahkan ke tabel surat.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
