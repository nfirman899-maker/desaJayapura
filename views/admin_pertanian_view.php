<?php require_once 'includes/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Pertanian</h1>
            <p class="text-gray-600">Buat, edit, dan kelola data Potensi Pertanian Desa Jayapura.</p>
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

    <div class="flex flex-col gap-10">
        <!-- Form Section -->
        <div class="w-full">
            <div class="bg-white px-6 sm:px-10 py-8 sm:py-12 rounded-sm shadow-md border border-gray-200">
                <!-- Kop Surat Style Header -->
                <div class="text-center mb-6 border-b-4 border-double border-gray-800 pb-5">
                    <h2 class="text-sm sm:text-base font-bold text-gray-900 uppercase tracking-widest leading-tight">Pemerintah Kabupaten Tasikmalaya</h2>
                    <h2 class="text-sm sm:text-base font-bold text-gray-900 uppercase tracking-widest leading-tight">Kecamatan Cigalontang</h2>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 uppercase tracking-widest leading-tight mt-1">Desa Jayapura</h3>
                    <p class="text-[11px] sm:text-xs text-gray-600 mt-2 font-medium">FORMULIR DATA POTENSI PERTANIAN DESA</p>
                </div>
                
                <h2 class="text-lg font-bold text-gray-900 mb-6 text-center uppercase tracking-wider border-b border-gray-200 pb-2"><?= $edit_data ? 'Edit Data Pertanian' : 'Tambah Data Baru' ?></h2>
                
                <form action="admin_pertanian.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Pertanian <?= !$edit_data ? '<span class="text-red-500">*</span>' : '(Opsional)' ?></label>
                        <?php if(!empty($edit_data['image'])): ?>
                            <div class="mb-2">
                                <img src="uploads/pertanian/<?= htmlspecialchars($edit_data['image']) ?>" alt="Foto" class="h-24 w-full rounded object-cover">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow" placeholder="Tuliskan deskripsi pertanian..."><?= htmlspecialchars($edit_data['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            <?= $edit_data ? 'Simpan Perubahan' : 'Tambahkan' ?>
                        </button>
                        <?php if($edit_data): ?>
                            <a href="admin_pertanian.php" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- List Section -->
        <div class="w-full">
            <div class="bg-white rounded-sm shadow-md border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm">
                                <th class="py-3 px-4 w-24">Foto</th>
                                <th class="py-3 px-4">Deskripsi</th>
                                <th class="py-3 px-4 text-right w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(empty($pertanian_list)): ?>
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-500">Belum ada data pertanian.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($pertanian_list as $p): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <?php if($p['image']): ?>
                                            <img src="uploads/pertanian/<?= htmlspecialchars($p['image']) ?>" alt="Foto" class="w-16 h-16 rounded object-cover">
                                        <?php else: ?>
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                                <span class="material-symbols-outlined">image</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-gray-700 text-sm line-clamp-3"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                                        <p class="text-xs text-gray-400 mt-1"><?= date('d M Y H:i', strtotime($p['created_at'])) ?></p>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="admin_pertanian.php?edit=<?= $p['id'] ?>" class="p-1 text-gray-400 hover:text-green-600 transition" title="Edit">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </a>
                                            <a href="admin_pertanian.php?delete=<?= $p['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus">
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
