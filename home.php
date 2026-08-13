<?php
// home.php
require_once 'includes/header.php';
require_once 'config/database.php';

$db = (new Database())->getConnection();

// Ambil berita terbaru
$news_query = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 2";
$news_stmt = $db->prepare($news_query);
$news_stmt->execute();
$news = $news_stmt->fetchAll();

// Ambil UMKM unggulan
$umkm_query = "SELECT u.*, c.name as category_name FROM umkm u 
               LEFT JOIN umkm_categories c ON u.category_id = c.id 
               WHERE u.is_featured = 1 AND u.is_active = 1 
               ORDER BY u.rating DESC LIMIT 2";
$umkm_stmt = $db->prepare($umkm_query);
$umkm_stmt->execute();
$featured_umkm = $umkm_stmt->fetchAll();
?>

<!-- Welcome -->
<section class="mb-8">
    <h2 class="text-3xl font-bold text-green-800">
        <?= $is_logged_in ? "Halo, " . htmlspecialchars($user_name) . "!" : "Halo, Warga Desa!" ?>
    </h2>
    <p class="text-gray-600 mt-1">Selamat datang di portal pelayanan digital <?= SITE_NAME ?>.</p>
</section>

<!-- Berita Terbaru -->
<section class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Kabar Desa Terkini</h3>
        <a href="info.php" class="text-green-800 text-sm font-medium">Lihat Semua →</a>
    </div>
    
    <?php if (empty($news)): ?>
        <p class="text-gray-500 text-center py-8">Belum ada berita terbaru.</p>
    <?php else: ?>
    <div class="grid md:grid-cols-2 gap-4">
        <?php foreach ($news as $item): ?>
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition">
            <?php if ($item['image']): ?>
            <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-48 object-cover">
            <?php endif; ?>
            <div class="p-4">
                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full mb-2">
                    <?= htmlspecialchars($item['category']) ?>
                </span>
                <h4 class="font-semibold"><?= htmlspecialchars($item['title']) ?></h4>
                <p class="text-gray-600 text-sm mt-1 line-clamp-2"><?= htmlspecialchars($item['content']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Layanan Cepat -->
<section class="mb-8">
    <h3 class="text-xl font-semibold mb-4">Layanan Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <a href="surat.php" class="bg-white p-4 rounded-xl border border-gray-200 text-center hover:bg-green-50 transition">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-green-800">mail</span>
            </div>
            <span class="text-sm font-medium">Surat Online</span>
        </a>
        <a href="info.php" class="bg-white p-4 rounded-xl border border-gray-200 text-center hover:bg-green-50 transition">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-green-800">campaign</span>
            </div>
            <span class="text-sm font-medium">Informasi Desa</span>
        </a>
        <a href="aspirasi.php" class="bg-white p-4 rounded-xl border border-gray-200 text-center hover:bg-green-50 transition">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-green-800">forum</span>
            </div>
            <span class="text-sm font-medium">Aspirasi</span>
        </a>
    </div>
</section>

<!-- UMKM Unggulan -->
<section>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">UMKM Unggulan</h3>
        <a href="umkm.php" class="text-green-800 text-sm font-medium">Lihat Semua →</a>
    </div>
    
    <?php if (empty($featured_umkm)): ?>
        <p class="text-gray-500 text-center py-8">Belum ada UMKM unggulan.</p>
    <?php else: ?>
    <div class="grid grid-cols-2 gap-4">
        <?php foreach ($featured_umkm as $umkm): ?>
        <a href="detail_umkm.php?id=<?= $umkm['id'] ?>" class="relative h-40 rounded-xl overflow-hidden group">
            <img src="<?= !empty($umkm['image']) ? (filter_var($umkm['image'], FILTER_VALIDATE_URL) ? $umkm['image'] : 'uploads/umkm/' . $umkm['image']) : 'https://via.placeholder.com/400x300' ?>" 
                 alt="<?= htmlspecialchars($umkm['name']) ?>" 
                 class="w-full h-full object-cover transition-transform group-hover:scale-105">
            <div class="absolute inset-0 bg-black/40 flex items-end p-4">
                <span class="text-white font-semibold"><?= htmlspecialchars($umkm['name']) ?></span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
