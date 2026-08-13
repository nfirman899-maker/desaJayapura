<?php require_once 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Surat Online</h1>
            <p class="text-gray-600">Terima dan tanggapi permohonan surat dari warga desa.</p>
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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 text-sm">
                        <th class="py-4 px-6">Informasi Pemohon</th>
                        <th class="py-4 px-6">Jenis Surat & Keterangan</th>
                        <th class="py-4 px-6">Tanggal Pengajuan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($semua_surat)): ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada permohonan surat yang masuk.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($semua_surat as $surat): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-900"><?= htmlspecialchars($surat['full_name']) ?></div>
                                <div class="text-sm text-gray-700 mt-1">
                                    <span class="text-gray-500">NIK (Akun):</span> <?= htmlspecialchars($surat['username']) ?><br>
                                    <span class="text-gray-500">NIK (KTP):</span> <span class="font-semibold text-gray-900"><?= htmlspecialchars($surat['nik'] ?? '-') ?></span>
                                    <?php if(!empty($surat['alamat'])): ?>
                                        <div class="text-xs text-gray-600 mt-1">Alamat: <?= htmlspecialchars($surat['alamat']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($surat['phone']): ?>
                                    <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">call</span>
                                        <?= htmlspecialchars($surat['phone']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6">
                                <div class="inline-block px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-semibold mb-2">
                                    <?= htmlspecialchars($surat['jenis_surat']) ?>
                                </div>
                                <div class="text-sm text-gray-600 line-clamp-2 max-w-sm">
                                    <?= nl2br(htmlspecialchars($surat['keterangan'])) ?>
                                </div>
                                <?php if (!empty($surat['lampiran'])): ?>
                                <div class="mt-2">
                                    <a href="<?= htmlspecialchars($surat['lampiran']) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded-md transition border border-blue-200">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">attachment</span>
                                        Cek File KTP/KK
                                    </a>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap">
                                <?= date('d M Y, H:i', strtotime($surat['tanggal_pengajuan'])) ?>
                            </td>
                            <td class="py-4 px-6">
                                <?php 
                                    $status_color = 'bg-gray-100 text-gray-700'; 
                                    if ($surat['status'] == 'Diproses') $status_color = 'bg-yellow-100 text-yellow-800';
                                    if ($surat['status'] == 'Selesai') $status_color = 'bg-green-100 text-green-800';
                                    if ($surat['status'] == 'Ditolak') $status_color = 'bg-red-100 text-red-800';
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $status_color ?>">
                                    <?= htmlspecialchars($surat['status']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <form action="admin_surat.php" method="POST" class="inline-flex flex-col gap-2 min-w-[120px]">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $surat['id'] ?>">
                                    <select name="status" class="px-2 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 outline-none w-full bg-white">
                                        <option value="Menunggu" <?= $surat['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="Diproses" <?= $surat['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                        <option value="Selesai" <?= $surat['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="Ditolak" <?= $surat['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                    <div class="flex justify-end gap-1">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-medium hover:bg-green-700 transition w-full">Update</button>
                                        <a href="admin_surat.php?delete=<?= $surat['id'] ?>" onclick="return confirm('Hapus permohonan ini?')" class="bg-red-50 text-red-600 px-3 py-1 rounded text-xs font-medium hover:bg-red-100 transition border border-red-200 flex items-center justify-center">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">delete</span>
                                        </a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
