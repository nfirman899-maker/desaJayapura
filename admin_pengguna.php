<?php
// admin_pengguna.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Prevent admin from deleting their own account
    if ($id != $_SESSION['user_id']) {
        try {
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Pengguna berhasil dihapus.";
        } catch (PDOException $e) {
            $error = "Gagal menghapus pengguna.";
        }
    } else {
        $error = "Anda tidak dapat menghapus akun Anda sendiri.";
    }
}

// Fetch all users
$stmt = $db->query("SELECT * FROM users ORDER BY created_at DESC");
$semua_pengguna = $stmt->fetchAll();

require_once 'views/admin_pengguna_view.php';
?>
