<?php
// admin_arsip_surat.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();

// Default tab
$tab = $_GET['tab'] ?? 'masuk';
if (!in_array($tab, ['masuk', 'keluar'])) {
    $tab = 'masuk';
}

// Handle filtering
$filter_tanggal = $_GET['tanggal_pengajuan'] ?? '';

// Query base
$queryStr = "
    SELECT surat.*, users.full_name, users.phone 
    FROM surat 
    JOIN users ON surat.user_id = users.id 
";

$queryParams = [];

if ($tab === 'masuk') {
    // Surat Masuk: Semua permohonan dari warga
    $queryStr .= " WHERE surat.status IN ('Menunggu', 'Diproses', 'Ditolak') ";
} else {
    // Surat Keluar: Permohonan yang sudah diselesaikan (dikeluarkan) oleh desa
    $queryStr .= " WHERE surat.status = 'Selesai' ";
}

if (!empty($filter_tanggal)) {
    // Compare DATE part only in case tanggal_pengajuan is datetime
    $queryStr .= " AND DATE(surat.tanggal_pengajuan) = ? ";
    $queryParams[] = $filter_tanggal;
}

$queryStr .= " ORDER BY surat.id DESC";

$stmt = $db->prepare($queryStr);
$stmt->execute($queryParams);
$riwayat_arsip = $stmt->fetchAll();

require_once 'views/admin_arsip_surat_view.php';
