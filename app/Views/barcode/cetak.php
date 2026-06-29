<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode - SIPUS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; padding: 10px; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .card { border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; text-align: center; page-break-inside: avoid; }
        .card svg { max-width: 100%; height: auto; }
        .title { font-size: 10px; font-weight: 600; margin-top: 4px; line-height: 1.2; max-height: 2.4em; overflow: hidden; }
        .isbn { font-size: 8px; color: #9ca3af; font-family: monospace; }
        @media print { body { padding: 0; } .card { border-color: #d1d5db; } }
    </style>
</head>
<body>
    <div class="grid">
        <?php foreach ($buku as $b): ?>
        <div class="card">
            <?php if (!empty($b['isbn'])): ?>
                <svg class="bc-<?= $b['id'] ?>"></svg>
            <?php else: ?>
                <div style="height:50px;display:flex;align-items:center;justify-content:center;background:#f3f4f6;border-radius:4px;font-size:8px;color:#9ca3af;">No ISBN</div>
            <?php endif; ?>
            <div class="title"><?= esc($b['judul']) ?></div>
            <div class="isbn"><?= esc($b['isbn'] ?? '-') ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="<?= base_url('assets/js/jsbarcode.min.js') ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($buku as $b): ?>
        <?php if (!empty($b['isbn'])): ?>
        try {
            JsBarcode('.bc-<?= $b['id'] ?>', '<?= esc($b['isbn']) ?>', {
                format: 'CODE128', width: 1.5, height: 50,
                displayValue: true, fontSize: 10, margin: 3,
                lineColor: '#000000', background: '#ffffff'
            });
        } catch(e) {}
        <?php endif; ?>
        <?php endforeach; ?>
        window.onload = function() { window.print(); };
    });
    </script>
</body>
</html>
