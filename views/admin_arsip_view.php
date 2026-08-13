<?php require_once 'includes/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Manajemen Arsip Desa</h1>
        <p class="text-gray-600 mt-2">Kelola arsip dokumen desa yang terintegrasi dengan tautan Google Drive.</p>
    </div>

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

    <div class="flex flex-col gap-10 max-w-3xl mx-auto">
        <!-- Form Pengajuan -->
        <div class="w-full">
            <div class="bg-white px-6 sm:px-10 py-8 sm:py-12 rounded-sm shadow-lg border-t-8 border-t-green-800 border-x border-b border-gray-200">
                
                <!-- Kop Surat Style Header -->
                <div class="text-center mb-6 border-b-4 border-double border-gray-800 pb-5">
                    <h2 class="text-sm sm:text-base font-bold text-gray-900 uppercase tracking-widest leading-tight">Pemerintah Kabupaten Tasikmalaya</h2>
                    <h2 class="text-sm sm:text-base font-bold text-gray-900 uppercase tracking-widest leading-tight">Kecamatan Cigalontang</h2>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 uppercase tracking-widest leading-tight mt-1">Desa Jayapura</h3>
                    <p class="text-[11px] sm:text-xs text-gray-600 mt-2 font-medium">FORMULIR PENYIMPANAN ARSIP ELEKTRONIK DESA</p>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6 text-xs sm:text-sm text-blue-900">
                    <strong>PERHATIAN:</strong> Pastikan arsip dokumen telah diunggah ke Google Drive sebelum menyalin tautannya ke dalam sistem ini.
                </div>

                <form action="admin_arsip.php" method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Judul Arsip</label>
                            <input type="text" name="judul" required placeholder="Masukkan judul arsip..." class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white font-medium">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Tanggal Arsip</label>
                            <input type="date" name="tanggal_arsip" required class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Tautan Google Drive Terkait</label>
                        <input type="url" name="link_gdrive" required placeholder="https://drive.google.com/..." class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white font-medium">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Catatan / Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="4" placeholder="Masukkan keterangan tambahan jika ada..." class="w-full px-4 py-3 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white resize-none font-medium"></textarea>
                    </div>

                    <div class="pt-5 mt-6 border-t border-gray-200">
                        <button type="submit" class="w-full bg-green-800 hover:bg-green-900 text-white font-bold py-3 px-4 rounded-sm transition flex justify-center items-center gap-2 uppercase tracking-widest text-xs shadow-md">
                            <span class="material-symbols-outlined" style="font-size: 18px;">save</span>
                            Simpan Rekam Arsip
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Pengajuan -->
        <div class="w-full">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-lg font-bold text-gray-900">Daftar Arsip Google Drive</h2>
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                            Total: <?= count($riwayat_arsip) ?> Arsip
                        </span>
                    </div>
                    
                    <form method="GET" action="admin_arsip.php" class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="date" name="tanggal_arsip" value="<?= htmlspecialchars($filter_tanggal ?? '') ?>" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-amber-900 text-gray-700 text-sm w-full sm:w-auto bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
                        <?php if (!empty($filter_tanggal)): ?>
                            <a href="admin_arsip.php" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-sm font-medium">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if (empty($riwayat_arsip)): ?>
                    <div class="p-12 text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-gray-300 text-3xl">folder_open</span>
                        </div>
                        <p class="text-gray-500 text-sm">Belum ada arsip yang ditambahkan.</p>
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($riwayat_arsip as $arsip): ?>
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                                    <h3 class="font-bold text-gray-900 text-lg"><?= htmlspecialchars($arsip['judul']) ?></h3>
                                    <div class="flex items-center gap-2">
                                        <a href="<?= htmlspecialchars($arsip['link_gdrive']) ?>" target="_blank" class="inline-flex items-center gap-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider transition">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">link</span>
                                            Buka Drive
                                        </a>
                                        <a href="admin_arsip.php?delete=<?= $arsip['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus arsip ini?')" class="inline-flex items-center gap-1.5 bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider transition">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">delete</span>
                                        </a>
                                    </div>
                                </div>
                                <?php if (!empty($arsip['keterangan'])): ?>
                                    <p class="text-gray-600 text-sm mb-3">
                                        <?= nl2br(htmlspecialchars($arsip['keterangan'])) ?>
                                    </p>
                                <?php endif; ?>
                                <div class="flex flex-wrap items-center justify-between gap-4 mt-2">
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">event_note</span>
                                        Tanggal Arsip: <?= !empty($arsip['tanggal_arsip']) ? date('d M Y', strtotime($arsip['tanggal_arsip'])) : '-' ?>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                                        Diupload: <?= date('d M Y, H:i', strtotime($arsip['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
