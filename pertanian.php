<?php
require_once 'config/database.php';

session_start();
$db = (new Database())->getConnection();

// Ambil semua data pertanian
$stmt = $db->query("SELECT * FROM pertanian ORDER BY created_at DESC");
$pertanian_list = $stmt->fetchAll();

$is_logged_in = isset($_SESSION['user_id']);
$user_role = $_SESSION['role'] ?? 'warga';

require 'views/pertanian_view.php';
?>
