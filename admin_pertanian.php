<?php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handling Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Ambil info file image
    $stmt = $db->prepare("SELECT image FROM pertanian WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if ($item) {
        if ($item['image'] && file_exists('uploads/pertanian/' . $item['image'])) {
            unlink('uploads/pertanian/' . $item['image']);
        }
        $stmt = $db->prepare("DELETE FROM pertanian WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Data pertanian berhasil dihapus!";
    }
}

// Handling form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $description = trim($_POST['description']);
    $image_name = '';
    
    // Cek edit atau tambah
    $is_edit = !empty($id);

    if ($is_edit) {
        $stmt = $db->prepare("SELECT image FROM pertanian WHERE id = ?");
        $stmt->execute([$id]);
        $old_data = $stmt->fetch();
        $image_name = $old_data['image'];
    }
    
    // Upload image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $upload_dir = 'uploads/pertanian/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $new_name = uniqid('pertanian_') . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_name)) {
                if ($is_edit && !empty($image_name) && file_exists($upload_dir . $image_name)) {
                    unlink($upload_dir . $image_name);
                }
                $image_name = $new_name;
            }
        }
    }
    
    if (empty($description)) {
        $error = "Deskripsi tidak boleh kosong.";
    } elseif (!$is_edit && empty($image_name)) {
        $error = "Silakan unggah foto untuk data pertanian baru.";
    } else {
        if ($is_edit) {
            $stmt = $db->prepare("UPDATE pertanian SET description = ?, image = ? WHERE id = ?");
            if ($stmt->execute([$description, $image_name, $id])) {
                $success = "Data pertanian berhasil diperbarui!";
            } else {
                $error = "Gagal memperbarui data.";
            }
        } else {
            $stmt = $db->prepare("INSERT INTO pertanian (description, image) VALUES (?, ?)");
            if ($stmt->execute([$description, $image_name])) {
                $success = "Data pertanian baru berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan data.";
            }
        }
    }
}

// Get data for edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM pertanian WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

// Get all pertanian items
$stmt = $db->query("SELECT * FROM pertanian ORDER BY created_at DESC");
$pertanian_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'views/admin_pertanian_view.php';
?>
