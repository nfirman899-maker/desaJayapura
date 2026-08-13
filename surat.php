<?php
require_once 'config/database.php';

session_start();
// Harap login terlebih dahulu
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Proses pengajuan surat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = trim($_POST['nik'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $jenis_surat = $_POST['jenis_surat'] ?? '';
    $keterangan = $_POST['keterangan'] ?? '';
    $tanggal_pengajuan = trim($_POST['tanggal_pengajuan'] ?? '');

    if (empty($jenis_surat) || empty($keterangan) || empty($tanggal_pengajuan) || empty($nik) || empty($alamat)) {
        $error = 'Semua bidang wajib diisi (NIK, Alamat, Jenis Surat, Keterangan, Tanggal)!';
    } else {
        // Tangani upload lampiran (KTP/KK)
        $lampiran_path = null;
        if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            $file_extension = pathinfo($_FILES['lampiran']['name'], PATHINFO_EXTENSION);
            $file_name = 'lampiran_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
            $target_file = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $target_file)) {
                $lampiran_path = $target_file;
            }
        }

        try {
            $stmt = $db->prepare("INSERT INTO surat (user_id, nik, lampiran, jenis_surat, keterangan, alamat, tanggal_pengajuan) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $nik, $lampiran_path, $jenis_surat, $keterangan, $alamat, $tanggal_pengajuan]);
            
            // Tambahkan notifikasi untuk admin (optional jika notifikasi berupa badge unread di database sudah cukup)
            
            $success = 'Permohonan surat berhasil dikirim! Silakan tunggu proses dari admin desa.';
        } catch (PDOException $e) {
            $error = 'Gagal mengirim permohonan. Coba lagi. ' . $e->getMessage();
        }
    }
}

// Ambil riwayat surat milik user ini
$stmt = $db->prepare("SELECT * FROM surat WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
$riwayat_surat = $stmt->fetchAll();

// Ambil data user untuk auto-fill form
$user_stmt = $db->prepare("SELECT full_name, username, phone FROM users WHERE id = ?");
$user_stmt->execute([$_SESSION['user_id']]);
$current_user = $user_stmt->fetch();

require_once 'views/surat_view.php';
