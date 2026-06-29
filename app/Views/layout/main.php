<!DOCTYPE html>
<html lang="id" data-theme="jaklitera">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - <?= $app_settings['nama_aplikasi'] ?? 'SIPUS' ?></title>
    <?php if (!empty($app_settings['favicon'])): ?>
    <link rel="icon" type="image/png" href="<?= base_url($app_settings['favicon']) ?>">
    <?php else: ?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <?php endif; ?>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="theme-color" content="#063a76">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="<?= base_url('assets/css/app.min.css') ?>" as="style">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css') ?>">
    <script defer src="<?= base_url('assets/js/alpine.min.js') ?>"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Mulish', sans-serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover { background: rgba(6, 58, 118, 0.06); }
        .sidebar-link.active { background: rgba(6, 58, 118, 0.1); color: #063a76; font-weight: 600; }
        .overflow-x-auto { min-width: 0; max-width: 100%; }
        main .overflow-x-auto { overflow-x: auto !important; -webkit-overflow-scrolling: touch; }
        main .overflow-x-auto table td { white-space: nowrap; }
    </style>
</head>
<body class="bg-base-200 antialiased">
<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-40 lg:hidden"></div>

    <!-- Sidebar -->
    <aside class="fixed lg:sticky top-0 left-0 z-50 h-screen w-64 bg-white border-r border-base-200 flex flex-col transform transition-transform duration-200 lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <!-- Logo -->
        <div class="p-5 border-b border-base-200">
            <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3">
                <?php if (!empty($app_settings['logo'])): ?>
                    <img src="<?= base_url($app_settings['logo']) ?>" alt="Logo" class="w-9 h-9 rounded-lg object-contain">
                <?php else: ?>
                    <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <div>
                    <p class="font-bold text-base text-base-content"><?= esc($app_settings['nama_aplikasi'] ?? 'SIPUS') ?></p>
                    <p class="text-xs text-base-content/50"><?= esc($app_settings['tagline'] ?? 'Sistem Perpustakaan') ?></p>
                </div>
            </a>
        </div>

        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto p-3 space-y-1" x-data="{ openMenu: 'dashboard' }">
            <!-- Dashboard -->
            <a href="<?= base_url('dashboard') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-base-content/70">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <!-- Katalog / Master Data -->
            <button @click="openMenu = openMenu === 'master' ? '' : 'master'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-base-content hover:bg-base-200/50 transition-all">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <?= $user['role'] !== 'Anggota' ? 'Master Data' : 'Katalog' ?>
                </span>
                <svg class="w-4 h-4 transition-transform" :class="openMenu === 'master' && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openMenu === 'master'" x-collapse>
                <a href="<?= base_url('buku') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Buku</a>
                <?php if ($user['role'] !== 'Anggota'): ?>
                <a href="<?= base_url('anggota') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Anggota</a>
                <a href="<?= base_url('kategori') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Kategori</a>
                <a href="<?= base_url('penulis') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Penulis</a>
                <a href="<?= base_url('penerbit') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Penerbit</a>
                <a href="<?= base_url('rak') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Rak</a>
                <?php endif; ?>
            </div>

            <!-- Transaksi -->
            <button @click="openMenu = openMenu === 'transaksi' ? '' : 'transaksi'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-base-content hover:bg-base-200/50 transition-all">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Transaksi
                </span>
                <svg class="w-4 h-4 transition-transform" :class="openMenu === 'transaksi' && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openMenu === 'transaksi'" x-collapse>
                <a href="<?= base_url('peminjaman') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Peminjaman</a>
                <?php if ($user['role'] !== 'Anggota'): ?>
                <a href="<?= base_url('pengembalian') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Pengembalian</a>
                <?php endif; ?>
                <a href="<?= base_url('denda') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Denda</a>
                <a href="<?= base_url('wishlist') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Wishlist</a>
            </div>

            <?php if ($user['role'] === 'Anggota'): ?>
            <!-- Saya (Anggota) -->
            <button @click="openMenu = openMenu === 'saya' ? '' : 'saya'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-base-content hover:bg-base-200/50 transition-all">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Saya
                </span>
                <svg class="w-4 h-4 transition-transform" :class="openMenu === 'saya' && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openMenu === 'saya'" x-collapse>
                <a href="<?= base_url('favorit') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Favorit Saya</a>
                <a href="<?= base_url('rekomendasi') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Rekomendasi</a>
                <a href="<?= base_url('statistik') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Statistik</a>
                <a href="<?= base_url('anggota/kartu') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70" target="_blank">Kartu Anggota</a>
            </div>
            <?php endif; ?>

            <?php if ($user['role'] !== 'Anggota'): ?>
            <!-- Cetak & Scan (Petugas/Admin) -->
            <button @click="openMenu = openMenu === 'cetak' ? '' : 'cetak'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-base-content hover:bg-base-200/50 transition-all">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak & Scan
                </span>
                <svg class="w-4 h-4 transition-transform" :class="openMenu === 'cetak' && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openMenu === 'cetak'" x-collapse>
                <a href="<?= base_url('laporan') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Laporan</a>
                <a href="<?= base_url('scan') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Scan QR</a>
                <a href="<?= base_url('barcode') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Cetak Barcode</a>
                <a href="<?= base_url('label') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Label Rak</a>
            </div>
            <?php endif; ?>

            <?php if ($user['role'] === 'Admin'): ?>
            <!-- Pengaturan (Admin) -->
            <button @click="openMenu = openMenu === 'admin' ? '' : 'admin'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-base-content hover:bg-base-200/50 transition-all">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </span>
                <svg class="w-4 h-4 transition-transform" :class="openMenu === 'admin' && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openMenu === 'admin'" x-collapse>
                <a href="<?= base_url('user') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Pengguna</a>
                <a href="<?= base_url('user/pending') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Aktivasi Akun</a>
                <a href="<?= base_url('pengaturan') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Pengaturan Sistem</a>
                <a href="<?= base_url('backup') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Backup Database</a>
                <a href="<?= base_url('broadcast') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Broadcast</a>
                <a href="<?= base_url('version') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Riwayat Data</a>
                <a href="<?= base_url('audit/login-history') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Audit Login</a>
                <a href="<?= base_url('audit/statistik') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Statistik User</a>
                <a href="<?= base_url('system/health') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Health Check</a>
                <a href="<?= base_url('system/info') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">System Info</a>
                <a href="<?= base_url('system/logs') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Log Error</a>
                <a href="<?= base_url('system/storage') ?>" class="sidebar-link flex items-center gap-3 pl-10 pr-3 py-2 rounded-lg text-sm text-base-content/70">Storage</a>
            </div>
            <?php endif; ?>
        </nav>

        <!-- Logout -->
        <div class="p-3 border-t border-base-200">
            <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-base-content/50 hover:text-error transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top navbar -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-base-200">
            <div class="flex items-center justify-between px-4 lg:px-6 h-16">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden btn btn-ghost btn-sm btn-square">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-bold text-base-content"><?= $title ?? 'Dashboard' ?></h1>
                </div>
                <div class="flex items-center gap-2">
                    <button id="theme-toggle" class="btn btn-ghost btn-sm btn-square" title="Toggle Dark Mode">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-base-200 cursor-pointer transition-colors">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold">
                                <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium leading-tight text-base-content"><?= $user['nama'] ?? 'User' ?></p>
                                <p class="text-xs text-base-content/50"><?= $user['role'] ?? '' ?></p>
                            </div>
                            <svg class="w-4 h-4 text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-white rounded-xl border border-base-200 w-48 mt-1">
                            <li><a href="<?= base_url('profil') ?>" class="text-sm">Profil Saya</a></li>
                            <li><a href="<?= base_url('bantuan') ?>" class="text-sm">Bantuan</a></li>
                            <li><a href="<?= base_url('tentang') ?>" class="text-sm">Tentang</a></li>
                            <li><a href="<?= base_url('changelog') ?>" class="text-sm">Changelog</a></li>
                            <?php if ($user['role'] === 'Admin'): ?>
                            <li><a href="<?= base_url('pengaturan') ?>" class="text-sm">Pengaturan</a></li>
                            <?php endif; ?>
                            <li><hr class="my-1 border-base-200"></li>
                            <li><a href="<?= base_url('logout') ?>" class="text-sm text-error">Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6 min-w-0">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-sm text-emerald-700"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('warning')): ?>
                <div class="mb-4 p-3 rounded-lg bg-amber-50 border border-amber-200 text-sm text-amber-700"><?= session()->getFlashdata('warning') ?></div>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script>
(function() {
    const toggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    
    const saved = localStorage.getItem('theme');
    if (saved) {
        html.setAttribute('data-theme', saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.setAttribute('data-theme', 'jaklitera-dark');
    }

    if (toggle) {
        toggle.addEventListener('click', function() {
            const current = html.getAttribute('data-theme');
            const next = current === 'jaklitera-dark' ? 'jaklitera' : 'jaklitera-dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }
})();
</script>
</body>
</html>
