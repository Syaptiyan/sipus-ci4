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
        .status { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 7.5pt; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #dbeafe; color: #1e40af; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-borrowed { background: #dbeafe; color: #1e40af; }
        .status-returned { background: #d1fae5; color: #065f46; }
        .status-late { background: #fee2e2; color: #991b1b; }
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
        <h2>Laporan Data Peminjaman</h2>
        <?php if ($dari || $sampai): ?>
        <div class="periode">Periode: <?= $dari ? format_tanggal($dari) : '-' ?> s/d <?= $sampai ? format_tanggal($sampai) : '-' ?></div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:35px;">No</th>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $pending = 0; $borrowed = 0; $returned = 0; $late = 0; ?>
            <?php foreach ($peminjaman as $p): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td style="font-family:monospace;font-size:8.5pt;"><?= esc($p['kode_peminjaman']) ?></td>
                <td><?= esc($p['nama_anggota']) ?></td>
                <td><?= $p['tanggal_pengajuan'] ? format_tanggal($p['tanggal_pengajuan']) : '-' ?></td>
                <td><?= $p['tanggal_pinjam'] ? format_tanggal($p['tanggal_pinjam']) : '-' ?></td>
                <td><?= $p['tanggal_jatuh_tempo'] ? format_tanggal($p['tanggal_jatuh_tempo']) : '-' ?></td>
                <td>
                    <?php
                    $sc = match($p['status']) {
                        'pending' => 'status-pending', 'approved' => 'status-approved',
                        'rejected' => 'status-rejected', 'borrowed' => 'status-borrowed',
                        'returned' => 'status-returned', 'late' => 'status-late',
                        default => 'status-pending'
                    };
                    $sl = match($p['status']) {
                        'pending' => 'Pending', 'approved' => 'Disetujui',
                        'rejected' => 'Ditolak', 'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan', 'late' => 'Terlambat',
                        default => ucfirst($p['status'])
                    };
                    if ($p['status'] === 'pending') $pending++;
                    if ($p['status'] === 'borrowed') $borrowed++;
                    if ($p['status'] === 'returned') $returned++;
                    if ($p['status'] === 'late') $late++;
                    ?>
                    <span class="status <?= $sc ?>"><?= $sl ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($peminjaman)): ?>
            <tr><td colspan="7" style="text-align:center;padding:24px;color:#999;">Tidak ada data</td></tr>
            <?php else: ?>
            <tr class="total-row">
                <td colspan="7" class="text-right" style="padding:8px 6px;">Total: <?= $no - 1 ?> transaksi</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item"><div class="label">Total</div><div class="value"><?= count($peminjaman) ?></div></div>
        <div class="summary-item"><div class="label">Pending</div><div class="value"><?= $pending ?></div></div>
        <div class="summary-item"><div class="label">Dipinjam</div><div class="value"><?= $borrowed ?></div></div>
        <div class="summary-item"><div class="label">Dikembalikan</div><div class="value"><?= $returned ?></div></div>
        <div class="summary-item"><div class="label">Terlambat</div><div class="value"><?= $late ?></div></div>
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
