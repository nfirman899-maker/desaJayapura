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
    .form-group input, .form-group select, .form-group textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 14px;
    }
</style>

<div class="max-w-[1400px] mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">Edit Buku Data Peraturan Desa</h1>
        <p class="text-gray-600 mt-2">Perbarui data peraturan desa Model A.1</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-6">
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulir Input -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-10 overflow-hidden">
        <div class="bg-blue-800 px-6 py-4">
            <h2 class="text-white font-bold text-lg">Formulir Edit Peraturan Desa</h2>
        </div>
        <div class="p-6">
            <form action="admin_peraturan_edit.php?id=<?= $row['id'] ?>" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="form-group col-span-1 md:col-span-1">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="<?= htmlspecialchars($row['tahun']) ?>" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label>No & Tgl Peraturan Desa</label>
                        <textarea name="no_tgl_peraturan" rows="3" required><?= htmlspecialchars($row['no_tgl_peraturan']) ?></textarea>
                        <p class="text-[10px] text-gray-500 mt-1">Gunakan enter (baris baru) untuk memisahkan Nomor dan Tanggal.</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Tentang</label>
                        <textarea name="tentang" rows="3" required><?= htmlspecialchars($row['tentang']) ?></textarea>
                    </div>
                </div>

                <div class="form-group mb-6">
                    <label>Uraian Singkat</label>
                    <textarea name="uraian_singkat" rows="4"><?= htmlspecialchars($row['uraian_singkat']) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="form-group">
                        <label>No & Tgl Persetujuan BPD</label>
                        <textarea name="no_tgl_persetujuan" rows="2"><?= htmlspecialchars($row['no_tgl_persetujuan']) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>No & Tgl Dilaporkan</label>
                        <textarea name="no_tgl_dilaporkan" rows="2"><?= htmlspecialchars($row['no_tgl_dilaporkan']) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2"><?= htmlspecialchars($row['keterangan']) ?></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="admin_peraturan.php?tahun=<?= $row['tahun'] ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-md transition uppercase text-sm tracking-wider">
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
