<?php
// umkm.php
require_once 'config/database.php';

$db = (new Database())->getConnection();

// Ambil kategori
$categories = $db->query("SELECT * FROM umkm_categories WHERE name != 'Jasa' ORDER BY name")->fetchAll();

// Filter
$category = $_GET['category'] ?? 'semua';
$search = $_GET['search'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 6;

// Query UMKM
$where = ["u.is_active = 1"];
$params = [];

if ($category !== 'semua') {
    $where[] = "c.slug = :category";
    $params[':category'] = $category;
}

if (!empty($search)) {
    $where[] = "(u.name LIKE :search OR u.description LIKE :search2)";
    $params[':search'] = "%$search%";
    $params[':search2'] = "%$search%";
}

$where_clause = implode(' AND ', $where);

// Count total
$count_stmt = $db->prepare("SELECT COUNT(*) FROM umkm u LEFT JOIN umkm_categories c ON u.category_id = c.id WHERE $where_clause");
$count_stmt->execute($params);
$total = $count_stmt->fetchColumn();
$total_pages = ceil($total / $per_page);

// Get data
$offset = ($page - 1) * $per_page;
$query = "SELECT u.*, c.name as category_name, c.slug as category_slug,
          (SELECT COUNT(*) FROM favorites f WHERE f.umkm_id = u.id) as favorite_count
          FROM umkm u 
          LEFT JOIN umkm_categories c ON u.category_id = c.id 
          WHERE $where_clause
          ORDER BY u.is_featured DESC, u.rating DESC 
          LIMIT $per_page OFFSET $offset";
$stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$umkm_list = $stmt->fetchAll();

// User favorites
$user_favorites = [];
if (isset($_SESSION['user_id'])) {
    $fav_stmt = $db->prepare("SELECT umkm_id FROM favorites WHERE user_id = :user_id");
    $fav_stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user_favorites = $fav_stmt->fetchAll(PDO::FETCH_COLUMN);
}

require_once 'views/umkm_view.php';
