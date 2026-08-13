<?php
// admin_pengumuman.php
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
    try {
        $stmt = $db->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Pengumuman berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus pengumuman.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? 'Berita';
    $content = $_POST['content'] ?? '';
    $id = $_POST['id'] ?? '';
    
    if (empty($title) || empty($content)) {
        $error = "Judul dan isi pengumuman wajib diisi!";
    } else {
        try {
            if ($id) {
                // Update
                $stmt = $db->prepare("UPDATE announcements SET title = ?, category = ?, content = ? WHERE id = ?");
                $stmt->execute([$title, $category, $content, $id]);
                $success = "Pengumuman berhasil diperbarui.";
            } else {
                // Insert
                $stmt = $db->prepare("INSERT INTO announcements (title, category, content, created_by) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $category, $content, $_SESSION['user_id']]);
                $success = "Pengumuman berhasil ditambahkan.";
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat menyimpan pengumuman.";
        }
    }
}

// Fetch all announcements
$stmt = $db->query("SELECT * FROM announcements ORDER BY id DESC");
$announcements = $stmt->fetchAll();

$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_stmt = $db->prepare("SELECT * FROM announcements WHERE id = ?");
    $edit_stmt->execute([$_GET['edit']]);
    $edit_data = $edit_stmt->fetch();
}

require_once 'views/admin_pengumuman_view.php';
