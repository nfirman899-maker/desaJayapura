<?php
require_once 'config/database.php';

try {
    $db = (new Database())->getConnection();
    
    // Check if column exists first
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'is_approved'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        // Since we don't know if 'role' exists in the table, let's just append it
        $db->exec("ALTER TABLE users ADD COLUMN is_approved TINYINT(1) DEFAULT 0");
        echo "Column 'is_approved' added successfully.\n";
        
        // Auto approve existing users so admin doesn't have to
        $db->exec("UPDATE users SET is_approved = 1");
        echo "Existing users auto-approved.\n";
    } else {
        echo "Column 'is_approved' already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
