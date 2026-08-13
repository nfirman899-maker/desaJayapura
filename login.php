<?php
// login.php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

require_once 'config/database.php';

$error = '';
$success = '';

if (isset($_SESSION['reset_success'])) {
    $success = $_SESSION['reset_success'];
    unset($_SESSION['reset_success']);
}

if (isset($_GET['msg']) && $_GET['msg'] === 'login_required') {
    $error = 'Anda harus login terlebih dahulu untuk mengakses menu tersebut.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi!';
    } else {
        try {
            $db = (new Database())->getConnection();
            
            $stmt = $db->prepare("SELECT id, username, password, full_name, role FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                
                if (password_verify($password, $user['password'])) {
                    if ($user['role'] === 'admin') {
                        $error = 'Gunakan halaman Login Admin untuk masuk.';
                    } else {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['full_name'] = $user['full_name'];
                        $_SESSION['role'] = $user['role'];
                        
                        header('Location: home.php');
                        exit;
                    }
                } else {
                    $error = 'Password salah!';
                }
            } else {
                $error = 'Username tidak ditemukan!';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem.';
        }
    }
}

require_once 'views/login_view.php';
