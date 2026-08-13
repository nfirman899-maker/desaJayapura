<?php require_once 'includes/header.php'; ?>

<section class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-green-800">Kelola Pengguna</h2>
            <p class="text-gray-600">Daftar semua pengguna terdaftar</p>
        </div>
        <a href="admin.php" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali
        </a>
    </div>
</section>

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

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="p-4 text-sm font-semibold text-gray-700 w-16 text-center">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Foto & Nama</th>
                    <th class="p-4 text-sm font-semibold text-gray-700">Username / Role</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 hidden sm:table-cell">Kontak</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 hidden lg:table-cell">Bergabung</th>
                    <th class="p-4 text-sm font-semibold text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($semua_pengguna)): ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">Belum ada pengguna.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($semua_pengguna as $p): ?>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-center text-gray-500">#<?= $p['id'] ?></td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <?php if(!empty($p['avatar'])): ?>
                                        <a href="uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" target="_blank" class="block shrink-0 transition-transform hover:scale-105 hover:opacity-90">
                                            <img src="uploads/avatars/<?= htmlspecialchars($p['avatar']) ?>" alt="Avatar" class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-200 cursor-pointer" title="Lihat Foto Profil">
                                        </a>
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-sm font-bold border border-green-200 shrink-0">
                                            <?= strtoupper(substr($p['full_name'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h4 class="font-semibold text-gray-900"><?= htmlspecialchars($p['full_name']) ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-medium text-gray-900">@<?= htmlspecialchars($p['username']) ?></div>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium 
                                    <?= $p['role'] == 'admin' ? 'bg-purple-100 text-purple-700' : ($p['role'] == 'pelaku_umkm' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $p['role'])) ?>
                                </span>
                            </td>
                            <td class="p-4 hidden sm:table-cell text-sm">
                                <div class="text-gray-600 mb-1"><?= htmlspecialchars($p['email'] ?? '-') ?></div>
                                <div class="text-gray-500"><?= htmlspecialchars($p['phone'] ?? '-') ?></div>
                            </td>
                            <td class="p-4 hidden lg:table-cell text-sm text-gray-500">
                                <?= date('d M Y', strtotime($p['created_at'])) ?>
                            </td>
                            <td class="p-4 text-center">
                                <?php if($p['id'] != $_SESSION['user_id']): ?>
                                    <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?')" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-red-500 hover:bg-red-50 hover:text-red-700 transition" title="Hapus Pengguna">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400 italic">Anda</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
