<?php require_once 'includes/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Arsip Surat Desa</h1>
        <p class="text-gray-600 mt-2">Arsip otomatis dokumen persuratan berdasarkan permohonan warga di Layanan Surat Online.</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-gray-200 mb-8">
        <a href="admin_arsip_surat.php?tab=masuk" class="<?= $tab === 'masuk' ? 'border-green-800 text-green-800 font-bold border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> px-6 py-3 whitespace-nowrap uppercase tracking-wider text-sm transition">
            Surat Masuk (Antrean)
        </a>
        <a href="admin_arsip_surat.php?tab=keluar" class="<?= $tab === 'keluar' ? 'border-green-800 text-green-800 font-bold border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> px-6 py-3 whitespace-nowrap uppercase tracking-wider text-sm transition">
            Surat Keluar (Selesai)
        </a>
    </div>

    <div class="flex flex-col gap-10 max-w-5xl mx-auto">
        <!-- Daftar Arsip -->
        <div class="w-full">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-lg font-bold text-gray-900">
                            <?= $tab === 'masuk' ? 'Arsip Surat Masuk (Belum Selesai)' : 'Arsip Surat Keluar (Sudah Selesai)' ?>
                        </h2>
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                            Total: <?= count($riwayat_arsip) ?>
                        </span>
                    </div>
                    
                    <form method="GET" action="admin_arsip_surat.php" class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="hidden" name="tab" value="<?= $tab ?>">
                        <input type="date" name="tanggal_pengajuan" value="<?= htmlspecialchars($filter_tanggal ?? '') ?>" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-green-800 text-gray-700 text-sm w-full sm:w-auto bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
                        <?php if (!empty($filter_tanggal)): ?>
                            <a href="admin_arsip_surat.php?tab=<?= $tab ?>" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-sm font-medium">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>

                <?php if (empty($riwayat_arsip)): ?>
                    <div class="p-12 text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-gray-300 text-3xl">inbox</span>
                        </div>
                        <p class="text-gray-500 text-sm">Tidak ada riwayat <?= $tab === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' ?>.</p>
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($riwayat_arsip as $arsip): ?>
                            <?php 
                                // Set warna badge sesuai status
                                $status_color = 'bg-gray-100 text-gray-700'; // default Menunggu
                                if ($arsip['status'] == 'Diproses') $status_color = 'bg-yellow-100 text-yellow-800';
                                if ($arsip['status'] == 'Selesai') $status_color = 'bg-green-100 text-green-800';
                                if ($arsip['status'] == 'Ditolak') $status_color = 'bg-red-100 text-red-800';
                                
                                // Set icon sesuai status
                                $status_icon = 'schedule'; // default Menunggu
                                if ($arsip['status'] == 'Diproses') $status_icon = 'autorenew';
                                if ($arsip['status'] == 'Selesai') $status_icon = 'check_circle';
                                if ($arsip['status'] == 'Ditolak') $status_icon = 'cancel';
                            ?>
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg"><?= htmlspecialchars($arsip['jenis_surat']) ?></h3>
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 <?= $status_color ?> px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider self-start sm:self-auto">
                                        <span class="material-symbols-outlined" style="font-size: 14px;"><?= $status_icon ?></span>
                                        <?= htmlspecialchars($arsip['status']) ?>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pemohon</p>
                                        <p class="text-sm font-semibold text-gray-800"><?= htmlspecialchars($arsip['full_name']) ?></p>
                                        <p class="text-xs text-gray-600">No. HP/WA: <?= htmlspecialchars($arsip['phone'] ?? '-') ?></p>
                                        <?php if(!empty($arsip['nik'])): ?>
                                            <p class="text-xs text-gray-600">NIK: <?= htmlspecialchars($arsip['nik']) ?></p>
                                        <?php endif; ?>
                                        <?php if(!empty($arsip['alamat'])): ?>
                                            <p class="text-xs text-gray-600 mt-1">Alamat: <?= htmlspecialchars($arsip['alamat']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Keterangan / Keperluan</p>
                                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded border border-gray-100">
                                            <?= nl2br(htmlspecialchars($arsip['keterangan'])) ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap items-center justify-between gap-4 mt-4 border-t border-gray-100 pt-4">
                                    <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                                        Diajukan: <?= date('d M Y, H:i', strtotime($arsip['tanggal_pengajuan'])) ?>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <?php if (!empty($arsip['lampiran'])): ?>
                                        <a href="<?= htmlspecialchars($arsip['lampiran']) ?>" target="_blank" class="inline-flex items-center gap-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider transition">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">attachment</span>
                                            Lihat Lampiran
                                        </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($arsip['status'] == 'Selesai'): ?>
                                        <a href="cetak_surat.php?id=<?= $arsip['id'] ?>" target="_blank" class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-full text-xs font-medium transition shadow-sm">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">print</span>
                                            Cetak Surat
                                        </a>
                                        <?php endif; ?>
                                        
                                        <a href="admin_surat.php" class="inline-flex items-center gap-1.5 bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded-full text-xs font-medium transition shadow-sm">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">manage_search</span>
                                            Kelola di Surat Online
                                        </a>
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
