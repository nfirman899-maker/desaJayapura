<?php
// edit_profil.php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Ambil data user saat ini
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($full_name)) {
        $error = 'Nama lengkap wajib diisi.';
    } else {
        $avatarName = $user['avatar']; // Default: pertahankan avatar lama

        // Proses upload avatar jika ada
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');

            if (in_array(strtolower($fileType), $allowTypes)) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
                    $avatarName = $fileName;
                } else {
                    $error = "Gagal mengupload foto profil.";
                }
            } else {
                $error = "Format foto tidak didukung (gunakan JPG, JPEG, PNG).";
            }
        }

        if (empty($error)) {
            try {
                $stmt = $db->prepare("UPDATE users SET full_name = ?, phone = ?, avatar = ? WHERE id = ?");
                $stmt->execute([$full_name, $phone, $avatarName, $_SESSION['user_id']]);
                
                // Perbarui session full_name
                $_SESSION['full_name'] = $full_name;
                
                // Ambil data terbaru untuk form
                $user['full_name'] = $full_name;
                $user['phone'] = $phone;
                $user['avatar'] = $avatarName;
                
                $success = "Profil berhasil diperbarui!";
            } catch (PDOException $e) {
                $error = 'Gagal memperbarui profil. Coba lagi.';
            }
        }
    }
}

require_once 'views/edit_profil_view.php';
