<?php
require_once 'config/database.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak. Silakan login.");
}

$db = (new Database())->getConnection();

$tahun = $_GET['tahun'] ?? date('Y');

// Ambil data peraturan
$stmt = $db->prepare("SELECT * FROM peraturan_desa WHERE tahun = ? ORDER BY id ASC");
$stmt->execute([$tahun]);
$peraturan_list = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Buku Peraturan Desa - <?= htmlspecialchars($tahun) ?></title>
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
            vertical-align: top;
        }
        table th {
            font-weight: bold;
            vertical-align: middle;
        }
        table td:nth-child(3), table td:nth-child(4) {
            text-align: left; /* Tentang & Uraian Singkat biasanya panjang */
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
    <div class="cover-model">MODEL A.1</div>
    <div class="cover-title-area">
        <div class="cover-title-text">
            BUKU DATA PERATURAN DESA<br>
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
        <div style="border: 1px solid #000; padding: 5px 15px; display: inline-block;">MODEL A.1</div>
    </div>
    
    <h1>BUKU DATA PERATURAN DESA<br>TAHUN <?= htmlspecialchars($tahun) ?></h1>
    <br>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 150px;">No & Tgl Peraturan<br>Desa</th>
                <th style="width: 200px;">Tentang</th>
                <th>Uraian Singkat</th>
                <th style="width: 120px;">No & Tgl Persetujuan BPD</th>
                <th style="width: 120px;">No & Tgl Dilaporkan</th>
                <th style="width: 120px;">Keterangan</th>
            </tr>
            <tr style="background-color: #f0f0f0;">
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($peraturan_list)): ?>
                <tr>
                    <td colspan="7" style="padding: 20px 0;">Tidak ada data peraturan untuk tahun <?= htmlspecialchars($tahun) ?>.</td>
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

</body>
</html>
