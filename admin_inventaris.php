<?php
// admin_inventaris.php
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
        $stmt = $db->prepare("DELETE FROM inventaris_desa WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data inventaris berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus data inventaris.";
    }
}

// Handle POST request for adding new inventaris
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tahun = $_POST['tahun'] ?? date('Y');
    $jenis_barang = trim($_POST['jenis_barang'] ?? '');
    
    // Asal Barang
    $asal_sendiri = (int)($_POST['asal_sendiri'] ?? 0);
    $asal_pemerintah = (int)($_POST['asal_pemerintah'] ?? 0);
    $asal_bantuan_prov = (int)($_POST['asal_bantuan_prov'] ?? 0);
    $asal_bantuan_kab = (int)($_POST['asal_bantuan_kab'] ?? 0);
    $asal_sumbangan = (int)($_POST['asal_sumbangan'] ?? 0);
    
    // Keadaan Awal
    $awal_baik = (int)($_POST['awal_baik'] ?? 0);
    $awal_rusak = (int)($_POST['awal_rusak'] ?? 0);
    
    // Penghapusan
    $hapus_rusak = (int)($_POST['hapus_rusak'] ?? 0);
    $hapus_dijual = (int)($_POST['hapus_dijual'] ?? 0);
    $hapus_disumbangkan = (int)($_POST['hapus_disumbangkan'] ?? 0);
    $hapus_tanggal = !empty($_POST['hapus_tanggal']) ? $_POST['hapus_tanggal'] : null;
    
    // Keadaan Akhir
    $akhir_baik = (int)($_POST['akhir_baik'] ?? 0);
    $akhir_rusak = (int)($_POST['akhir_rusak'] ?? 0);
    
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($jenis_barang)) {
        $error = 'Jenis Barang/Bangunan wajib diisi.';
    } else {
        try {
            $stmt = $db->prepare("
                INSERT INTO inventaris_desa (
                    tahun, jenis_barang, 
                    asal_sendiri, asal_pemerintah, asal_bantuan_prov, asal_bantuan_kab, asal_sumbangan,
                    awal_baik, awal_rusak,
                    hapus_rusak, hapus_dijual, hapus_disumbangkan, hapus_tanggal,
                    akhir_baik, akhir_rusak, keterangan
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $tahun, $jenis_barang,
                $asal_sendiri, $asal_pemerintah, $asal_bantuan_prov, $asal_bantuan_kab, $asal_sumbangan,
                $awal_baik, $awal_rusak,
                $hapus_rusak, $hapus_dijual, $hapus_disumbangkan, $hapus_tanggal,
                $akhir_baik, $akhir_rusak, $keterangan
            ]);
            
            $success = 'Data inventaris berhasil ditambahkan.';
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
        }
    }
}

// Handle filtering
$filter_tahun = $_GET['tahun'] ?? date('Y');

// Ambil data inventaris
$stmt = $db->prepare("SELECT * FROM inventaris_desa WHERE tahun = ? ORDER BY id ASC");
$stmt->execute([$filter_tahun]);
$inventaris = $stmt->fetchAll();

// Ambil tahun-tahun yang tersedia untuk filter
$stmt_tahun = $db->query("SELECT DISTINCT tahun FROM inventaris_desa ORDER BY tahun DESC");
$list_tahun = $stmt_tahun->fetchAll(PDO::FETCH_COLUMN);
if (!in_array(date('Y'), $list_tahun)) {
    array_unshift($list_tahun, date('Y'));
}

require_once 'views/admin_inventaris_view.php';
