<?php
// admin_keputusan.php
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
        $stmt = $db->prepare("DELETE FROM keputusan_kades WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data keputusan kades berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus data keputusan.";
    }
}

// Handle POST request for adding new keputusan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = $_POST['tahun'] ?? date('Y');
    
    $no_tgl_keputusan = trim($_POST['no_tgl_keputusan'] ?? '');
    $tentang = trim($_POST['tentang'] ?? '');
    $uraian_singkat = trim($_POST['uraian_singkat'] ?? '');
    $no_tgl_dilaporkan = trim($_POST['no_tgl_dilaporkan'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($no_tgl_keputusan) || empty($tentang)) {
        $error = 'Kolom "No & Tgl Keputusan" dan "Tentang" wajib diisi.';
    } else {
        try {
            $stmt = $db->prepare("
                INSERT INTO keputusan_kades (
                    tahun, no_tgl_keputusan, tentang, uraian_singkat, no_tgl_dilaporkan, keterangan
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $tahun, $no_tgl_keputusan, $tentang, $uraian_singkat, $no_tgl_dilaporkan, $keterangan
            ]);
            
            $success = 'Data keputusan kades berhasil ditambahkan.';
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
        }
    }
}

// Handle filtering
$filter_tahun = $_GET['tahun'] ?? date('Y');

// Ambil data keputusan
$stmt = $db->prepare("SELECT * FROM keputusan_kades WHERE tahun = ? ORDER BY id ASC");
$stmt->execute([$filter_tahun]);
$keputusan_list = $stmt->fetchAll();

// Ambil tahun-tahun yang tersedia untuk filter
$stmt_tahun = $db->query("SELECT DISTINCT tahun FROM keputusan_kades ORDER BY tahun DESC");
$list_tahun = $stmt_tahun->fetchAll(PDO::FETCH_COLUMN);
if (!in_array(date('Y'), $list_tahun)) {
    array_unshift($list_tahun, date('Y'));
}

require_once 'views/admin_keputusan_view.php';
