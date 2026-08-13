<?php require_once 'includes/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola UMKM</h1>
            <p class="text-gray-600">Buat, edit, dan kelola data Usaha Mikro Kecil dan Menengah.</p>
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
                    <p class="text-[11px] sm:text-xs text-gray-600 mt-2 font-medium">FORMULIR PENDAFTARAN & PENGELOLAAN UMKM DESA</p>
                </div>
                
                <h2 class="text-lg font-bold text-gray-900 mb-6 text-center uppercase tracking-wider border-b border-gray-200 pb-2"><?= $edit_data ? 'Edit Data UMKM' : 'Tambah UMKM Baru' ?></h2>
                
                <form action="admin_umkm.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha</label>
                        <input type="text" name="name" required value="<?= htmlspecialchars($edit_data['name'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemilik UMKM</label>
                        <input type="text" name="owner_name" required placeholder="Masukkan Nama Pemilik" value="<?= htmlspecialchars($edit_data['owner_name'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Utama</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                            <option value="">-- Pilih Kategori --</option>
                            <?php 
                            $current_cat_id = $edit_data['category_id'] ?? '';
                            foreach($categories as $cat): 
                            ?>
                                <option value="<?= $cat['id'] ?>" <?= $current_cat_id == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subkategori (Opsional)</label>
                        <input type="text" name="subcategory" placeholder="Contoh: Makanan Ringan, Jahit Pakaian" value="<?= htmlspecialchars($edit_data['subcategory'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon/WA (Opsional)</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($edit_data['phone'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat (Opsional)</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($edit_data['address'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto UMKM (Opsional)</label>
                        <?php if(!empty($edit_data['image'])): ?>
                            <div class="mb-2">
                                <img src="uploads/umkm/<?= htmlspecialchars($edit_data['image']) ?>" alt="Foto UMKM" class="h-24 rounded object-cover">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow">
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" <?= (isset($edit_data['is_featured']) && $edit_data['is_featured'] == 1) ? 'checked' : '' ?> class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            Jadikan UMKM Unggulan (Tampil di Beranda)
                        </label>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Usaha</label>
                        <textarea name="description" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-shadow"><?= htmlspecialchars($edit_data['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">
                            <?= $edit_data ? 'Update' : 'Simpan' ?>
                        </button>
                        <?php if($edit_data): ?>
                            <a href="admin_umkm.php" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition">Batal</a>
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
                                <th class="py-3 px-4">Nama Usaha</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Kontak / Alamat</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if(empty($umkms)): ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Belum ada data UMKM.</td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($umkms as $u): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900"><?= htmlspecialchars($u['name']) ?></div>
                                        <?php if($u['subcategory']): ?>
                                            <div class="text-xs text-gray-500"><?= htmlspecialchars($u['subcategory']) ?></div>
                                        <?php endif; ?>
                                        <div class="text-xs text-green-700 mt-1">Pemilik: <?= htmlspecialchars($u['owner_name'] ?? 'Tidak diketahui') ?></div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?= htmlspecialchars($u['category_name']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <?php if($u['phone']): ?>
                                            <div class="text-sm text-gray-700 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">call</span>
                                                <?= htmlspecialchars($u['phone']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($u['address']): ?>
                                            <div class="text-xs text-gray-500 mt-1 truncate max-w-[200px]">
                                                <?= htmlspecialchars($u['address']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="admin_umkm.php?edit=<?= $u['id'] ?>" class="p-1 text-gray-400 hover:text-green-600 transition" title="Edit">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </a>
                                            <a href="admin_umkm.php?delete=<?= $u['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data UMKM ini?')" class="p-1 text-gray-400 hover:text-red-600 transition" title="Hapus">
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
