<?php require_once 'includes/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Ruang Aspirasi & Pengaduan</h1>
        <p class="text-gray-600 mt-2">Sampaikan keluhan, saran, maupun aspirasi Anda untuk kemajuan Desa Jayapura.</p>
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
                    <p class="text-[11px] sm:text-xs text-gray-600 mt-2 font-medium">FORMULIR PENYAMPAIAN ASPIRASI DAN PENGADUAN MASYARAKAT</p>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6 text-xs sm:text-sm text-blue-900">
                    <strong>PERHATIAN:</strong> Sampaikan aspirasi, keluhan, atau saran Anda dengan bahasa yang sopan dan jelas untuk kemajuan bersama.
                </div>

                <div class="flex items-center justify-center mb-4">
                    <h2 class="text-sm font-bold text-green-800 border-b-2 border-green-800 pb-1 uppercase tracking-wider"><?= isset($edit_data) ? 'Edit Data Aspirasi' : 'Buat Aspirasi Baru' ?></h2>
                </div>

                <form action="aspirasi.php" method="POST" class="space-y-5">
                    <?php if(isset($edit_data)): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Judul Aspirasi</label>
                        <input type="text" name="judul" required placeholder="Contoh: Perbaikan Jalan Desa..." value="<?= htmlspecialchars($edit_data['judul'] ?? '') ?>" class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white font-medium">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Tanggal Kirim</label>
                            <input type="date" name="tanggal_kirim" required value="<?= htmlspecialchars(isset($edit_data['tanggal_kirim']) ? date('Y-m-d', strtotime($edit_data['tanggal_kirim'])) : '') ?>" class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Kategori</label>
                            <select name="kategori" required class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                $cats = ['Infrastruktur & Pembangunan', 'Pelayanan Masyarakat', 'Keamanan & Ketertiban', 'Kebersihan & Lingkungan', 'Lainnya'];
                                $current_cat = $edit_data['kategori'] ?? '';
                                foreach($cats as $c): 
                                ?>
                                    <option value="<?= $c ?>" <?= $current_cat == $c ? 'selected' : '' ?>><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Pesan / Saran / Keluhan</label>
                        <textarea name="pesan" rows="5" required placeholder="Sampaikan detail aspirasi Anda di sini..." class="w-full px-4 py-3 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white resize-none font-medium"><?= htmlspecialchars($edit_data['pesan'] ?? '') ?></textarea>
                    </div>

                    <div class="pt-5 mt-6 border-t border-gray-200">
                        <button type="submit" class="w-full bg-green-800 hover:bg-green-900 text-white font-bold py-3 px-4 rounded-sm transition flex justify-center items-center gap-2 uppercase tracking-widest text-xs shadow-md">
                            <span class="material-symbols-outlined" style="font-size: 18px;"><?= isset($edit_data) ? 'save' : 'send' ?></span>
                            <?= isset($edit_data) ? 'Simpan Perubahan' : 'Kirim Aspirasi' ?>
                        </button>
                        <?php if(isset($edit_data)): ?>
                            <a href="aspirasi.php" class="mt-3 w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-sm transition flex justify-center items-center gap-2 uppercase tracking-widest text-xs shadow-sm">
                                Batal Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Pengajuan -->
        <div class="w-full">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Aspirasi Anda</h2>
                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                        Total: <?= count($riwayat_aspirasi) ?>
                    </span>
                </div>

                <?php if (empty($riwayat_aspirasi)): ?>
                    <div class="p-12 text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-gray-300 text-3xl">inbox</span>
                        </div>
                        <p class="text-gray-500 text-sm">Anda belum mengirimkan aspirasi apa pun.</p>
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($riwayat_aspirasi as $item): ?>
                            <?php 
                                // Set warna badge sesuai status
                                $status_color = 'bg-gray-100 text-gray-700'; // default Menunggu
                                if ($item['status'] == 'Diproses') $status_color = 'bg-yellow-100 text-yellow-800';
                                if ($item['status'] == 'Selesai') $status_color = 'bg-green-100 text-green-800';
                            ?>
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                                    <h3 class="font-bold text-gray-900 text-lg"><?= htmlspecialchars($item['judul']) ?></h3>
                                    <div class="inline-flex items-center gap-1.5 <?= $status_color ?> px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider self-start sm:self-auto">
                                        <?= htmlspecialchars($item['status']) ?>
                                    </div>
                                </div>
                                <div class="text-xs text-blue-600 font-medium mb-3"><?= htmlspecialchars($item['kategori']) ?></div>
                                <p class="text-gray-600 text-sm mb-3">
                                    <?= nl2br(htmlspecialchars($item['pesan'])) ?>
                                </p>
                                
                                <?php if($item['tanggapan']): ?>
                                <div class="bg-gray-100 p-4 rounded-xl border-l-4 border-green-500 mt-4">
                                    <p class="text-xs font-bold text-gray-500 mb-1">Tanggapan Admin Desa:</p>
                                    <p class="text-sm text-gray-800"><?= nl2br(htmlspecialchars($item['tanggapan'])) ?></p>
                                </div>
                                <?php endif; ?>

                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                                        Dikirim pada: <?= date('d M Y, H:i', strtotime($item['tanggal_kirim'])) ?> WIB
                                    </div>
                                    
                                    <?php if ($item['status'] == 'Menunggu'): ?>
                                    <div class="flex items-center gap-2">
                                        <a href="aspirasi.php?edit=<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-2 py-1 rounded text-xs font-semibold transition flex items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">edit</span> Edit
                                        </a>
                                        <a href="aspirasi.php?delete=<?= $item['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini?')" class="text-red-600 hover:text-red-800 bg-red-50 px-2 py-1 rounded text-xs font-semibold transition flex items-center gap-1">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">delete</span> Hapus
                                        </a>
                                    </div>
                                    <?php endif; ?>
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
