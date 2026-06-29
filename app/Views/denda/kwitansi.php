<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran Denda - SIPUS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', 'Helvetica Neue', sans-serif; font-size: 10pt; margin: 0; padding: 2cm; color: #1a1a1a; background: #fff; }
        .no-print { display: none !important; }
        @page { margin: 2cm; size: A4 portrait; }

        .receipt { max-width: 600px; margin: 0 auto; border: 2px solid #063a76; border-radius: 12px; overflow: hidden; }
        .receipt-header { background: linear-gradient(135deg, #063a76, #005ac7); color: #fff; padding: 24px 32px; text-align: center; }
        .receipt-header h1 { font-size: 18pt; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .receipt-header .subtitle { font-size: 10pt; opacity: 0.8; margin-top: 4px; }
        .receipt-header .tagline { font-size: 8pt; opacity: 0.6; margin-top: 2px; }

        .receipt-body { padding: 24px 32px; }
        .receipt-title { text-align: center; font-size: 14pt; font-weight: 700; color: #063a76; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px dashed #e5e7eb; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .info-item { }
        .info-item .label { font-size: 8pt; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
        .info-item .value { font-size: 10pt; font-weight: 600; }

        .amount-box { background: #f8f9fb; border: 2px dashed #063a76; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
        .amount-box .label { font-size: 9pt; color: #666; margin-bottom: 4px; }
        .amount-box .amount { font-size: 24pt; font-weight: 800; color: #063a76; }
        .amount-box .terbilang { font-size: 8pt; color: #888; margin-top: 4px; font-style: italic; }

        .status-badge { display: inline-block; background: #d1fae5; color: #065f46; padding: 4px 16px; border-radius: 20px; font-size: 9pt; font-weight: 600; }

        .receipt-footer { display: flex; justify-content: space-between; align-items: flex-end; padding: 20px 32px; border-top: 1px solid #e5e7eb; background: #f8f9fb; }
        .receipt-footer .info { font-size: 8pt; color: #999; }
        .receipt-footer .ttd { text-align: center; min-width: 160px; }
        .receipt-footer .ttd .tanggal { font-size: 9pt; margin-bottom: 50px; }
        .receipt-footer .ttd .nama { font-size: 9pt; font-weight: 700; border-top: 1px solid #333; padding-top: 4px; }
        .receipt-footer .ttd .jabatan { font-size: 8pt; color: #666; }

        .toolbar { position: fixed; top: 0; left: 0; right: 0; background: #f3f4f6; padding: 10px 16px; display: flex; gap: 8px; z-index: 100; border-bottom: 1px solid #ddd; }
        .toolbar button { padding: 8px 20px; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; font-family: inherit; font-size: 13px; background: #fff; transition: all 0.2s; }
        .toolbar button:hover { background: #063a76; color: #fff; border-color: #063a76; }
        @media print { .toolbar { display: none !important; } body { padding: 1cm; } }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <button onclick="window.print()">&#128424; Cetak Kwitansi</button>
        <button onclick="window.close()">&#10005; Tutup</button>
    </div>

    <div class="receipt">
        <div class="receipt-header">
            <h1><?= $pengaturan['nama_aplikasi'] ?? 'SIPUS' ?></h1>
            <div class="subtitle"><?= $pengaturan['tagline'] ?? 'Sistem Informasi Perpustakaan' ?></div>
            <div class="tagline"><?= $pengaturan['kontak_alamat'] ?? '' ?></div>
        </div>

        <div class="receipt-body">
            <div class="receipt-title">KWITANSI PEMBAYARAN DENDA</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">No. Kwitansi</div>
                    <div class="value">KWT-<?= str_pad($denda['id'], 6, '0', STR_PAD_LEFT) ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Tanggal Bayar</div>
                    <div class="value"><?= $denda['tanggal_bayar'] ? date('d/m/Y H:i', strtotime($denda['tanggal_bayar'])) : date('d/m/Y H:i') ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Kode Peminjaman</div>
                    <div class="value"><?= esc($denda['kode_peminjaman']) ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Kode Anggota</div>
                    <div class="value"><?= esc($denda['kode_anggota'] ?? '-') ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Nama Anggota</div>
                    <div class="value"><?= esc($denda['nama_anggota']) ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Status</div>
                    <div class="value"><span class="status-badge">LUNAS</span></div>
                </div>
            </div>

            <div class="amount-box">
                <div class="label">Jumlah Pembayaran</div>
                <div class="amount">Rp <?= number_format($denda['jumlah'], 0, ',', '.') ?></div>
            </div>

            <div style="text-align:center;margin-top:16px;">
                <p style="font-size:8pt;color:#999;">Kwitansi ini dicetak secara otomatis oleh sistem SIPUS</p>
            </div>
        </div>

        <div class="receipt-footer">
            <div class="info">
                <p>Dicetak: <?= date('d/m/Y H:i') ?></p>
                <p>Oleh: <?= esc($user['nama'] ?? 'Sistem') ?></p>
            </div>
            <div class="ttd">
                <div class="tanggal"><?= format_tanggal(date('Y-m-d')) ?></div>
                <div class="nama"><?= esc($user['nama'] ?? 'Petugas') ?></div>
                <div class="jabatan"><?= esc($user['role'] ?? '') ?></div>
            </div>
        </div>
    </div>
</body>
</html>
