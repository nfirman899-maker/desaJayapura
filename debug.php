<?php
require_once 'config/database.php';
$db = (new Database())->getConnection();

echo "Surat Table:\n";
$stmt = $db->query("SELECT * FROM surat");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n\nUsers Table:\n";
$stmt = $db->query("SELECT id, full_name, username FROM users");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n\nAdmin Surat Query:\n";
$stmt = $db->query("
    SELECT surat.*, users.full_name, users.username, users.phone 
    FROM surat 
    JOIN users ON surat.user_id = users.id 
    ORDER BY surat.id DESC
");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
