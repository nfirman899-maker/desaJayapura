<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    $query = "CREATE TABLE IF NOT EXISTS inventaris_desa (
        id INT PRIMARY KEY AUTO_INCREMENT,
        tahun INT NOT NULL,
        jenis_barang VARCHAR(255) NOT NULL,
        
        -- Asal Barang
        asal_sendiri INT DEFAULT 0,
        asal_pemerintah INT DEFAULT 0,
        asal_bantuan_prov INT DEFAULT 0,
        asal_bantuan_kab INT DEFAULT 0,
        asal_sumbangan INT DEFAULT 0,
        
        -- Keadaan Awal Tahun
        awal_baik INT DEFAULT 0,
        awal_rusak INT DEFAULT 0,
        
        -- Penghapusan
        hapus_rusak INT DEFAULT 0,
        hapus_dijual INT DEFAULT 0,
        hapus_disumbangkan INT DEFAULT 0,
        hapus_tanggal DATE NULL,
        
        -- Keadaan Akhir Tahun
        akhir_baik INT DEFAULT 0,
        akhir_rusak INT DEFAULT 0,
        
        keterangan TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($query);
    echo "Tabel inventaris_desa berhasil dibuat.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
