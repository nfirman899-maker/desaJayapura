<?php require_once 'includes/header.php'; ?>

<style>
    .table-peraturan {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px; /* Force scroll horizontal on small screens */
    }
    .table-peraturan th, .table-peraturan td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
    }
    .table-peraturan th {
        background-color: #f3f4f6;
        font-weight: 600;
    }
    .table-peraturan td:nth-child(3), .table-peraturan td:nth-child(4) {
        text-align: left; /* Tentang & Uraian Singkat biasanya panjang */
    }
    .table-peraturan tr:nth-child(even) {
        background-color: #f9fafb;
    }
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
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-green-800">Buku Data Peraturan Desa</h1>
            <p class="text-gray-600 mt-2">Kelola data peraturan desa sesuai format Model A.1</p>
        </div>
        <div class="text-right">
            <span class="text-sm font-bold text-gray-500 uppercase">Model A.1</span>
        </div>
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

    <!-- Formulir Input -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-10 overflow-hidden">
        <div class="bg-green-800 px-6 py-4">
            <h2 class="text-white font-bold text-lg">Formulir Tambah Peraturan Desa</h2>
        </div>
        <div class="p-6">
            <form action="admin_peraturan.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="form-group col-span-1 md:col-span-1">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="<?= date('Y') ?>" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label>No & Tgl Peraturan Desa</label>
                        <textarea name="no_tgl_peraturan" rows="3" placeholder="Contoh: 1 Tahun 2018&#10;04 September 2018" required></textarea>
                        <p class="text-[10px] text-gray-500 mt-1">Gunakan enter (baris baru) untuk memisahkan Nomor dan Tanggal.</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Tentang</label>
                        <textarea name="tentang" rows="3" placeholder="Contoh: Rencana Kerja Pembangunan Desa T.A 2019" required></textarea>
                    </div>
                </div>

                <div class="form-group mb-6">
                    <label>Uraian Singkat</label>
                    <textarea name="uraian_singkat" rows="4" placeholder="Uraian singkat tentang peraturan desa tersebut..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="form-group">
                        <label>No & Tgl Persetujuan BPD</label>
                        <textarea name="no_tgl_persetujuan" rows="2" placeholder="Contoh: 04 September 2018"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>No & Tgl Dilaporkan</label>
                        <textarea name="no_tgl_dilaporkan" rows="2" placeholder="Contoh: 06 September 2018"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-green-800 hover:bg-green-900 text-white font-bold py-3 px-8 rounded-md transition uppercase text-sm tracking-wider">
                        Simpan Data Peraturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-gray-900 text-center w-full sm:w-auto">
                BUKU DATA PERATURAN DESA JAYAPURA TAHUN <?= htmlspecialchars($filter_tahun) ?>
            </h2>
            <form method="GET" action="admin_peraturan.php" class="flex gap-2 w-full sm:w-auto">
                <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md bg-white">
                    <?php foreach ($list_tahun as $thn): ?>
                        <option value="<?= $thn ?>" <?= $thn == $filter_tahun ? 'selected' : '' ?>><?= $thn ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md transition">Filter</button>
                <a href="cetak_peraturan.php?tahun=<?= $filter_tahun ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
                    Cetak
                </a>
            </form>
        </div>

        <div class="overflow-x-auto p-4">
            <table class="table-peraturan">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th style="width: 150px;">No & Tgl Peraturan<br>Desa</th>
                        <th style="width: 200px;">Tentang</th>
                        <th>Uraian Singkat</th>
                        <th style="width: 120px;">No & Tgl Persetujuan BPD</th>
                        <th style="width: 120px;">No & Tgl Dilaporkan</th>
                        <th style="width: 120px;">Keterangan</th>
                        <th style="width: 70px;">Aksi</th>
                    </tr>
                    <tr style="background-color: #e5e7eb; font-size: 11px;">
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peraturan_list)): ?>
                        <tr>
                            <td colspan="8" style="padding: 30px 0; text-align: center; color: #6b7280;">
                                Belum ada data peraturan untuk tahun <?= htmlspecialchars($filter_tahun) ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($peraturan_list as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= nl2br(htmlspecialchars($row['no_tgl_peraturan'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['tentang'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['uraian_singkat'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['no_tgl_persetujuan'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['no_tgl_dilaporkan'])) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['keterangan'])) ?></td>
                                <td>
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="admin_peraturan_edit.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-900 px-1" title="Edit Data">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                        </a>
                                        <a href="admin_peraturan.php?delete=<?= $row['id'] ?>&tahun=<?= $filter_tahun ?>" onclick="return confirm('Hapus data peraturan ini?')" class="text-red-600 hover:text-red-900 px-1" title="Hapus Data">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
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

<?php require_once 'includes/footer.php'; ?>
