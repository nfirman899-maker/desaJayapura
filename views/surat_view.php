<?php require_once 'includes/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Layanan Surat Online</h1>
        <p class="text-gray-600 mt-2">Ajukan permohonan surat pengantar, keterangan, dan dokumen desa lainnya secara mudah dari rumah.</p>
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
                    <p class="text-[11px] sm:text-xs text-gray-600 mt-2 font-medium">FORMULIR LAYANAN ADMINISTRASI KEPENDUDUKAN ELEKTRONIK</p>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6 text-xs sm:text-sm text-blue-900">
                    <strong>PERHATIAN:</strong> Isilah formulir di bawah ini dengan data yang sebenar-benarnya sesuai dengan dokumen kependudukan yang sah (KTP/KK).
                </div>

                <form action="surat.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Nama Lengkap Pemohon</label>
                            <input type="text" value="<?= htmlspecialchars($current_user['full_name'] ?? '') ?>" readonly class="w-full px-4 py-2 border border-gray-400 rounded-sm bg-gray-100 text-gray-800 text-sm font-semibold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Nomor Kontak (WhatsApp)</label>
                            <input type="text" value="<?= htmlspecialchars($current_user['phone'] ?? '') ?>" readonly class="w-full px-4 py-2 border border-gray-400 rounded-sm bg-gray-100 text-gray-800 text-sm font-semibold cursor-not-allowed">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" required pattern="[0-9]{16}" placeholder="Masukkan 16 digit NIK..." class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white font-medium">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Upload Foto KTP/KK (Bila Perlu)</label>
                            <input type="file" name="lampiran" accept="image/*,.pdf" class="w-full px-4 py-1.5 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat" rows="2" required placeholder="Masukkan alamat lengkap (RT/RW, Dusun)..." class="w-full px-4 py-3 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white resize-none font-medium"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Jenis Dokumen / Surat</label>
                            <select name="jenis_surat" required class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                                <option value="">-- Pilih Dokumen --</option>
                                <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                                <option value="Surat Pengantar KK">Surat Pengantar Pembuatan KK</option>
                                <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                                <option value="Surat Keterangan Usaha">Surat Keterangan Usaha (SKU)</option>
                                <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                                <option value="Lainnya">Lainnya (Jelaskan di Keterangan)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" required class="w-full px-4 py-2 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white cursor-pointer font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1.5 uppercase tracking-wider">Keterangan / Keperluan Detail</label>
                        <textarea name="keterangan" rows="4" required placeholder="Tuliskan keperluan Anda secara detail dan jelas..." class="w-full px-4 py-3 border border-gray-400 rounded-sm focus:outline-none focus:ring-1 focus:ring-green-800 focus:border-green-800 text-gray-900 text-sm bg-white resize-none font-medium"></textarea>
                    </div>

                    <div class="pt-5 mt-6 border-t border-gray-200">
                        <button type="submit" class="w-full bg-green-800 hover:bg-green-900 text-white font-bold py-3 px-4 rounded-sm transition flex justify-center items-center gap-2 uppercase tracking-widest text-xs shadow-md">
                            <span class="material-symbols-outlined" style="font-size: 18px;">send</span>
                            Kirim Permohonan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Pengajuan -->
        <div class="w-full">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Pengajuan Surat</h2>
                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                        Total: <?= count($riwayat_surat) ?> Surat
                    </span>
                </div>

                <?php if (empty($riwayat_surat)): ?>
                    <div class="p-12 text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-gray-300 text-3xl">inbox</span>
                        </div>
                        <p class="text-gray-500 text-sm">Anda belum pernah mengajukan permohonan surat apapun.</p>
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($riwayat_surat as $surat): ?>
                            <?php 
                                // Set warna badge sesuai status
                                $status_color = 'bg-gray-100 text-gray-700'; // default Menunggu
                                if ($surat['status'] == 'Diproses') $status_color = 'bg-yellow-100 text-yellow-800';
                                if ($surat['status'] == 'Selesai') $status_color = 'bg-green-100 text-green-800';
                                if ($surat['status'] == 'Ditolak') $status_color = 'bg-red-100 text-red-800';
                                
                                // Set icon sesuai status
                                $status_icon = 'schedule'; // default Menunggu
                                if ($surat['status'] == 'Diproses') $status_icon = 'autorenew';
                                if ($surat['status'] == 'Selesai') $status_icon = 'check_circle';
                                if ($surat['status'] == 'Ditolak') $status_icon = 'cancel';
                            ?>
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                                    <h3 class="font-bold text-gray-900 text-lg"><?= htmlspecialchars($surat['jenis_surat']) ?></h3>
                                    <div class="inline-flex items-center gap-1.5 <?= $status_color ?> px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider self-start sm:self-auto">
                                        <span class="material-symbols-outlined" style="font-size: 14px;"><?= $status_icon ?></span>
                                        <?= htmlspecialchars($surat['status']) ?>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">
                                    <?= nl2br(htmlspecialchars($surat['keterangan'])) ?>
                                </p>
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                                        Diajukan pada: <?= date('d M Y, H:i', strtotime($surat['tanggal_pengajuan'])) ?> WIB
                                    </div>
                                    <?php if ($surat['status'] == 'Selesai'): ?>
                                    <a href="cetak_surat.php?id=<?= $surat['id'] ?>" target="_blank" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">print</span>
                                        Cetak Surat
                                    </a>
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
