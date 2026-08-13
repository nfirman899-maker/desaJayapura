<?php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

$id = $_GET['id'] ?? 0;
if (!$id) {
    die("ID Surat tidak valid.");
}

$db = (new Database())->getConnection();

// Ambil data surat beserta info user
$stmt = $db->prepare("
    SELECT surat.*, users.full_name, users.phone 
    FROM surat 
    JOIN users ON surat.user_id = users.id 
    WHERE surat.id = ?
");
$stmt->execute([$id]);
$surat = $stmt->fetch();

if (!$surat) {
    die("Surat tidak ditemukan.");
}

// Pastikan yang mencetak adalah pemilik surat ATAU admin
if ($surat['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
    die("Anda tidak memiliki izin untuk mencetak surat ini.");
}

if ($surat['status'] !== 'Selesai') {
    die("Surat ini belum selesai diproses dan tidak dapat dicetak.");
}

// Generate nomor surat acak atau format tertentu (dummy)
$nomor_surat = "470/" . str_pad($surat['id'], 3, '0', STR_PAD_LEFT) . "/DS-JYP/" . date('Y', strtotime($surat['tanggal_pengajuan']));

// Custom text based on surat type
$jenis = $surat['jenis_surat'];
$paragraf_pengantar = "Berdasarkan keterangan dan pengamatan kami, orang tersebut di atas adalah benar-benar warga masyarakat Desa Jayapura dan berkelakuan baik.";
$paragraf_keperluan = "Surat keterangan ini diberikan berdasarkan permohonan yang bersangkutan dengan keterangan keperluan sebagai berikut:";

if (stripos($jenis, 'KTP') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa orang tersebut di atas adalah benar-benar warga Desa Jayapura yang memerlukan pengantar untuk pembuatan Kartu Tanda Penduduk (KTP).";
    $paragraf_keperluan = "Surat pengantar ini diberikan untuk melengkapi persyaratan administratif pembuatan KTP dengan keperluan sebagai berikut:";
} elseif (stripos($jenis, 'Domisili') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa orang tersebut di atas benar-benar berdomisili / bertempat tinggal secara sah di wilayah Desa Jayapura.";
    $paragraf_keperluan = "Surat keterangan domisili ini diberikan kepada yang bersangkutan untuk keperluan:";
} elseif (stripos($jenis, 'KK') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa orang tersebut di atas adalah benar-benar warga Desa Jayapura yang memerlukan pengantar untuk pembuatan Kartu Keluarga (KK).";
    $paragraf_keperluan = "Surat pengantar ini diberikan untuk melengkapi persyaratan administratif pembuatan KK dengan keperluan sebagai berikut:";
} elseif (stripos($jenis, 'Usaha') !== false || stripos($jenis, 'SKU') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa orang tersebut di atas benar-benar memiliki usaha dan menjalankan kegiatan usahanya di wilayah Desa Jayapura.";
    $paragraf_keperluan = "Surat keterangan usaha ini diberikan kepada yang bersangkutan untuk keperluan:";
} elseif (stripos($jenis, 'Tidak Mampu') !== false || stripos($jenis, 'SKTM') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa orang tersebut di atas adalah warga Desa Jayapura yang berkeadaan ekonomi Kurang Mampu / Keluarga Miskin.";
    $paragraf_keperluan = "Surat keterangan tidak mampu ini diberikan kepada yang bersangkutan untuk keperluan:";
} elseif (stripos($jenis, 'Belum Menikah') !== false) {
    $paragraf_pengantar = "Menerangkan dengan sesungguhnya bahwa berdasarkan catatan administrasi desa kami, orang tersebut di atas berstatus Belum Pernah Menikah.";
    $paragraf_keperluan = "Surat keterangan ini diberikan kepada yang bersangkutan untuk keperluan:";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak <?= htmlspecialchars($surat['jenis_surat']) ?> - Desa Jayapura</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            color: #000;
            background: #f0f0f0;
            padding: 20px;
        }
        .kertas {
            background: #fff;
            width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            margin: 0 auto;
            padding: 20mm;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .kop-surat {
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat table {
            width: 100%;
        }
        .kop-surat h1 {
            margin: 5px 0;
            font-size: 26px;
            text-transform: uppercase;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 20px;
            font-weight: normal;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 0;
            font-size: 14px;
        }
        .judul-surat {
            text-align: center;
            margin: 30px 0;
        }
        .judul-surat h3 {
            margin: 0;
            font-size: 18px;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul-surat p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .isi-surat {
            font-size: 14px;
            text-align: justify;
        }
        .biodata {
            margin: 20px 0 20px 40px;
        }
        .biodata table {
            width: 100%;
        }
        .biodata td {
            padding: 4px 0;
            vertical-align: top;
        }
        .biodata td:first-child {
            width: 200px;
        }
        .biodata td:nth-child(2) {
            width: 15px;
        }
        .ttd-section {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        @media print {
            body { background: none; padding: 0; margin: 0; }
            .kertas { box-shadow: none; width: 100%; margin: 0; padding: 20mm; }
            @page { size: A4; margin: 0; }
        }
        .btn-print {
            display: block;
            width: 100px;
            margin: 0 auto 20px;
            padding: 10px;
            text-align: center;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            cursor: pointer;
            border: none;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="btn-print">Cetak Surat</button>

<div class="kertas">
    <div class="kop-surat">
        <table cellspacing="0" cellpadding="0" style="width: 100%;">
            <tr>
                <td style="width: 120px; text-align: center; vertical-align: middle;">
                    <img src="img/logo.png" alt="Logo Kabupaten Tasikmalaya" style="height: 110px; width: auto;">
                </td>
                <td style="text-align: center; vertical-align: middle; padding-right: 120px;">
                    <h2 style="margin:0; font-size: 18px; font-weight: normal; text-transform: uppercase;">PEMERINTAH KABUPATEN TASIKMALAYA</h2>
                    <h2 style="margin:0; font-size: 18px; font-weight: normal; text-transform: uppercase;">KECAMATAN CIGALONTANG</h2>
                    <h1 style="margin:5px 0; font-size: 24px; text-transform: uppercase;">DESA JAYAPURA</h1>
                    <p style="margin:0; font-size: 14px;">Alamat: Jl. Raya Jayapura No. 1, Kec. Cigalontang, Kab. Tasikmalaya, Jawa Barat 46189</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="judul-surat">
        <h3><?= htmlspecialchars(strtoupper($surat['jenis_surat'])) ?></h3>
        <p>Nomor: <?= htmlspecialchars($nomor_surat) ?></p>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Jayapura, Kecamatan Cigalontang, Kabupaten Tasikmalaya, menerangkan dengan sesungguhnya bahwa:</p>
        
        <div class="biodata">
            <table cellspacing="0">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><strong><?= htmlspecialchars($surat['full_name']) ?></strong></td>
                </tr>
                <tr>
                    <td>Nomor Induk Kependudukan (NIK)</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($surat['nik']) ?></td>
                </tr>
                <tr>
                    <td>Nomor Telepon / WhatsApp</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($surat['phone'] ?: '-') ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= nl2br(htmlspecialchars($surat['alamat'] ?? 'Desa Jayapura, Kec. Cigalontang, Kab. Tasikmalaya')) ?></td>
                </tr>
            </table>
        </div>

        <p><?= $paragraf_pengantar ?></p>
        
        <p><?= $paragraf_keperluan ?></p>
        
        <div class="biodata">
            <table cellspacing="0">
                <tr>
                    <td><strong>Keperluan / Keterangan</strong></td>
                    <td><strong>:</strong></td>
                    <td style="font-weight: bold; font-style: italic;">
                        "<?= htmlspecialchars($surat['keterangan']) ?>"
                    </td>
                </tr>
            </table>
        </div>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya oleh yang berkepentingan.</p>
    </div>

    <div class="ttd-section">
        <p>Jayapura, <?= date('d F Y') ?></p>
        <p>Kepala Desa Jayapura,</p>
        <div class="ttd-nama">
            Suratman
        </div>
    </div>
    
    <div class="clearfix"></div>
</div>

<script>
    // Langsung buka dialog print saat halaman dimuat
    window.onload = function() {
        // window.print(); // Di-comment agar user bisa melihat priview dulu
    };
</script>

</body>
</html>
