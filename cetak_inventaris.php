<?php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Silakan login.");
}

$db = (new Database())->getConnection();

$tahun = $_GET['tahun'] ?? date('Y');

// Ambil data inventaris
$stmt = $db->prepare("SELECT * FROM inventaris_desa WHERE tahun = ? ORDER BY id ASC");
$stmt->execute([$tahun]);
$inventaris = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Buku Inventaris Desa - <?= htmlspecialchars($tahun) ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.3;
            color: #000;
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .kertas {
            background: #fff;
            width: 330mm; /* F4 / Folio width roughly */
            min-height: 215mm;
            margin: 0 auto;
            padding: 15mm;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            font-size: 20px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .model-text {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: -20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
        }
        table th {
            font-weight: bold;
        }
        table td:nth-child(2) {
            text-align: left; /* Jenis barang */
        }
        .ttd-section {
            margin-top: 30px;
            width: 100%;
        }
        .ttd-box {
            width: 300px;
            float: right;
            text-align: center;
            font-size: 14px;
        }
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
        .ttd-nip {
            margin-top: 5px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .btn-print {
            display: block;
            width: 120px;
            margin: 0 auto 20px;
            padding: 10px;
            text-align: center;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        .print-input {
            border: none;
            border-bottom: 1px dashed #000;
            font-family: inherit;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            width: 80%;
            margin: 0 auto;
            outline: none;
            background: transparent;
        }
        @media print {
            .print-input {
                border-bottom: none;
                text-decoration: underline;
            }
            .print-input::-webkit-input-placeholder { color: transparent; }
            .print-input:-moz-placeholder { color: transparent; }
            .print-input::-moz-placeholder { color: transparent; }
            .print-input:-ms-input-placeholder { color: transparent; }
        }
        @media print {
            body { background: none; padding: 0; margin: 0; }
            .kertas { box-shadow: none; width: 100%; margin: 0; padding: 15mm; }
            .btn-print { display: none; }
            @page { 
                size: landscape; 
                margin: 0; 
            }
        }
        .cover-page {
            background: #fff;
            width: 330mm;
            min-height: 215mm;
            margin: 0 auto 30px auto;
            padding: 15mm;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            page-break-after: always;
            border: 4px double #000;
        }
        .cover-model {
            position: absolute;
            top: 15mm;
            right: 15mm;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid #000;
            padding: 5px 15px;
        }
        .cover-title-area {
            text-align: center;
            margin-top: 40mm;
        }
        .cover-title-text {
            font-size: 28px;
            font-weight: bold;
            line-height: 1.5;
        }
        .cover-logo {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .cover-logo img {
            width: 300px;
            height: auto;
            display: block;
        }
        .cover-details {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
        }
        .cover-details table {
            border: none;
            margin: 0;
            font-size: 18px;
        }
        .cover-details td {
            border: none;
            text-align: left;
            padding: 4px 8px;
            font-weight: bold;
            vertical-align: top;
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="btn-print">Cetak Dokumen</button>

<div class="cover-page">
    <div class="cover-model">MODEL A.3</div>
    <div class="cover-title-area">
        <div class="cover-title-text">
            BUKU DATA INVENTARIS DESA<br>
            TAHUN <span style="border-bottom: 2px dashed #000; padding: 0 20px; display: inline-block; min-width: 50px;"><?= htmlspecialchars($tahun) ?></span>
        </div>
        <div class="cover-logo">
            <img src="img/logo.png" alt="Logo Kabupaten Tasikmalaya">
        </div>
    </div>
    <div class="cover-details">
        <table>
            <tr>
                <td style="width: 150px;">DESA</td>
                <td style="width: 20px; text-align: center;">:</td>
                <td>JAYAPURA</td>
            </tr>
            <tr>
                <td>KECAMATAN</td>
                <td style="text-align: center;">:</td>
                <td>CIGALONTANG</td>
            </tr>
            <tr>
                <td>KABUPATEN</td>
                <td style="text-align: center;">:</td>
                <td>TASIKMALAYA</td>
            </tr>
            <tr>
                <td>PROVINSI</td>
                <td style="text-align: center;">:</td>
                <td>JAWA BARAT</td>
            </tr>
        </table>
    </div>
</div>

<div class="kertas">
    <div class="model-text">
        <div style="border: 1px solid #000; padding: 5px 15px; display: inline-block;">MODEL A.3</div>
    </div>
    
    <h1>BUKU DATA INVENTARIS DESA JAYAPURA<br>TAHUN <?= htmlspecialchars($tahun) ?></h1>
    <br>

    <table>
        <thead>
            <tr>
                <th rowspan="3" style="width: 30px;">No</th>
                <th rowspan="3" style="width: 150px;">Jenis Barang/<br>bangunan</th>
                <th colspan="5">Asal Barang/Bangunan</th>
                <th colspan="2">Keadaan Barang/Bangunan<br>di Awal Tahun</th>
                <th colspan="4">Penghapusan</th>
                <th colspan="2">Keadaan Barang/Bangunan<br>Akhir Tahun</th>
                <th rowspan="3" style="width: 100px;">Ket</th>
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
                <th rowspan="2">Disumbang-<br>kan</th>
                <th rowspan="2">Tgl<br>Penghapusan</th>
                
                <th rowspan="2">Baik</th>
                <th rowspan="2">Rusak</th>
            </tr>
            <tr>
                <th>Provinsi</th>
                <th>Kabupaten</th>
            </tr>
            <tr style="background-color: #f0f0f0;">
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
            </tr>
        </thead>
        <tbody>
            <?php if (empty($inventaris)): ?>
                <tr>
                    <td colspan="16" style="padding: 20px 0;">Tidak ada data inventaris untuk tahun <?= htmlspecialchars($tahun) ?>.</td>
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
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="ttd-section">
        <div style="float: left; width: 300px; text-align: center;">
            <p>Mengetahui,</p>
            <p>Kepala Desa Jayapura</p>
            <div class="ttd-nama">
                <input type="text" class="print-input" placeholder="Ketik Nama Kepala Desa...">
            </div>
        </div>
        <div class="ttd-box">
            <p>Jayapura, <?= date('d F Y') ?></p>
            <p>Sekretaris Desa</p>
            <div class="ttd-nama">
                <input type="text" class="print-input" placeholder="Ketik Nama Sekretaris Desa...">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
    // window.print();
</script>

</body>
</html>
