<?php
// admin.php
require_once 'config/database.php';

session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_role = $_SESSION['role'] ?? null;

// Cek role admin
if (!$is_logged_in || $user_role !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();

// Statistik
$total_users = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_umkm = $db->query("SELECT COUNT(*) FROM umkm WHERE is_active = 1")->fetchColumn();
$total_announcements = $db->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
$total_surat_menunggu = $db->query("SELECT COUNT(*) FROM surat WHERE status = 'Menunggu'")->fetchColumn();
$total_aspirasi_menunggu = $db->query("SELECT COUNT(*) FROM aspirasi WHERE status = 'Menunggu'")->fetchColumn();

require_once 'views/admin_view.php';
