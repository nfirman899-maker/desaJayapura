<?php
// admin_peraturan.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}

// Handle Delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $db->prepare("DELETE FROM peraturan_desa WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data peraturan desa berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus data peraturan.";
    }
}

// Handle POST request for adding new peraturan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = $_POST['tahun'] ?? date('Y');
    
    $no_tgl_peraturan = trim($_POST['no_tgl_peraturan'] ?? '');
    $tentang = trim($_POST['tentang'] ?? '');
    $uraian_singkat = trim($_POST['uraian_singkat'] ?? '');
    $no_tgl_persetujuan = trim($_POST['no_tgl_persetujuan'] ?? '');
    $no_tgl_dilaporkan = trim($_POST['no_tgl_dilaporkan'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($no_tgl_peraturan) || empty($tentang)) {
        $error = 'Kolom "No & Tgl Peraturan Desa" dan "Tentang" wajib diisi.';
    } else {
        try {
            $stmt = $db->prepare("
                INSERT INTO peraturan_desa (
                    tahun, no_tgl_peraturan, tentang, uraian_singkat, no_tgl_persetujuan, no_tgl_dilaporkan, keterangan
                ) VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $tahun, $no_tgl_peraturan, $tentang, $uraian_singkat, $no_tgl_persetujuan, $no_tgl_dilaporkan, $keterangan
            ]);
            
            $success = 'Data peraturan desa berhasil ditambahkan.';
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
        }
    }
}

// Handle filtering
$filter_tahun = $_GET['tahun'] ?? date('Y');

// Ambil data peraturan
$stmt = $db->prepare("SELECT * FROM peraturan_desa WHERE tahun = ? ORDER BY id ASC");
$stmt->execute([$filter_tahun]);
$peraturan_list = $stmt->fetchAll();

// Ambil tahun-tahun yang tersedia untuk filter
$stmt_tahun = $db->query("SELECT DISTINCT tahun FROM peraturan_desa ORDER BY tahun DESC");
$list_tahun = $stmt_tahun->fetchAll(PDO::FETCH_COLUMN);
if (!in_array(date('Y'), $list_tahun)) {
    array_unshift($list_tahun, date('Y'));
}

require_once 'views/admin_peraturan_view.php';
