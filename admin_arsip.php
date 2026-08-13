<?php
// admin_arsip.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handle POST request for adding new archive
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $link_gdrive = trim($_POST['link_gdrive'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    $tanggal_arsip = trim($_POST['tanggal_arsip'] ?? '');

    if (empty($judul) || empty($link_gdrive) || empty($tanggal_arsip)) {
        $error = 'Judul, Tanggal, dan Link Google Drive wajib diisi.';
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO arsip (judul, link_gdrive, keterangan, tanggal_arsip) VALUES (?, ?, ?, ?)");
            $stmt->execute([$judul, $link_gdrive, $keterangan, $tanggal_arsip]);
            $success = 'Arsip berhasil ditambahkan.';
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan arsip: ' . $e->getMessage();
        }
    }
}

// Handle Delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $db->prepare("DELETE FROM arsip WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Arsip berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus arsip.";
    }
}

// Handle filtering
$filter_tanggal = $_GET['tanggal_arsip'] ?? '';
if (!empty($filter_tanggal)) {
    $stmt = $db->prepare("SELECT * FROM arsip WHERE tanggal_arsip = ? ORDER BY id DESC");
    $stmt->execute([$filter_tanggal]);
} else {
    $stmt = $db->query("SELECT * FROM arsip ORDER BY id DESC");
}
$riwayat_arsip = $stmt->fetchAll();

require_once 'views/admin_arsip_view.php';
