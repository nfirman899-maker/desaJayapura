<?php require_once 'includes/header.php'; ?>

<!-- Header -->
<section class="mb-8">
    <h2 class="text-3xl font-bold text-green-800">UMKM Lokal</h2>
    <p class="text-gray-600">Dukung ekonomi kreatif warga <?= SITE_NAME ?></p>
</section>

<!-- Search -->
<form method="GET" class="mb-6">
    <div class="relative">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
               placeholder="Cari produk atau usaha..."
               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition">
    </div>
</form>



<!-- UMKM List -->
<?php if (empty($umkm_list)): ?>
<div class="text-center py-12">
    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">storefront</span>
    <p class="text-gray-500">Belum ada UMKM dalam kategori ini</p>
</div>
<?php else: ?>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($umkm_list as $umkm): 
        $is_fav = in_array($umkm['id'], $user_favorites);
    ?>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition">
        <div class="relative h-48">
            <img src="<?= !empty($umkm['image']) ? (filter_var($umkm['image'], FILTER_VALIDATE_URL) ? $umkm['image'] : 'uploads/umkm/' . $umkm['image']) : 'https://via.placeholder.com/400x300' ?>" 
                 alt="<?= htmlspecialchars($umkm['name']) ?>" 
                 class="w-full h-full object-cover">
            <div class="absolute top-3 right-3 bg-white/90 px-3 py-1 rounded-full text-sm font-medium text-green-800">
                ★ <?= number_format($umkm['rating'], 1) ?>
            </div>
        </div>
        <div class="p-4">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-lg"><?= htmlspecialchars($umkm['name']) ?></h4>
                    <p class="text-sm text-gray-500"><?= htmlspecialchars($umkm['category_name']) ?></p>
                </div>
                <button onclick="toggleFavorite(<?= $umkm['id'] ?>, this)" 
                        class="p-2 hover:bg-gray-100 rounded-full transition <?= $is_fav ? 'favorite-active' : '' ?>">
                    <span class="material-symbols-outlined">favorite</span>
                </button>
            </div>
            <p class="text-gray-600 text-sm mt-2 line-clamp-2"><?= htmlspecialchars($umkm['description']) ?></p>
            <div class="flex items-center justify-between mt-4">
                <div class="flex gap-2">
                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm['phone'])) ?>" target="_blank" 
                       class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-green-800 hover:bg-green-50 transition">
                        <span class="material-symbols-outlined text-sm">chat</span>
                    </a>
                    <a href="tel:<?= $umkm['phone'] ?>" 
                       class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-green-800 hover:bg-green-50 transition">
                        <span class="material-symbols-outlined text-sm">call</span>
                    </a>
                </div>
                <a href="detail_umkm.php?id=<?= $umkm['id'] ?>" 
                   class="px-4 py-2 bg-green-800 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<div class="flex justify-center gap-2 mt-8">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a href="?page=<?= $i ?>&category=<?= $category ?><?= $search ? '&search='.urlencode($search) : '' ?>" 
       class="w-10 h-10 rounded-full flex items-center justify-center <?= $i === $page ? 'bg-green-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- FAB -->
<?php if ($is_logged_in && $user_role === 'pelaku_umkm'): ?>
<a href="daftar_umkm.php" class="fixed bottom-24 right-4 z-40 w-14 h-14 bg-green-800 text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-green-700 transition">
    <span class="material-symbols-outlined text-3xl">add</span>
</a>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
