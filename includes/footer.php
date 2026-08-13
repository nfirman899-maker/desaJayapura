<?php
// includes/footer.php
$nav_items = [
    ['name' => 'Beranda', 'icon' => 'home', 'url' => 'home.php'],
    ['name' => 'Informasi Desa', 'icon' => 'campaign', 'url' => 'info.php'],
    ['name' => 'Surat', 'icon' => 'mail', 'url' => 'surat.php'],
    ['name' => 'UMKM', 'icon' => 'storefront', 'url' => 'umkm.php'],
    ['name' => 'Pertanian', 'icon' => 'agriculture', 'url' => 'pertanian.php'],
    ['name' => 'Aspirasi', 'icon' => 'forum', 'url' => 'aspirasi.php'],
    ['name' => 'Profil', 'icon' => 'person', 'url' => 'profil.php']
];

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    array_unshift($nav_items, ['name' => 'Arsip', 'icon' => 'folder_open', 'url' => 'admin_arsip.php']);
    array_unshift($nav_items, ['name' => 'Dashboard Admin', 'icon' => 'dashboard', 'url' => 'admin.php']);
}

$current = basename($_SERVER['PHP_SELF']);
?>
    </main>

    <!-- Left Navigation (Desktop) -->
    <nav class="hidden lg:flex fixed top-0 left-0 h-full w-64 z-50 bg-green-800 shadow-lg flex-col">
        <div class="py-6 flex-1">
            <div class="px-6 mb-8 text-white">
                <h2 class="text-2xl font-bold">Desa Jayapura</h2>
            </div>
            <div class="flex flex-col gap-2 px-4">
            <?php foreach ($nav_items as $item): 
                $active = ($current == $item['url']);
            ?>
            <a href="<?= $item['url'] ?>" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition <?= $active ? 'bg-green-900 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' ?>">
                <span class="material-symbols-outlined" <?= $active ? 'style="font-variation-settings: \'FILL\' 1;"' : '' ?>>
                    <?= $item['icon'] ?>
                </span>
                <span class="text-sm font-medium"><?= $item['name'] ?></span>
            </a>
            <?php endforeach; ?>
            </div>
        </div>
        
        <div class="p-4 border-t border-green-700">
            <?php if (isset($is_logged_in) && $is_logged_in): ?>
                <a href="logout.php" class="flex items-center gap-4 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Keluar</span>
                </a>
            <?php else: ?>
                <a href="login.php" class="flex items-center gap-4 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition">
                    <span class="material-symbols-outlined">login</span>
                    <span class="text-sm font-medium">Masuk</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 z-50 flex justify-around items-center h-16 px-2 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
        <?php foreach ($nav_items as $item): 
            $active = ($current == $item['url']);
        ?>
        <a href="<?= $item['url'] ?>" 
           class="flex flex-col items-center justify-center w-full h-full space-y-1 <?= $active ? 'text-green-700' : 'text-gray-500 hover:text-green-600' ?>">
            <span class="material-symbols-outlined text-2xl" <?= $active ? 'style="font-variation-settings: \'FILL\' 1;"' : '' ?>>
                <?= $item['icon'] ?>
            </span>
            <span class="text-[10px] font-medium leading-none"><?= $item['name'] ?></span>
        </a>
        <?php endforeach; ?>
    </nav>

    <script>
        // Toggle Favorite
        function toggleFavorite(umkmId, button) {
            <?php if (!$is_logged_in): ?>
                window.location.href = 'login.php';
                return;
            <?php endif; ?>
            
            fetch('toggle_favorite.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'umkm_id=' + umkmId
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('favorite-active');
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>
