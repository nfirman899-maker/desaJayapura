<?php
// index.php (Landing Page)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke home jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#16a34a', // emerald-600 approx
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 bg-white">
    
    <!-- Navbar (Transparent over Hero) -->
    <nav class="absolute top-0 w-full z-50 px-6 py-5 flex items-center justify-between">
        <!-- Logo Area -->
        <div class="flex items-center gap-3">
            <img src="img/logo.png" alt="Logo Desa" class="h-20 w-auto object-contain drop-shadow-md">
            <div class="text-white font-bold text-lg leading-tight tracking-wide drop-shadow-md">
                DESA<br>JAYAPURA
            </div>
        </div>
        
        <!-- Navigation Links -->
        <div class="hidden md:flex items-center gap-8 drop-shadow-md">
            <a href="login.php?msg=login_required" class="text-white text-sm font-semibold hover:text-green-300 transition tracking-wider">BERANDA</a>
            <a href="login.php?msg=login_required" class="text-white text-sm font-semibold hover:text-green-300 transition tracking-wider">INFORMASI</a>
            <a href="register.php" class="text-white text-sm font-semibold hover:text-green-300 transition tracking-wider">DAFTAR</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative w-full h-[80vh] min-h-[600px] flex items-center">
        <!-- Background Image (Waterfall/Nature) -->
        <div class="absolute inset-0 w-full h-full">
            <img src="img/386658.webp" 
                 alt="Pemandangan Desa" 
                 class="w-full h-full object-cover">
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full mt-16">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight font-display drop-shadow-lg">
                    Selamat Datang di Portal Resmi<br/>
                    Desa Jayapura
                </h1>
                <p class="text-gray-200 text-base md:text-lg leading-relaxed mb-10 max-w-2xl drop-shadow-md">
                    Mewujudkan tata kelola pemerintahan desa yang transparan, akuntabel, dan berbasis digital demi kesejahteraan seluruh warga desa.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="login.php" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-green text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-lg hover:shadow-green-600/30">
                        <span class="material-symbols-outlined text-xl">login</span>
                        Masuk / Login
                    </a>
                    <a href="info.php" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-gray-900 transition-all shadow-lg">
                        Profil Desa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sejarah Section -->
    <section class="py-20 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Text Content -->
            <div>
                <h4 class="text-brand-green font-bold text-sm tracking-widest mb-3 uppercase">
                    Warisan Bangsa
                </h4>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-display">
                    Sejarah Desa Jayapura
                </h2>
                
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>
                        Berdiri sejak puluhan tahun yang lalu, Desa Jayapura berawal dari pemukiman agraris yang dikenal dengan semangat gotong royongnya yang kuat. Masyarakat hidup rukun dalam balutan tradisi dan budaya lokal yang terus dijaga kelestariannya.
                    </p>
                    <p>
                        Kini, Jayapura bertransformasi menjadi desa mandiri yang tetap mempertahankan akar budayanya namun terbuka terhadap kemajuan teknologi digital. Dengan adanya portal layanan ini, diharapkan pelayanan publik semakin mudah dan kesejahteraan warga terus meningkat.
                    </p> 
                </div>
            </div>
            
            <!-- Image Content -->
            <div class="w-full">
                <img src="img/IMG_1264.PNG" 
                     alt="Pemandangan Jalan Desa" 
                     class="w-full h-auto rounded-3xl shadow-2xl object-cover aspect-[4/3]">
            </div>
            
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="w-full bg-gray-50 border-t border-gray-200 py-8 text-center mt-auto">
        <p class="text-gray-500 text-sm">
            &copy; Copyright hak cipta dilindungi KKN Jayapura Universitas Perjuangan <?= date('Y') ?>
        </p>
    </footer>

</body>
</html>
