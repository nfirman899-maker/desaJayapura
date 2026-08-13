<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi
define('SITE_NAME', 'Desa Jayapura');
define('BASE_URL', '/desa-jayapura/');

// Cek login
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $_SESSION['full_name'] ?? 'Warga Desa';
$user_role = $_SESSION['role'] ?? 'warga';

// Fungsi aktif menu
function isActive($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return $current == $page ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - Portal Resmi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #191c1d;
            min-height: 100vh;
        }
        
        .favorite-active {
            font-variation-settings: 'FILL' 1;
            color: #ba1a1a;
            animation: heartBeat 0.3s ease-in-out;
        }
        
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>
</head>
<body class="lg:pl-64 pb-20 lg:pb-0 transition-all">
    <!-- Top App Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 flex justify-between items-center h-16">
            <a href="home.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo" class="h-16 w-auto object-contain drop-shadow-md">
                <h1 class="font-bold text-lg text-green-800"><?= SITE_NAME ?></h1>
            </a>
            
            <div class="flex items-center gap-3">
                <?php if ($is_logged_in): ?>
                    <?php if ($user_role === 'admin'): ?>
                        <a href="admin_inventaris.php" class="relative p-2 hover:bg-gray-100 rounded-full transition" title="Buku Inventaris">
                            <span class="material-symbols-outlined text-gray-600">book</span>
                        </a>
                        <a href="admin_peraturan.php" class="relative p-2 hover:bg-gray-100 rounded-full transition" title="Buku Peraturan">
                            <span class="material-symbols-outlined text-gray-600">menu_book</span>
                        </a>
                        <a href="admin_keputusan.php" class="relative p-2 hover:bg-gray-100 rounded-full transition" title="Buku Keputusan">
                            <span class="material-symbols-outlined text-gray-600">gavel</span>
                        </a>
                    <?php endif; ?>
                    <a href="notifikasi.php" class="relative p-2 hover:bg-gray-100 rounded-full transition">
                        <span class="material-symbols-outlined text-gray-600">notifications</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <?php if ($user_role === 'admin'): ?>
                            <span class="text-sm text-gray-600 hidden sm:inline"><?= htmlspecialchars($user_name) ?></span>
                        <?php endif; ?>
                        <a href="<?= $user_role === 'admin' ? 'admin.php' : 'profil.php' ?>" class="flex items-center gap-1 px-2 py-1.5 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                            <span class="text-sm font-medium"><?= $user_role === 'admin' ? 'Admin' : 'Warga' ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-6">
