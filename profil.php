<?php
// profil.php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

if (!$is_logged_in) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';
$db = (new Database())->getConnection();

// Ambil data user
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

require_once 'views/profil_view.php';
