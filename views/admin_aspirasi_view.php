<?php require_once 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Aspirasi Warga</h1>
            <p class="text-gray-600">Terima, baca, dan tanggapi saran serta keluhan dari warga.</p>
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
                        <th class="py-4 px-6">Pengirim</th>
                        <th class="py-4 px-6 w-2/5">Judul & Pesan Aspirasi</th>
                        <th class="py-4 px-6">Tanggal Masuk</th>
                        <th class="py-4 px-6">Status & Tanggapan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($semua_aspirasi)): ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada aspirasi yang masuk.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($semua_aspirasi as $item): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 align-top">
                                <div class="font-bold text-gray-900"><?= htmlspecialchars($item['full_name']) ?></div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="font-medium text-gray-700">NIK:</span> <?= htmlspecialchars($item['username']) ?>
                                </div>
                                <?php if ($item['phone']): ?>
                                    <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">call</span>
                                        <?= htmlspecialchars($item['phone']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 align-top">
                                <div class="inline-block px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                                    <?= htmlspecialchars($item['kategori']) ?>
                                </div>
                                <div class="font-bold text-gray-800 text-sm mb-1"><?= htmlspecialchars($item['judul']) ?></div>
                                <div class="text-sm text-gray-600 mb-2">
                                    <?= nl2br(htmlspecialchars($item['pesan'])) ?>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap align-top">
                                <?= date('d M Y, H:i', strtotime($item['tanggal_kirim'])) ?>
                            </td>
                            <td class="py-4 px-6 align-top">
                                <?php 
                                    $status_color = 'bg-gray-100 text-gray-700'; 
                                    if ($item['status'] == 'Diproses') $status_color = 'bg-yellow-100 text-yellow-800';
                                    if ($item['status'] == 'Selesai') $status_color = 'bg-green-100 text-green-800';
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold mb-3 <?= $status_color ?>">
                                    <?= htmlspecialchars($item['status']) ?>
                                </span>
                                
                                <?php if($item['tanggapan']): ?>
                                    <div class="text-xs text-gray-500 mt-2">
                                        <strong class="block text-gray-700 mb-1">Tanggapan:</strong>
                                        <?= nl2br(htmlspecialchars($item['tanggapan'])) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-xs text-gray-400 italic mt-2">Belum ada tanggapan.</div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-right align-top">
                                <button onclick="document.getElementById('modal-<?= $item['id'] ?>').classList.remove('hidden')" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded text-xs font-medium hover:bg-blue-100 transition border border-blue-200 mb-2 w-full flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">reply</span> Tanggapi
                                </button>
                                <a href="admin_aspirasi.php?delete=<?= $item['id'] ?>" onclick="return confirm('Hapus aspirasi ini secara permanen?')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded text-xs font-medium hover:bg-red-100 transition border border-red-200 flex items-center justify-center gap-1 w-full">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">delete</span> Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Tanggapi -->
                        <div id="modal-<?= $item['id'] ?>" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 px-4">
                            <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
                                <button onclick="document.getElementById('modal-<?= $item['id'] ?>').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                                
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Beri Tanggapan untuk Aspirasi</h3>
                                
                                <div class="mb-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <div class="font-bold text-sm mb-1"><?= htmlspecialchars($item['judul']) ?></div>
                                    <div class="text-sm text-gray-600">"<?= htmlspecialchars($item['pesan']) ?>"</div>
                                    <div class="text-xs text-gray-400 mt-2">- <?= htmlspecialchars($item['full_name']) ?></div>
                                </div>

                                <form action="admin_aspirasi.php" method="POST">
                                    <input type="hidden" name="action" value="tanggapi">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Aspirasi</label>
                                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 outline-none">
                                            <option value="Menunggu" <?= $item['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                            <option value="Diproses" <?= $item['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses / Sedang ditindaklanjuti</option>
                                            <option value="Selesai" <?= $item['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Tanggapan / Balasan</label>
                                        <textarea name="tanggapan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 outline-none resize-none" placeholder="Tuliskan jawaban atau status tindak lanjut dari desa..."><?= htmlspecialchars($item['tanggapan'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('modal-<?= $item['id'] ?>').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition text-sm">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition text-sm">Simpan Tanggapan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
