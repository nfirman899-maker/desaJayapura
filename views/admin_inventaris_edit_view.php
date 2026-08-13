<?php require_once 'includes/header.php'; ?>

<style>
    .form-group label {
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        color: #4b5563;
        margin-bottom: 4px;
        display: block;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 14px;
    }
    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #166534;
        margin-bottom: 10px;
        border-bottom: 2px solid #166534;
        padding-bottom: 4px;
    }
</style>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Edit Buku Data Inventaris</h1>
        <p class="text-gray-600 mt-2">Perbarui data inventaris desa</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-6">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulir Input -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-10 overflow-hidden">
        <div class="bg-blue-800 px-6 py-4">
            <h2 class="text-white font-bold text-lg">Formulir Edit Inventaris</h2>
        </div>
        <div class="p-6">
            <form action="admin_inventaris_edit.php?id=<?= $inv['id'] ?>" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="form-group col-span-1 md:col-span-1">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="<?= htmlspecialchars($inv['tahun']) ?>" required>
                    </div>
                    <div class="form-group col-span-1 md:col-span-3">
                        <label>Jenis Barang / Bangunan</label>
                        <input type="text" name="jenis_barang" value="<?= htmlspecialchars($inv['jenis_barang']) ?>" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kiri -->
                    <div class="space-y-6">
                        <div>
                            <div class="form-section-title">Asal Barang / Bangunan (Jumlah)</div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="form-group">
                                    <label>Dibeli Sendiri</label>
                                    <input type="number" name="asal_sendiri" value="<?= htmlspecialchars($inv['asal_sendiri']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Pemerintah</label>
                                    <input type="number" name="asal_pemerintah" value="<?= htmlspecialchars($inv['asal_pemerintah']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Bantuan Prov</label>
                                    <input type="number" name="asal_bantuan_prov" value="<?= htmlspecialchars($inv['asal_bantuan_prov']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Bantuan Kab</label>
                                    <input type="number" name="asal_bantuan_kab" value="<?= htmlspecialchars($inv['asal_bantuan_kab']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Sumbangan</label>
                                    <input type="number" name="asal_sumbangan" value="<?= htmlspecialchars($inv['asal_sumbangan']) ?>" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-section-title">Keadaan Awal Tahun (Jumlah)</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label>Baik</label>
                                    <input type="number" name="awal_baik" value="<?= htmlspecialchars($inv['awal_baik']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Rusak</label>
                                    <input type="number" name="awal_rusak" value="<?= htmlspecialchars($inv['awal_rusak']) ?>" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan -->
                    <div class="space-y-6">
                        <div>
                            <div class="form-section-title">Penghapusan (Jumlah & Tanggal)</div>
                            <div class="grid grid-cols-4 gap-4">
                                <div class="form-group">
                                    <label>Rusak</label>
                                    <input type="number" name="hapus_rusak" value="<?= htmlspecialchars($inv['hapus_rusak']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Dijual</label>
                                    <input type="number" name="hapus_dijual" value="<?= htmlspecialchars($inv['hapus_dijual']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Disumbang</label>
                                    <input type="number" name="hapus_disumbangkan" value="<?= htmlspecialchars($inv['hapus_disumbangkan']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Tgl Hapus</label>
                                    <input type="date" name="hapus_tanggal" value="<?= htmlspecialchars($inv['hapus_tanggal'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="form-section-title">Keadaan Akhir Tahun (Jumlah)</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label>Baik</label>
                                    <input type="number" name="akhir_baik" value="<?= htmlspecialchars($inv['akhir_baik']) ?>" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Rusak</label>
                                    <input type="number" name="akhir_rusak" value="<?= htmlspecialchars($inv['akhir_rusak']) ?>" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="form-group">
                        <label>Keterangan Tambahan</label>
                        <input type="text" name="keterangan" value="<?= htmlspecialchars($inv['keterangan']) ?>" placeholder="Contoh: 1 buah, 2 unit, dll...">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="admin_inventaris.php?tahun=<?= $inv['tahun'] ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-md transition uppercase text-sm tracking-wider">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-3 px-8 rounded-md transition uppercase text-sm tracking-wider">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
