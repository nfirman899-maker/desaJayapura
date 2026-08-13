<?php
// lupa_password.php
require_once 'config/database.php';

session_start();
// Jika sudah login, alihkan ke dashboard (index)
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$error = '';
$success = '';
$verified_username = '';

$db = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fase 1: Verifikasi Identitas
    if (isset($_POST['verify'])) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($username) || empty($email)) {
            $error = 'Username dan Email wajib diisi.';
        } else {
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND email = ?");
            $stmt->execute([$username, $email]);
            $user = $stmt->fetch();

            if ($user) {
                // Verifikasi sukses
                $verified_username = $username;
                $success = 'Data ditemukan! Silakan masukkan password baru Anda.';
            } else {
                $error = 'Username atau Email tidak ditemukan atau tidak cocok.';
            }
        }
    } 
    // Fase 2: Simpan Password Baru
    else if (isset($_POST['reset_password'])) {
        $username = $_POST['verified_username'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username) || empty($new_password) || empty($confirm_password)) {
            $error = 'Semua bidang wajib diisi.';
            $verified_username = $username; // Keep form open
        } else if ($new_password !== $confirm_password) {
            $error = 'Konfirmasi password tidak cocok.';
            $verified_username = $username; // Keep form open
        } else if (strlen($new_password) < 6) {
            $error = 'Password minimal harus 6 karakter.';
            $verified_username = $username; // Keep form open
        } else {
            // Hash password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            try {
                $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
                $stmt->execute([$hashed_password, $username]);
                
                // Berhasil reset, set pesan sukses di session dan redirect
                $_SESSION['reset_success'] = "Password berhasil diperbarui. Silakan login dengan password baru.";
                header("Location: login.php");
                exit;
            } catch (PDOException $e) {
                $error = 'Terjadi kesalahan saat memperbarui password.';
                $verified_username = $username;
            }
        }
    }
}

require_once 'views/lupa_password_view.php';
