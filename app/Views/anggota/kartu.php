<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota - <?= esc($anggota['nama']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .card-container { display: flex; flex-direction: column; gap: 24px; align-items: center; }

        .card {
            width: 85.6mm; height: 54mm; border-radius: 12px; overflow: hidden;
            background: linear-gradient(135deg, #063a76 0%, #005ac7 50%, #063a76 100%);
            color: white; position: relative;
            box-shadow: 0 8px 32px rgba(6,58,118,0.25), 0 2px 8px rgba(0,0,0,0.1);
        }
        .card::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 160px; height: 160px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .card::after {
            content: ''; position: absolute; bottom: -60px; left: -30px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .card-header {
            padding: 14px 18px 10px; display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 1; border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .card-logo {
            width: 32px; height: 32px; background: rgba(255,255,255,0.2);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .card-logo svg { width: 18px; height: 18px; }
        .card-title { font-size: 13px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
        .card-subtitle { font-size: 7px; opacity: 0.7; letter-spacing: 0.5px; }

        .card-body {
            padding: 10px 18px; display: flex; justify-content: space-between; align-items: center;
            position: relative; z-index: 1;
        }
        .card-info { flex: 1; }
        .card-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; letter-spacing: 0.3px; }
        .card-code { font-size: 9px; opacity: 0.8; font-family: 'Courier New', monospace; letter-spacing: 1.5px; }
        .card-expiry { font-size: 7px; opacity: 0.6; margin-top: 8px; }
        .card-expiry span { font-weight: 600; opacity: 1; }

        .card-qr {
            width: 64px; height: 64px; background: white; border-radius: 8px; padding: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .card-qr img { width: 100%; height: 100%; border-radius: 4px; }

        .card-footer {
            position: absolute; bottom: 10px; left: 18px; right: 18px;
            display: flex; justify-content: space-between; align-items: center; z-index: 1;
        }
        .card-footer span { font-size: 6.5px; opacity: 0.5; text-transform: uppercase; letter-spacing: 0.5px; }

        .card-chip {
            position: absolute; top: 60px; right: 18px;
            width: 24px; height: 18px; background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 3px; opacity: 0.8; z-index: 1;
        }

        .actions { display: flex; gap: 12px; }
        .btn {
            padding: 12px 28px; border: none; border-radius: 10px;
            font-family: 'Inter', sans-serif; font-weight: 600; font-size: 14px;
            cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;
        }
        .btn-print { background: #063a76; color: white; box-shadow: 0 4px 12px rgba(6,58,118,0.3); }
        .btn-print:hover { background: #052d5e; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(6,58,118,0.4); }
        .btn-back { background: white; color: #063a76; border: 1px solid #e2e8f0; }
        .btn-back:hover { background: #f8fafc; }

        @media print {
            body { background: white; padding: 1cm; }
            .actions { display: none !important; }
            .card { box-shadow: 0 0 0 1px #ddd; print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card">
            <div class="card-chip"></div>
            <div class="card-header">
                <div class="card-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <div class="card-title">SIPUS</div>
                    <div class="card-subtitle">Kartu Anggota Perpustakaan</div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-info">
                    <div class="card-name"><?= esc($anggota['nama']) ?></div>
                    <div class="card-code"><?= esc($anggota['kode_anggota']) ?></div>
                    <div class="card-expiry">
                        Berlaku hingga: <span>
                        <?php if (!empty($anggota['tanggal_expired'])): ?>
                            <?= date('M Y', strtotime($anggota['tanggal_expired'])) ?>
                        <?php else: ?>
                            Aktif
                        <?php endif; ?>
                        </span>
                    </div>
                </div>
                <div class="card-qr">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=128x128&data=<?= urlencode($anggota['kode_anggota']) ?>&bgcolor=ffffff&color=063a76" alt="QR Code">
                </div>
            </div>
            <div class="card-footer">
                <span>Sistem Informasi Perpustakaan</span>
                <span>Member Card</span>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-print" onclick="window.print()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Kartu
            </button>
            <button class="btn btn-back" onclick="history.back()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </button>
        </div>
    </div>
</body>
</html>
