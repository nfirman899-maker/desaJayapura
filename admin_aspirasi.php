<?php
// admin_aspirasi.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handle Balas & Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'tanggapi') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    $tanggapan = $_POST['tanggapan'] ?? '';
    
    if ($id && $status) {
        try {
            $stmt = $db->prepare("UPDATE aspirasi SET status = ?, tanggapan = ? WHERE id = ?");
            $stmt->execute([$status, $tanggapan, $id]);
            $success = "Tanggapan berhasil disimpan dan status diperbarui.";
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat memproses aspirasi.";
        }
    }
}

// Handle Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $db->prepare("DELETE FROM aspirasi WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data aspirasi berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus aspirasi.";
    }
}

// Fetch all aspirasi with user info
$stmt = $db->query("
    SELECT aspirasi.*, users.full_name, users.username, users.phone 
    FROM aspirasi 
    JOIN users ON aspirasi.user_id = users.id 
    ORDER BY aspirasi.id DESC
");
$semua_aspirasi = $stmt->fetchAll();

require_once 'views/admin_aspirasi_view.php';
