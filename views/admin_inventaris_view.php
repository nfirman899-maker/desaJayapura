<?php require_once 'includes/header.php'; ?>

<style>
    /* Styling khusus untuk tabel kompleks agar terlihat rapi */
    .table-inventaris {
        width: 100%;
        border-collapse: collapse;
        min-width: 1500px; /* Force scroll horizontal */
    }
    .table-inventaris th, .table-inventaris td {
        border: 1px solid #000;
        padding: 8px 4px;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
    }
    .table-inventaris th {
        background-color: #f3f4f6;
        font-weight: 600;
    }
    .table-inventaris td:nth-child(2) {
        text-align: left;
        padding-left: 8px;
    }
    .table-inventaris tr:nth-child(even) {
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
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-green-800">Buku Data Inventaris Desa</h1>
            <p class="text-gray-600 mt-2">Kelola data inventaris desa sesuai format Model A.3</p>
        </div>
        <div class="text-right">
            <span class="text-sm font-bold text-gray-500 uppercase">Model A.3</span>
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
            <h2 class="text-white font-bold text-lg">Formulir Tambah Inventaris</h2>
        </div>
        <div class="p-6">
            <form action="admin_inventaris.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="form-group col-span-1 md:col-span-1">
                        <label>Tahun Buku</label>
                        <input type="number" name="tahun" value="<?= date('Y') ?>" required>
                    </div>
                    <div class="form-group col-span-1 md:col-span-3">
                        <label>Jenis Barang / Bangunan</label>
                        <input type="text" name="jenis_barang" placeholder="Contoh: Gedung Kantor, Meja, Kursi..." required>
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
                                    <input type="number" name="asal_sendiri" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Pemerintah</label>
                                    <input type="number" name="asal_pemerintah" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Bantuan Prov</label>
                                    <input type="number" name="asal_bantuan_prov" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Bantuan Kab</label>
                                    <input type="number" name="asal_bantuan_kab" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Sumbangan</label>
                                    <input type="number" name="asal_sumbangan" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="form-section-title">Keadaan Awal Tahun (Jumlah)</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label>Baik</label>
                                    <input type="number" name="awal_baik" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Rusak</label>
                                    <input type="number" name="awal_rusak" value="0" min="0">
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
                                    <input type="number" name="hapus_rusak" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Dijual</label>
                                    <input type="number" name="hapus_dijual" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Disumbang</label>
                                    <input type="number" name="hapus_disumbangkan" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Tgl Hapus</label>
                                    <input type="date" name="hapus_tanggal">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="form-section-title">Keadaan Akhir Tahun (Jumlah)</div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label>Baik</label>
                                    <input type="number" name="akhir_baik" value="0" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Rusak</label>
                                    <input type="number" name="akhir_rusak" value="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="form-group">
                        <label>Keterangan Tambahan</label>
                        <input type="text" name="keterangan" placeholder="Contoh: 1 buah, 2 unit, dll...">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-green-800 hover:bg-green-900 text-white font-bold py-3 px-8 rounded-md transition uppercase text-sm tracking-wider">
                        Simpan Data Inventaris
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Inventaris -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-bold text-gray-900 text-center w-full sm:w-auto">
                BUKU DATA INVENTARIS DESA JAYAPURA TAHUN <?= htmlspecialchars($filter_tahun) ?>
            </h2>
            <form method="GET" action="admin_inventaris.php" class="flex gap-2 w-full sm:w-auto">
                <select name="tahun" class="px-4 py-2 border border-gray-300 rounded-md bg-white">
                    <?php foreach ($list_tahun as $thn): ?>
                        <option value="<?= $thn ?>" <?= $thn == $filter_tahun ? 'selected' : '' ?>><?= $thn ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md transition">Filter</button>
                <a href="cetak_inventaris.php?tahun=<?= $filter_tahun ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
                    Cetak
                </a>
            </form>
        </div>

        <div class="overflow-x-auto p-4">
            <table class="table-inventaris">
                <thead>
                    <tr>
                        <th rowspan="3" style="width: 40px;">No</th>
                        <th rowspan="3" style="width: 250px;">Jenis Barang/<br>bangunan</th>
                        <th colspan="5">Asal Barang/Bangunan</th>
                        <th colspan="2">Keadaan Barang/Bangunan<br>di Awal Tahun</th>
                        <th colspan="4">Penghapusan</th>
                        <th colspan="2">Keadaan Barang/Bangunan<br>Akhir Tahun</th>
                        <th rowspan="3" style="width: 150px;">Ket</th>
                        <th rowspan="3" style="width: 60px;">Aksi</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Dibeli<br>Sendiri</th>
                        <th rowspan="2">Pemerintah</th>
                        <th colspan="2">Bantuan</th>
                        <th rowspan="2">Sumbangan</th>
                        
                        <th rowspan="2">Baik</th>
                        <th rowspan="2">Rusak</th>
                        
                        <th rowspan="2">Rusak</th>
                        <th rowspan="2">Dijual</th>
                        <th rowspan="2">Disumbangkan</th>
                        <th rowspan="2">Tgl<br>Penghapusan</th>
                        
                        <th rowspan="2">Baik</th>
                        <th rowspan="2">Rusak</th>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                    </tr>
                    <tr style="background-color: #e5e7eb; font-size: 11px;">
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inventaris)): ?>
                        <tr>
                            <td colspan="17" style="padding: 30px 0; text-align: center; color: #6b7280;">
                                Belum ada data inventaris untuk tahun <?= htmlspecialchars($filter_tahun) ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($inventaris as $inv): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($inv['jenis_barang']) ?></td>
                                
                                <td><?= $inv['asal_sendiri'] ?: '&#10003;' ?></td>
                                <td><?= $inv['asal_pemerintah'] ?: '&#10003;' ?></td>
                                <td><?= $inv['asal_bantuan_prov'] ?: '&#10003;' ?></td>
                                <td><?= $inv['asal_bantuan_kab'] ?: '&#10003;' ?></td>
                                <td><?= $inv['asal_sumbangan'] ?: '&#10003;' ?></td>
                                
                                <td><?= $inv['awal_baik'] ?: '&#10003;' ?></td>
                                <td><?= $inv['awal_rusak'] ?: '&#10003;' ?></td>
                                
                                <td><?= $inv['hapus_rusak'] ?: '&#10003;' ?></td>
                                <td><?= $inv['hapus_dijual'] ?: '&#10003;' ?></td>
                                <td><?= $inv['hapus_disumbangkan'] ?: '&#10003;' ?></td>
                                <td><?= !empty($inv['hapus_tanggal']) ? date('d/m/Y', strtotime($inv['hapus_tanggal'])) : '&#10003;' ?></td>
                                
                                <td><?= $inv['akhir_baik'] ?: '&#10003;' ?></td>
                                <td><?= $inv['akhir_rusak'] ?: '&#10003;' ?></td>
                                
                                <td><?= htmlspecialchars($inv['keterangan']) ?></td>
                                <td>
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="admin_inventaris_edit.php?id=<?= $inv['id'] ?>" class="text-blue-600 hover:text-blue-900 px-1" title="Edit Data">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                        </a>
                                        <a href="admin_inventaris.php?delete=<?= $inv['id'] ?>&tahun=<?= $filter_tahun ?>" onclick="return confirm('Hapus data inventaris ini?')" class="text-red-600 hover:text-red-900 px-1" title="Hapus Data">
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
