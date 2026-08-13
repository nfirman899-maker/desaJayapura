<?php require_once 'includes/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pengumuman</h1>
            <p class="text-gray-600">Buat, edit, dan kelola informasi untuk warga.</p>
        </div>
        <a href="admin.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
            Kembali ke Dashboard
        </a>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 border border-red-200"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 border border-green-200"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-4"><?= $edit_data ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' ?></h2>
                
                <form action="admin_pengumuman.php" method="POST">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman</label>
                        <input type="text" name="title" required value="<?= htmlspecialchars($edit_data['title'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                            <?php 
                            $categories = ['Berita', 'Penting', 'Kesehatan', 'Kegiatan', 'Lainnya'];
                            $current_cat = $edit_data['category'] ?? '';
                            foreach($categories as $cat): 
                            ?>
                                <option value="<?= $cat ?>" <?= $current_cat === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                        <textarea name="content" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"><?= htmlspecialchars($edit_data['content'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            <?= $edit_data ? 'Update' : 'Simpan' ?>
                        </button>
                        <?php if($edit_data): ?>
                            <a href="admin_pengumuman.php" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- List Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm">
                                <th class="py-3 px-4">Judul</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Tanggal</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(empty($announcements)): ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Belum ada pengumuman.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($announcements as $ann): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900"><?= htmlspecialchars($ann['title']) ?></div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs"><?= htmlspecialchars(substr($ann['content'], 0, 50)) ?>...</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?= htmlspecialchars($ann['category']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">
                                        <?= date('d M Y', strtotime($ann['created_at'])) ?>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="admin_pengumuman.php?edit=<?= $ann['id'] ?>" class="p-1 text-gray-400 hover:text-green-600 transition" title="Edit">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </a>
                                            <a href="admin_pengumuman.php?delete=<?= $ann['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
