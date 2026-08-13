<?php
// admin_peraturan_edit.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_peraturan.php");
    exit;
}

// Handle POST request for updating
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
                UPDATE peraturan_desa SET 
                    tahun = ?, no_tgl_peraturan = ?, tentang = ?, uraian_singkat = ?, 
                    no_tgl_persetujuan = ?, no_tgl_dilaporkan = ?, keterangan = ?
                WHERE id = ?
            ");
            
            $stmt->execute([
                $tahun, $no_tgl_peraturan, $tentang, $uraian_singkat, 
                $no_tgl_persetujuan, $no_tgl_dilaporkan, $keterangan,
                $id
            ]);
            
            $_SESSION['flash_success'] = 'Data peraturan desa berhasil diperbarui.';
            header("Location: admin_peraturan.php?tahun=$tahun");
            exit;
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
        }
    }
}

// Fetch existing data
$stmt = $db->prepare("SELECT * FROM peraturan_desa WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    header("Location: admin_peraturan.php");
    exit;
}

require_once 'views/admin_peraturan_edit_view.php';
