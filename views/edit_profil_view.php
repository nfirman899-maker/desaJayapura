<?php require_once 'includes/header.php'; ?>

<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-green-800">Edit Profil</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi akun Anda</p>
        </div>
        <a href="profil.php" class="text-green-700 font-semibold hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
        </a>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-6">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative mb-6">
            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="edit_profil.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Foto Profil -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-3">Foto Profil</label>
                <div class="flex items-center gap-6">
                    <?php if(!empty($user['avatar'])): ?>
                        <a href="uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" target="_blank" class="block shrink-0 transition-transform hover:scale-105 hover:opacity-90">
                            <img src="uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="w-20 h-20 rounded-full object-cover shadow-sm border border-gray-200 cursor-pointer" title="Lihat Foto Profil">
                        </a>
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-2xl font-bold border border-green-200">
                            <?= strtoupper(substr($user['full_name'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1">
                        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700
                            hover:file:bg-green-100 transition
                        "/>
                        <p class="text-xs text-gray-400 mt-2">Format yang diizinkan: JPG, JPEG, PNG, WEBP (Max: 2MB).</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="full_name" required value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 transition text-gray-700">
            </div>

            <!-- Nomor Telepon -->
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Nomor Telepon/WhatsApp</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Misal: 081234567890" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 transition text-gray-700">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-6 rounded-md transition shadow-sm">
                    Simpan Perubahan
                </button>
                <a href="profil.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-md transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
