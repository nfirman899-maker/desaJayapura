<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Jayapura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter'] bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-green-800">
            <div class="text-center mb-8">
                <img src="img/logo.png" alt="Logo" class="h-28 w-auto mx-auto -mb-2 object-contain">
                <h1 class="text-2xl font-bold text-green-800">Admin Panel</h1>
                <p class="text-gray-600 mt-1">Silakan login untuk masuk ke dashboard admin</p>
            </div>
            
            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username Admin</label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                </div>
                
                <button type="submit" 
                        class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">
                    Masuk ke Dashboard
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="login.php" class="text-green-800 font-semibold hover:underline">Kembali ke Halaman Login Warga</a>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; Copyright hak cipta dilindungi KKN Jayapura Universitas Perjuangan 2026</p>
        </div>
    </div>
</body>
</html>
