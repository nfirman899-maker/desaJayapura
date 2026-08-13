<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Desa Jayapura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter'] bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-green-800">Lupa Password</h1>
                <p class="text-gray-600 mt-1">Atur ulang kata sandi Anda</p>
            </div>
            
            <?php if ($success): ?>
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
                <?php if (empty($verified_username)): ?>
                    <!-- Fase 1: Verifikasi -->
                    <p class="text-sm text-gray-500 mb-4 text-center">Masukkan Username dan Email yang terdaftar untuk verifikasi akun Anda.</p>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    
                    <button type="submit" name="verify" value="1"
                            class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">
                        Verifikasi Akun
                    </button>
                    
                <?php else: ?>
                    <!-- Fase 2: Reset Password -->
                    <input type="hidden" name="verified_username" value="<?= htmlspecialchars($verified_username) ?>">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="new_password" required minlength="6"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" required minlength="6"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
                    </div>
                    
                    <button type="submit" name="reset_password" value="1"
                            class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">
                        Simpan Password Baru
                    </button>
                <?php endif; ?>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <a href="login.php" class="text-green-800 font-semibold hover:underline">&larr; Kembali ke halaman Login</a>
            </div>
        </div>
    </div>
</body>
</html>
