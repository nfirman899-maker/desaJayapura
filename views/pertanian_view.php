<?php require_once 'includes/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-8 mb-16">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Potensi Pertanian</h1>
        <p class="text-gray-600 mt-2">Jelajahi berbagai potensi dan hasil pertanian unggulan dari Desa Jayapura.</p>
    </div>

    <!-- Grid List -->
    <?php if (empty($pertanian_list)): ?>
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">agriculture</span>
            <p class="text-gray-500">Belum ada data pertanian saat ini.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($pertanian_list as $item): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition duration-300">
                    <div class="relative h-56 bg-gray-100">
                        <?php if(!empty($item['image'])): ?>
                            <img src="uploads/pertanian/<?= htmlspecialchars($item['image']) ?>" alt="Pertanian" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl">image</span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Overlay gradient for better text readability if we had text on image -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed text-sm">
                            <?= nl2br(htmlspecialchars($item['description'])) ?>
                        </p>
                        <p class="text-xs text-gray-400 mt-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                            Diunggah pada <?= date('d M Y', strtotime($item['created_at'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
