<?php
// register.php
require_once 'config/database.php';

session_start();
// Since header.php was removed, we check session here
$is_logged_in = isset($_SESSION['user_id']);

if ($is_logged_in) {
    header('Location: home.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    if (empty($username) || empty($password) || empty($full_name)) {
        $error = 'Semua field wajib diisi!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        try {
            $db = (new Database())->getConnection();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("INSERT INTO users (username, password, full_name, email, phone) 
                                  VALUES (:username, :password, :full_name, :email, :phone)");
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashed,
                ':full_name' => $full_name,
                ':email' => $email,
                ':phone' => $phone
            ]);
            
            $success = 'Pendaftaran berhasil! Silakan login.';
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $error = 'Username atau email sudah terdaftar!';
            } else {
                $error = 'Terjadi kesalahan sistem.';
            }
        }
    }
}

require_once 'views/register_view.php';
