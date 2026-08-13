<?php require_once 'includes/header.php'; ?>

<section class="mb-8">
    <h2 class="text-3xl font-bold text-green-800">Dashboard Admin</h2>
    <p class="text-gray-600">Kelola data desa dengan mudah</p>
</section>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Pengguna</p>
            <h3 class="text-3xl font-bold text-gray-900"><?= $total_users ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-blue-600">group</span>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">UMKM Aktif</p>
            <h3 class="text-3xl font-bold text-gray-900"><?= $total_umkm ?></h3>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-green-600">storefront</span>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Pengumuman Aktif</p>
            <h3 class="text-3xl font-bold text-gray-900"><?= $total_announcements ?></h3>
        </div>
        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-purple-600">campaign</span>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Surat Menunggu</p>
            <h3 class="text-3xl font-bold <?= $total_surat_menunggu > 0 ? 'text-red-600' : 'text-gray-900' ?>"><?= $total_surat_menunggu ?></h3>
        </div>
        <div class="w-12 h-12 <?= $total_surat_menunggu > 0 ? 'bg-red-100' : 'bg-gray-100' ?> rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined <?= $total_surat_menunggu > 0 ? 'text-red-600' : 'text-gray-600' ?>">mark_email_unread</span>
        </div>
    </div>
</div>

<h2 class="text-xl font-bold text-gray-900 mb-4 mt-8">Manajemen Modul</h2>
<div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-6">
    <a href="admin_pengumuman.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-green-800">campaign</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Pengumuman</h3>
            <p class="text-sm text-gray-500">Buat dan edit info desa</p>
        </div>
    </a>
    <a href="admin_umkm.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-green-800">storefront</span>
        </div>
        <div>
            <h3 class="font-semibold">Verifikasi UMKM</h3>
            <p class="text-sm text-gray-500">Persetujuan data UMKM</p>
        </div>
    </a>
    <a href="admin_pengguna.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined text-green-800">group</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Pengguna</h3>
            <p class="text-sm text-gray-500">Kelola akun warga</p>
        </div>
    </a>
    <a href="admin_surat.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <?php if($total_surat_menunggu > 0): ?>
            <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
                <?= $total_surat_menunggu ?> BARU
            </span>
        <?php endif; ?>
        <div class="w-12 h-12 <?= $total_surat_menunggu > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-800' ?> rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">mark_email_unread</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Surat Online</h3>
            <p class="text-sm text-gray-500">Terima permohonan surat</p>
        </div>
    </a>
    <a href="admin_aspirasi.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <?php if($total_aspirasi_menunggu > 0): ?>
            <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
                <?= $total_aspirasi_menunggu ?> BARU
            </span>
        <?php endif; ?>
        <div class="w-12 h-12 <?= $total_aspirasi_menunggu > 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-800' ?> rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">forum</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Aspirasi</h3>
            <p class="text-sm text-gray-500">Tanggapi keluhan warga</p>
        </div>
    </a>

    <a href="admin_pertanian.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-green-100 text-green-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">agriculture</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Pertanian</h3>
            <p class="text-sm text-gray-500">Potensi pertanian desa</p>
        </div>
    </a>

    <a href="admin_arsip.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-green-100 text-green-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">folder_open</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Arsip</h3>
            <p class="text-sm text-gray-500">Arsip link Google Drive</p>
        </div>
    </a>

    <a href="admin_arsip_surat.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-green-100 text-green-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <div>
            <h3 class="font-semibold">Kelola Arsip Surat</h3>
            <p class="text-sm text-gray-500">Arsip surat masuk & keluar</p>
        </div>
    </a>

    <a href="admin_inventaris.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-blue-100 text-blue-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">book</span>
        </div>
        <div>
            <h3 class="font-semibold">Buku Inventaris</h3>
            <p class="text-sm text-gray-500">Model A.3 Inventaris Desa</p>
        </div>
    </a>

    <a href="admin_peraturan.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-purple-100 text-purple-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">menu_book</span>
        </div>
        <div>
            <h3 class="font-semibold">Buku Peraturan</h3>
            <p class="text-sm text-gray-500">Model A.1 Peraturan Desa</p>
        </div>
    </a>

    <a href="admin_keputusan.php" class="col-span-1 md:col-span-2 lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition flex items-center gap-4 relative">
        <div class="w-12 h-12 bg-orange-100 text-orange-800 rounded-lg flex items-center justify-center">
            <span class="material-symbols-outlined">gavel</span>
        </div>
        <div>
            <h3 class="font-semibold">Buku Keputusan</h3>
            <p class="text-sm text-gray-500">Model A.2 Keputusan Kades</p>
        </div>
    </a>
</div>

<div class="mt-12 text-center text-sm text-gray-500 pb-4">
    <p>&copy; Copyright hak cipta dilindungi KKN Jayapura Universitas Perjuangan 2026</p>
</div>

<?php require_once 'includes/footer.php'; ?>
