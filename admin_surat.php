<?php
// admin_surat.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    
    if ($id && $status) {
        try {
            $stmt = $db->prepare("UPDATE surat SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $success = "Status surat berhasil diperbarui menjadi '$status'.";
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat memperbarui status surat.";
        }
    }
}

// Handle Delete (optional, but good for admin)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $db->prepare("DELETE FROM surat WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data pengajuan surat berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus data pengajuan surat.";
    }
}

// Fetch all surat with user info
$stmt = $db->query("
    SELECT surat.*, users.full_name, users.username, users.phone 
    FROM surat 
    JOIN users ON surat.user_id = users.id 
    ORDER BY surat.id DESC
");
$semua_surat = $stmt->fetchAll();

require_once 'views/admin_surat_view.php';
