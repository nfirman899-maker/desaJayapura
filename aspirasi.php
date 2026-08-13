<?php
// aspirasi.php
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

// Hapus aspirasi
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    try {
        $stmt = $db->prepare("DELETE FROM aspirasi WHERE id = ? AND user_id = ?");
        $stmt->execute([$delete_id, $_SESSION['user_id']]);
        $success = 'Aspirasi berhasil dihapus.';
    } catch (PDOException $e) {
        $error = 'Gagal menghapus aspirasi.';
    }
}

// Data edit jika ada request edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM aspirasi WHERE id = ? AND user_id = ?");
    $stmt->execute([$edit_id, $_SESSION['user_id']]);
    $edit_data = $stmt->fetch();
}

// Proses pengajuan/update aspirasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $pesan = $_POST['pesan'] ?? '';
    $id = $_POST['id'] ?? '';
    $tanggal_kirim = trim($_POST['tanggal_kirim'] ?? '');

    if (empty($judul) || empty($kategori) || empty($pesan) || empty($tanggal_kirim)) {
        $error = 'Semua bidang wajib diisi!';
    } else {
        try {
            if (!empty($id)) {
                // Update aspirasi
                $stmt = $db->prepare("UPDATE aspirasi SET judul = ?, kategori = ?, pesan = ?, tanggal_kirim = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$judul, $kategori, $pesan, $tanggal_kirim, $id, $_SESSION['user_id']]);
                $success = 'Aspirasi Anda berhasil diperbarui!';
            } else {
                // Insert aspirasi baru
                $stmt = $db->prepare("INSERT INTO aspirasi (user_id, judul, kategori, pesan, tanggal_kirim) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $judul, $kategori, $pesan, $tanggal_kirim]);
                $success = 'Aspirasi Anda berhasil dikirim! Terima kasih atas masukan Anda.';
            }
        } catch (PDOException $e) {
            $error = 'Gagal memproses aspirasi. Coba lagi.';
        }
    }
}

// Ambil riwayat aspirasi milik user ini
$stmt = $db->prepare("SELECT * FROM aspirasi WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
$riwayat_aspirasi = $stmt->fetchAll();

require_once 'views/aspirasi_view.php';
