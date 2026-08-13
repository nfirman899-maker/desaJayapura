<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Desa Jayapura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter'] bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <img src="img/logo.png" alt="Logo" class="h-28 w-auto mx-auto -mb-2 object-contain">
                <h1 class="text-2xl font-bold text-green-800">Desa Jayapura</h1>
                <p class="text-gray-600 mt-1">Silakan login untuk melanjutkan</p>
            </div>
            
            <?php if (!empty($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                </div>
                
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="lupa_password.php" class="text-sm font-medium text-green-700 hover:text-green-800 hover:underline">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required placeholder="Masukkan password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                </div>
                
                <button type="submit" 
                        class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">
                    Masuk
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Belum punya akun? <a href="register.php" class="text-green-800 font-semibold hover:underline">Daftar di sini</a></p>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="login_admin.php" class="text-green-800 font-semibold hover:underline">Login sebagai Admin</a>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; Copyright hak cipta dilindungi KKN Jayapura Universitas Perjuangan 2026</p>
        </div>
    </div>
</body>
</html>
