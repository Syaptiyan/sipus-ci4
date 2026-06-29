<!DOCTYPE html>
<html lang="id" data-theme="jaklitera">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIPUS' ?> - Sistem Informasi Perpustakaan</title>
    <meta name="description" content="Sistem Informasi Perpustakaan">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="<?= base_url('assets/css/app.min.css') ?>" as="style">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css') ?>">
    <script defer src="<?= base_url('assets/js/alpine.min.js') ?>"></script>
    <style>
        body { font-family: 'Mulish', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-base-200">
    <?= $this->renderSection('content') ?>
</body>
</html>
