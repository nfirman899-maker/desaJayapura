<?php require_once 'includes/header.php'; ?>

<section class="mb-8">
    <h2 class="text-3xl font-bold text-green-800">Profil Saya</h2>
    <p class="text-gray-600">Kelola informasi akun Anda</p>
</section>

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center gap-6 mb-6">
        <?php if(!empty($user['avatar'])): ?>
            <a href="uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" target="_blank" class="block shrink-0 transition-transform hover:scale-105 hover:opacity-90">
                <img src="uploads/avatars/<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="w-24 h-24 rounded-full object-cover shadow-sm border border-gray-200 cursor-pointer" title="Lihat Foto Profil">
            </a>
        <?php else: ?>
            <div class="w-24 h-24 rounded-full bg-green-800 flex items-center justify-center text-white text-3xl font-bold">
                <?= strtoupper(substr($user['full_name'], 0, 2)) ?>
            </div>
        <?php endif; ?>
        <div>
            <h3 class="text-xl font-bold"><?= htmlspecialchars($user['full_name']) ?></h3>
            <p class="text-gray-500">@<?= htmlspecialchars($user['username']) ?></p>
            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full mt-1">
                <?= ucfirst($user['role']) ?>
            </span>
        </div>
    </div>
    
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 py-3 border-b border-gray-100">
            <span class="text-sm text-gray-500 w-32">Email</span>
            <span><?= htmlspecialchars($user['email'] ?? '-') ?></span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 py-3 border-b border-gray-100">
            <span class="text-sm text-gray-500 w-32">Telepon</span>
            <span><?= htmlspecialchars($user['phone'] ?? '-') ?></span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 py-3">
            <span class="text-sm text-gray-500 w-32">Bergabung</span>
            <span><?= date('d M Y', strtotime($user['created_at'])) ?></span>
        </div>
    </div>
    
    <div class="mt-6 flex gap-4">
        <a href="edit_profil.php" class="px-6 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">
            Edit Profil
        </a>
        <a href="logout.php" class="px-6 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition">
            Logout
        </a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
