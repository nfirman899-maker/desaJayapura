<?php
// detail_umkm.php
require_once 'config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header('Location: umkm.php');
    exit;
}

$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT u.*, c.name as category_name FROM umkm u 
                      LEFT JOIN umkm_categories c ON u.category_id = c.id 
                      WHERE u.id = :id AND u.is_active = 1");
$stmt->execute([':id' => $id]);
$umkm = $stmt->fetch();

if (!$umkm) {
    header('Location: umkm.php');
    exit;
}

// Cek favorite
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $fav_stmt = $db->prepare("SELECT id FROM favorites WHERE user_id = :user_id AND umkm_id = :umkm_id");
    $fav_stmt->execute([':user_id' => $_SESSION['user_id'], ':umkm_id' => $id]);
    $is_favorite = $fav_stmt->rowCount() > 0;
}

require_once 'views/detail_umkm_view.php';
