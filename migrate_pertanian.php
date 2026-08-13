<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();

    // Buat tabel pertanian
    $sql_create = "CREATE TABLE IF NOT EXISTS pertanian (
        id INT AUTO_INCREMENT PRIMARY KEY,
        image VARCHAR(255) NULL,
        description TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $db->exec($sql_create);
    echo "Tabel pertanian berhasil dibuat.\n";

    // Hapus kategori pertanian dari umkm_categories
    $sql_delete = "DELETE FROM umkm_categories WHERE name LIKE '%Pertanian%'";
    $db->exec($sql_delete);
    echo "Kategori pertanian berhasil dihapus dari umkm_categories.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
