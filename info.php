<?php
// info.php
require_once 'includes/header.php';
require_once 'config/database.php';

$db = (new Database())->getConnection();

$query = "SELECT * FROM announcements ORDER BY is_urgent DESC, created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$announcements = $stmt->fetchAll();
?>

<section class="mb-8">
    <h2 class="text-3xl font-bold text-green-800">Informasi Desa</h2>
    <p class="text-gray-600">Update terkini kegiatan dan pengumuman resmi</p>
</section>

<?php if (empty($announcements)): ?>
<div class="text-center py-12">
    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">campaign</span>
    <p class="text-gray-500">Belum ada pengumuman</p>
</div>
<?php else: ?>
<div class="space-y-4">
    <?php foreach ($announcements as $item): ?>
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition <?= $item['is_urgent'] ? 'border-red-300 bg-red-50' : '' ?>">
        <div class="flex items-start gap-3">
            <?php if ($item['is_urgent']): ?>
            <span class="material-symbols-outlined text-red-500">priority_high</span>
            <?php endif; ?>
            <div class="flex-1">
                <div class="flex items-center gap-3 flex-wrap">
                    <h3 class="font-semibold text-lg"><?= htmlspecialchars($item['title']) ?></h3>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                        <?= htmlspecialchars($item['category']) ?>
                    </span>
                    <?php if ($item['is_urgent']): ?>
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full">Urgent</span>
                    <?php endif; ?>
                </div>
                <p class="text-gray-600 mt-2"><?= nl2br(htmlspecialchars($item['content'])) ?></p>
                <p class="text-sm text-gray-400 mt-2">
                    <?= date('d M Y H:i', strtotime($item['created_at'])) ?>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
