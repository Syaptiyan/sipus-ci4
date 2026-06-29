<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - SIPUS</title>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Mulish', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8f9fb; }
        .container { text-align: center; max-width: 500px; padding: 40px 20px; }
        .icon { width: 80px; height: 80px; margin: 0 auto 24px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .icon svg { width: 40px; height: 40px; color: #f59e0b; }
        h1 { font-size: 24px; font-weight: 700; color: #1f2937; margin-bottom: 12px; }
        p { font-size: 15px; color: #6b7280; line-height: 1.6; }
        .logo { margin-top: 40px; font-size: 14px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
        </div>
        <h1>Maintenance Mode</h1>
        <p><?= esc(urldecode($msg ?? 'Sistem sedang dalam pemeliharaan. Silakan coba lagi nanti.')) ?></p>
        <div class="logo">SIPUS &mdash; Sistem Informasi Perpustakaan</div>
    </div>
</body>
</html>
