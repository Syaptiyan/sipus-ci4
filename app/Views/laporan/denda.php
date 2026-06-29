<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - SIPUS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', 'Helvetica Neue', sans-serif; font-size: 10pt; margin: 0; padding: 1.5cm 2cm; color: #1a1a1a; background: #fff; }
        .no-print { display: none !important; }
        @page { margin: 1.5cm 2cm; size: A4 portrait; }
        .kop { text-align: center; padding-bottom: 14px; margin-bottom: 20px; border-bottom: 3px double #333; }
        .kop h1 { font-size: 16pt; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #063a76; margin: 0; }
        .kop .tagline { font-size: 9pt; color: #666; margin-top: 4px; }
        .kop .contact { font-size: 8pt; color: #888; margin-top: 2px; }
        .title-bar { text-align: center; margin-bottom: 18px; }
        .title-bar h2 { font-size: 13pt; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #222; border-bottom: 2px solid #063a76; display: inline-block; padding-bottom: 4px; }
        .title-bar .periode { font-size: 9pt; color: #666; margin-top: 6px; }
        table { width: 100%; border-collapse: collapse; font-size: 9pt; margin-bottom: 12px; }
        thead th { background: #063a76; color: #fff; font-weight: 600; text-align: left; padding: 7px 6px; font-size: 8.5pt; text-transform: uppercase; letter-spacing: 0.5px; }
        thead th:first-child { border-radius: 4px 0 0 0; }
        thead th:last-child { border-radius: 0 4px 0 0; }
        tbody td { padding: 6px; border-bottom: 1px solid #eee; vertical-align: top; }
        tbody tr:nth-child(even) { background: #f8f9fb; }
        tbody tr:last-child td { border-bottom: 2px solid #063a76; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row td { font-weight: 700; background: #f0f4f8 !important; border-top: 2px solid #063a76; }
        .summary { display: flex; gap: 16px; margin-top: 12px; flex-wrap: wrap; }
        .summary-item { background: #f8f9fb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px 14px; flex: 1; min-width: 100px; }
        .summary-item .label { font-size: 7.5pt; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-item .value { font-size: 12pt; font-weight: 700; color: #063a76; margin-top: 2px; }
        .footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 30px; padding-top: 12px; border-top: 1px solid #ddd; }
        .footer .info { font-size: 8pt; color: #999; }
        .footer .ttd { text-align: center; min-width: 180px; }
        .footer .ttd .tanggal { font-size: 9pt; margin-bottom: 60px; }
        .footer .ttd .nama { font-size: 9pt; font-weight: 700; border-top: 1px solid #333; padding-top: 4px; }
        .toolbar { position: fixed; top: 0; left: 0; right: 0; background: #f3f4f6; padding: 10px 16px; display: flex; gap: 8px; z-index: 100; border-bottom: 1px solid #ddd; }
        .toolbar button { padding: 8px 20px; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; font-family: inherit; font-size: 13px; background: #fff; transition: all 0.2s; }
        .toolbar button:hover { background: #063a76; color: #fff; border-color: #063a76; }
        @media print { .toolbar { display: none !important; } body { padding-top: 0; } }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <button onclick="window.print()">&#128424; Cetak</button>
        <button onclick="window.close()">&#10005; Tutup</button>
    </div>

    <div class="kop">
        <h1><?= $pengaturan['nama_aplikasi'] ?? 'SIPUS' ?></h1>
        <div class="tagline"><?= $pengaturan['tagline'] ?? 'Sistem Informasi Perpustakaan' ?></div>
        <div class="contact"><?= $pengaturan['kontak_alamat'] ?? '' ?> | Telp: <?= $pengaturan['kontak_telepon'] ?? '' ?> | <?= $pengaturan['kontak_email'] ?? '' ?></div>
    </div>

    <div class="title-bar">
        <h2>Laporan Data Denda</h2>
        <?php if ($dari || $sampai): ?>
        <div class="periode">Periode: <?= $dari ? format_tanggal($dari) : '-' ?> s/d <?= $sampai ? format_tanggal($sampai) : '-' ?></div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:35px;">No</th>
                <th>Kode Peminjaman</th>
                <th>Anggota</th>
                <th class="text-right">Jumlah</th>
                <th>Status</th>
                <th>Tgl Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $total = 0; $lunas = 0; $belum = 0; ?>
            <?php foreach ($denda as $d): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td style="font-family:monospace;font-size:8.5pt;"><?= esc($d['kode_peminjaman']) ?></td>
                <td><?= esc($d['nama_anggota']) ?></td>
                <td class="text-right"><?= format_rupiah($d['jumlah']) ?></td>
                <td>
                    <?php if ($d['status'] === 'Lunas'): ?>
                        <span style="color:#10b981;font-weight:600;">Lunas</span>
                    <?php else: ?>
                        <span style="color:#ef4444;font-weight:600;">Belum</span>
                    <?php endif; ?>
                </td>
                <td><?= $d['tanggal_bayar'] ? format_tanggal($d['tanggal_bayar']) : '-' ?></td>
            </tr>
            <?php $total += $d['jumlah']; if ($d['status'] === 'Lunas') $lunas++; else $belum++; ?>
            <?php endforeach; ?>
            <?php if (empty($denda)): ?>
            <tr><td colspan="6" style="text-align:center;padding:24px;color:#999;">Tidak ada data</td></tr>
            <?php else: ?>
            <tr class="total-row">
                <td colspan="3" class="text-right" style="padding:8px 6px;">Total</td>
                <td class="text-right"><?= format_rupiah($total) ?></td>
                <td colspan="2"></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item"><div class="label">Total Denda</div><div class="value"><?= format_rupiah($total) ?></div></div>
        <div class="summary-item"><div class="label">Lunas</div><div class="value"><?= $lunas ?></div></div>
        <div class="summary-item"><div class="label">Belum Bayar</div><div class="value"><?= $belum ?></div></div>
    </div>

    <div class="footer">
        <div class="info">Dicetak: <?= date('d/m/Y H:i') ?> oleh <?= esc($user['nama'] ?? 'Sistem') ?></div>
        <div class="ttd">
            <div class="tanggal"><?= format_tanggal(date('Y-m-d')) ?></div>
            <div class="nama"><?= esc($user['nama'] ?? 'Petugas') ?></div>
        </div>
    </div>
</body>
</html>
