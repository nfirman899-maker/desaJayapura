<?php
// landing.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke index jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Jayapura - Portal Resmi</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0fdf4; /* bg-green-50 */
        }
        .hero-pattern {
            background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%2322c55e" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="hero-pattern min-h-screen flex flex-col justify-between">
    
    <!-- Navbar -->
    <nav class="w-full px-6 py-4 bg-white/80 backdrop-blur-md shadow-sm fixed top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo Desa" class="h-16 w-auto object-contain drop-shadow-md">
                <span class="font-bold text-xl text-green-800">Desa Jayapura</span>
            </div>
            <div class="hidden md:flex gap-4">
                <a href="login.php" class="px-5 py-2 text-green-700 font-medium hover:bg-green-50 rounded-lg transition">Masuk</a>
                <a href="register.php" class="px-5 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 shadow-md transition">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center pt-24 pb-12 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium text-sm mb-6 animate-bounce">
                <span class="material-symbols-outlined text-sm">campaign</span>
                Portal Layanan Digital Desa
            </div>
            
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                Selamat Datang di <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-teal-500">
                    Desa Jayapura
                </span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform digital resmi untuk mempermudah pelayanan administrasi, informasi desa, dan pengaduan aspirasi masyarakat secara cepat dan transparan.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="login.php" class="w-full sm:w-auto px-8 py-3.5 bg-green-600 text-white font-semibold rounded-xl shadow-lg shadow-green-200 hover:bg-green-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">login</span>
                    Masuk Sekarang
                </a>
                <a href="home.php" class="w-full sm:w-auto px-8 py-3.5 bg-white text-green-700 font-semibold rounded-xl border border-green-200 shadow-sm hover:bg-green-50 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">explore</span>
                    Lihat Beranda
                </a>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition text-left">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 text-green-600">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Layanan Surat</h3>
                    <p class="text-gray-600 text-sm">Ajukan pembuatan surat pengantar, keterangan, dan dokumen lainnya secara online.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition text-left">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 text-green-600">
                        <span class="material-symbols-outlined text-2xl">storefront</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">UMKM Desa</h3>
                    <p class="text-gray-600 text-sm">Jelajahi dan promosikan potensi produk lokal dari UMKM di lingkungan desa.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition text-left">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 text-green-600">
                        <span class="material-symbols-outlined text-2xl">forum</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Suara Warga</h3>
                    <p class="text-gray-600 text-sm">Sampaikan aspirasi, kritik, dan saran untuk kemajuan desa secara langsung.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-gray-200 py-6 mt-auto text-center">
        <p class="text-gray-500 text-sm">
            &copy; <?= date('Y') ?> Pemerintah Desa Jayapura. All rights reserved.
        </p>
    </footer>

</body>
</html>
