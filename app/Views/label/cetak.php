<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Label Rak - SIPUS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; padding: 10px; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .label {
            border: 2px solid #063a76; border-radius: 8px; padding: 12px;
            text-align: center; page-break-inside: avoid;
            background: linear-gradient(135deg, #f8f9fb, #ffffff);
        }
        .label .nama { font-size: 18pt; font-weight: 800; color: #063a76; margin-bottom: 4px; }
        .label .lokasi { font-size: 9pt; color: #666; }
        .label .jumlah { font-size: 8pt; color: #999; margin-top: 4px; }
        @media print { body { padding: 0; } }
    </style>
</head>
<body>
    <div class="grid">
        <?php foreach ($rak as $r): ?>
        <div class="label">
            <div class="nama"><?= esc($r['nama']) ?></div>
            <div class="lokasi"><?= esc($r['lokasi'] ?? '') ?></div>
            <div class="jumlah"><?= $r['jumlah_buku'] ?> buku</div>
        </div>
        <?php endforeach; ?>
    </div>
    <script>window.onload = function() { window.print(); };</script>
</body>
</html>
