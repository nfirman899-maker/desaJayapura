<?php
// toggle_favorite.php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit;
}

$umkm_id = (int)($_POST['umkm_id'] ?? 0);

if (!$umkm_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit;
}

try {
    $db = (new Database())->getConnection();
    $user_id = $_SESSION['user_id'];
    
    // Cek apakah sudah difavorit
    $check = $db->prepare("SELECT id FROM favorites WHERE user_id = :user_id AND umkm_id = :umkm_id");
    $check->execute([':user_id' => $user_id, ':umkm_id' => $umkm_id]);
    
    if ($check->rowCount() > 0) {
        // Hapus
        $delete = $db->prepare("DELETE FROM favorites WHERE user_id = :user_id AND umkm_id = :umkm_id");
        $delete->execute([':user_id' => $user_id, ':umkm_id' => $umkm_id]);
        echo json_encode(['success' => true, 'is_favorite' => false]);
    } else {
        // Tambah
        $insert = $db->prepare("INSERT INTO favorites (user_id, umkm_id) VALUES (:user_id, :umkm_id)");
        $insert->execute([':user_id' => $user_id, ':umkm_id' => $umkm_id]);
        echo json_encode(['success' => true, 'is_favorite' => true]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
