<?php require_once 'includes/header.php'; ?>

<div class="mb-6">
    <a href="umkm.php" class="text-green-800 hover:underline">← Kembali ke Daftar UMKM</a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <img src="<?= !empty($umkm['image']) ? (filter_var($umkm['image'], FILTER_VALIDATE_URL) ? $umkm['image'] : 'uploads/umkm/' . $umkm['image']) : 'https://via.placeholder.com/800x400' ?>" 
         alt="<?= htmlspecialchars($umkm['name']) ?>" 
         class="w-full h-72 object-cover">
    
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-green-800"><?= htmlspecialchars($umkm['name']) ?></h1>
                <p class="text-gray-500"><?= htmlspecialchars($umkm['category_name']) ?> • <?= htmlspecialchars($umkm['subcategory']) ?></p>
            </div>
            <button onclick="toggleFavorite(<?= $umkm['id'] ?>, this)" 
                    class="p-3 hover:bg-gray-100 rounded-full transition <?= $is_favorite ? 'favorite-active' : '' ?>">
                <span class="material-symbols-outlined text-2xl">favorite</span>
            </button>
        </div>
        
        <div class="flex items-center gap-4 mt-4">
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-yellow-500" style="font-variation-settings: 'FILL' 1;">star</span>
                <span class="font-semibold"><?= number_format($umkm['rating'], 1) ?></span>
            </div>
            <span class="text-gray-400">|</span>
            <span class="text-gray-600"><?= $umkm['address'] ?></span>
        </div>
        
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Deskripsi</h3>
            <p class="text-gray-700"><?= nl2br(htmlspecialchars($umkm['description'])) ?></p>
        </div>
        
        <div class="mt-6 flex flex-wrap gap-4">
            <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $umkm['phone'])) ?>" target="_blank"
               class="flex items-center gap-2 px-6 py-3 bg-green-800 text-white rounded-lg hover:bg-green-700 transition">
                <span class="material-symbols-outlined">chat</span>
                Chat WhatsApp
            </a>
            <a href="tel:<?= $umkm['phone'] ?>"
               class="flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <span class="material-symbols-outlined">call</span>
                Telepon
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
