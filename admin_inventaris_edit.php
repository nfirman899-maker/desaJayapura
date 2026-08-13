<?php
// admin_inventaris_edit.php
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
    header("Location: admin_inventaris.php");
    exit;
}

// Handle POST request for updating
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
                UPDATE inventaris_desa SET 
                    tahun = ?, jenis_barang = ?, 
                    asal_sendiri = ?, asal_pemerintah = ?, asal_bantuan_prov = ?, asal_bantuan_kab = ?, asal_sumbangan = ?,
                    awal_baik = ?, awal_rusak = ?,
                    hapus_rusak = ?, hapus_dijual = ?, hapus_disumbangkan = ?, hapus_tanggal = ?,
                    akhir_baik = ?, akhir_rusak = ?, keterangan = ?
                WHERE id = ?
            ");
            
            $stmt->execute([
                $tahun, $jenis_barang,
                $asal_sendiri, $asal_pemerintah, $asal_bantuan_prov, $asal_bantuan_kab, $asal_sumbangan,
                $awal_baik, $awal_rusak,
                $hapus_rusak, $hapus_dijual, $hapus_disumbangkan, $hapus_tanggal,
                $akhir_baik, $akhir_rusak, $keterangan,
                $id
            ]);
            
            $_SESSION['flash_success'] = 'Data inventaris berhasil diperbarui.';
            header("Location: admin_inventaris.php?tahun=$tahun");
            exit;
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage();
        }
    }
}

// Fetch existing data
$stmt = $db->prepare("SELECT * FROM inventaris_desa WHERE id = ?");
$stmt->execute([$id]);
$inv = $stmt->fetch();

if (!$inv) {
    header("Location: admin_inventaris.php");
    exit;
}

require_once 'views/admin_inventaris_edit_view.php';
