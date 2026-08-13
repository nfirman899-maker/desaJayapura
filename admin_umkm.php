<?php
// admin_umkm.php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login_admin.php');
    exit;
}

$db = (new Database())->getConnection();
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Hapus foto jika ada
        $stmt = $db->prepare("SELECT image FROM umkm WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row && !empty($row['image'])) {
            $filePath = 'uploads/umkm/' . $row['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $db->prepare("DELETE FROM umkm WHERE id = ?");
        $stmt->execute([$id]);
        $success = "UMKM berhasil dihapus.";
    } catch (PDOException $e) {
        $error = "Gagal menghapus UMKM.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $subcategory = $_POST['subcategory'] ?? '';
    $description = $_POST['description'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $id = $_POST['id'] ?? '';
    
    $imageName = null;
    
    // Handle File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/umkm/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $imageName = $fileName;
            } else {
                $error = "Gagal mengupload foto.";
            }
        } else {
            $error = "Hanya file JPG, JPEG, PNG, GIF, & WEBP yang diperbolehkan.";
        }
    }
    
    if (empty($name) || empty($category_id) || empty($description)) {
        $error = empty($error) ? "Nama, Kategori, dan Deskripsi wajib diisi!" : $error;
    } else if (empty($error)) {
        try {
            if ($id) {
                // Update
                if ($imageName) {
                    $stmt = $db->prepare("UPDATE umkm SET owner_name = ?, name = ?, category_id = ?, subcategory = ?, description = ?, phone = ?, address = ?, is_featured = ?, image = ? WHERE id = ?");
                    $stmt->execute([$owner_name, $name, $category_id, $subcategory, $description, $phone, $address, $is_featured, $imageName, $id]);
                } else {
                    $stmt = $db->prepare("UPDATE umkm SET owner_name = ?, name = ?, category_id = ?, subcategory = ?, description = ?, phone = ?, address = ?, is_featured = ? WHERE id = ?");
                    $stmt->execute([$owner_name, $name, $category_id, $subcategory, $description, $phone, $address, $is_featured, $id]);
                }
                $success = "UMKM berhasil diperbarui.";
            } else {
                // Insert
                $stmt = $db->prepare("INSERT INTO umkm (owner_name, name, category_id, subcategory, description, phone, address, is_featured, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$owner_name, $name, $category_id, $subcategory, $description, $phone, $address, $is_featured, $imageName]);
                $success = "UMKM berhasil ditambahkan.";
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat menyimpan UMKM.";
        }
    }
}

// Fetch all UMKM
$stmt = $db->query("
    SELECT umkm.*, umkm_categories.name as category_name, COALESCE(umkm.owner_name, users.full_name) as owner_name 
    FROM umkm 
    LEFT JOIN umkm_categories ON umkm.category_id = umkm_categories.id 
    LEFT JOIN users ON umkm.user_id = users.id
    ORDER BY umkm.id DESC
");
$umkms = $stmt->fetchAll();

// Fetch categories for form
$cat_stmt = $db->query("SELECT * FROM umkm_categories ORDER BY name ASC");
$categories = $cat_stmt->fetchAll();

// Fetch users for form
$users_stmt = $db->query("SELECT id, full_name, role FROM users ORDER BY full_name ASC");
$users = $users_stmt->fetchAll();

$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_stmt = $db->prepare("
        SELECT umkm.*, COALESCE(umkm.owner_name, users.full_name) as owner_name 
        FROM umkm 
        LEFT JOIN users ON umkm.user_id = users.id 
        WHERE umkm.id = ?
    ");
    $edit_stmt->execute([$_GET['edit']]);
    $edit_data = $edit_stmt->fetch();
}

require_once 'views/admin_umkm_view.php';
