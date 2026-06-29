<!DOCTYPE html>
<html lang="id" data-theme="jaklitera">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPUS - Sistem Informasi Perpustakaan</title>
    <meta name="description" content="Sistem Informasi Perpustakaan - Kelola perpustakaan lebih mudah dan terintegrasi">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="<?= base_url('assets/css/app.min.css') ?>" as="style">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.min.css') ?>">
    <script defer src="<?= base_url('assets/js/alpine.min.js') ?>"></script>
    <style>
        html { scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }
        body { font-family: 'Mulish', sans-serif; }
        [data-animate] { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        [data-animate].visible { opacity: 1; transform: translateY(0); }
        [data-animate][data-delay="100"] { transition-delay: 0.1s; }
        [data-animate][data-delay="200"] { transition-delay: 0.2s; }
        [data-animate][data-delay="300"] { transition-delay: 0.3s; }
        [data-animate][data-delay="400"] { transition-delay: 0.4s; }
        [data-animate][data-delay="500"] { transition-delay: 0.5s; }
        [data-animate][data-delay="600"] { transition-delay: 0.6s; }
    </style>
</head>
<body class="bg-base-200 antialiased">
<div x-data="{ menuOpen: false }" class="min-h-screen">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-base-300/50 bg-base-100/80 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="#" @click.prevent="document.getElementById('home').scrollIntoView({behavior:'smooth'})" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-base-content">SIPUS</span>
                </a>
                <div class="hidden md:flex items-center gap-1">
                    <a href="#" @click.prevent="document.getElementById('home').scrollIntoView({behavior:'smooth'})" class="px-4 py-2 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200 transition-all">Beranda</a>
                    <a href="#" @click.prevent="document.getElementById('tentang').scrollIntoView({behavior:'smooth'})" class="px-4 py-2 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200 transition-all">Tentang</a>
                    <a href="#" @click.prevent="document.getElementById('fitur').scrollIntoView({behavior:'smooth'})" class="px-4 py-2 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200 transition-all">Fitur</a>
                    <a href="#" @click.prevent="document.getElementById('kontak').scrollIntoView({behavior:'smooth'})" class="px-4 py-2 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200 transition-all">Kontak</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?= base_url('login') ?>" class="btn btn-secondary btn-sm hidden md:inline-flex">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk
                    </a>
                    <button @click="menuOpen = !menuOpen" class="md:hidden btn btn-ghost btn-sm btn-square">
                        <svg x-show="!menuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="menuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="menuOpen" x-cloak @click.outside="menuOpen = false" class="md:hidden border-t border-base-300/50 bg-base-100">
            <div class="px-4 py-3 space-y-1">
                <a href="#" @click.prevent="menuOpen = false; document.getElementById('home').scrollIntoView({behavior:'smooth'})" class="block px-4 py-2.5 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200">Beranda</a>
                <a href="#" @click.prevent="menuOpen = false; document.getElementById('tentang').scrollIntoView({behavior:'smooth'})" class="block px-4 py-2.5 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200">Tentang</a>
                <a href="#" @click.prevent="menuOpen = false; document.getElementById('fitur').scrollIntoView({behavior:'smooth'})" class="block px-4 py-2.5 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200">Fitur</a>
                <a href="#" @click.prevent="menuOpen = false; document.getElementById('kontak').scrollIntoView({behavior:'smooth'})" class="block px-4 py-2.5 text-sm font-medium rounded-lg text-base-content/70 hover:text-base-content hover:bg-base-200">Kontak</a>
                <a href="<?= base_url('login') ?>" class="btn btn-secondary btn-sm w-full mt-2">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section id="home" class="relative pt-28 sm:pt-32 pb-20 sm:pb-28 overflow-hidden bg-gradient-to-br from-base-200 via-white to-base-200">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                <div class="flex-1 text-center lg:text-left" data-animate>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-base-content leading-tight">
                        Perpustakaan Digital
                        <span class="text-primary">Serba Otomatis</span>
                        dalam Genggaman
                    </h1>
                    <p class="mt-6 text-base sm:text-lg text-base-content/60 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Lupakan cara manual. SIPUS menghadirkan pengalaman baru mengelola perpustakaan — dari katalog buku, pengajuan pinjaman online, hingga laporan PDF instan. Semua dalam satu platform modern.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg">
                            Mulai Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#" @click.prevent="document.getElementById('tentang').scrollIntoView({behavior:'smooth'})" class="btn btn-outline btn-lg">Pelajari Dulu</a>
                    </div>
                </div>
                <div class="flex-1 hidden lg:flex justify-center" data-animate data-delay="200">
                    <svg viewBox="0 0 500 400" class="w-full max-w-lg" fill="none">
                        <defs>
                            <linearGradient id="hero-bg" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#063a76" stop-opacity="0.1"/>
                                <stop offset="100%" stop-color="#f85e38" stop-opacity="0.1"/>
                            </linearGradient>
                        </defs>
                        <rect width="500" height="400" rx="20" fill="url(#hero-bg)"/>
                        <rect x="60" y="250" width="380" height="10" rx="4" fill="#063a76" fill-opacity="0.3"/>
                        <rect x="60" y="180" width="380" height="10" rx="4" fill="#063a76" fill-opacity="0.3"/>
                        <rect x="60" y="110" width="380" height="10" rx="4" fill="#063a76" fill-opacity="0.3"/>
                        <rect x="80" y="120" width="30" height="60" rx="3" fill="#063a76" opacity="0.8"/>
                        <rect x="118" y="130" width="25" height="50" rx="3" fill="#f85e38" opacity="0.8"/>
                        <rect x="151" y="115" width="28" height="65" rx="3" fill="#005ac7" opacity="0.8"/>
                        <rect x="187" y="125" width="22" height="55" rx="3" fill="#063a76" opacity="0.6"/>
                        <rect x="217" y="118" width="35" height="62" rx="3" fill="#f85e38" opacity="0.6"/>
                        <rect x="260" y="128" width="24" height="52" rx="3" fill="#005ac7" opacity="0.6"/>
                        <rect x="292" y="120" width="30" height="60" rx="3" fill="#063a76" opacity="0.7"/>
                        <rect x="330" y="135" width="20" height="45" rx="3" fill="#f85e38" opacity="0.5"/>
                        <rect x="358" y="118" width="28" height="62" rx="3" fill="#005ac7" opacity="0.7"/>
                        <rect x="394" y="130" width="26" height="50" rx="3" fill="#063a76" opacity="0.5"/>
                        <rect x="80" y="190" width="35" height="50" rx="3" fill="#f85e38" opacity="0.7"/>
                        <rect x="123" y="200" width="22" height="40" rx="3" fill="#063a76" opacity="0.8"/>
                        <rect x="153" y="188" width="30" height="52" rx="3" fill="#005ac7" opacity="0.7"/>
                        <rect x="191" y="195" width="25" height="45" rx="3" fill="#f85e38" opacity="0.5"/>
                        <rect x="224" y="190" width="28" height="50" rx="3" fill="#063a76" opacity="0.6"/>
                        <rect x="260" y="202" width="32" height="38" rx="3" fill="#005ac7" opacity="0.5"/>
                        <rect x="300" y="188" width="24" height="52" rx="3" fill="#f85e38" opacity="0.6"/>
                        <rect x="332" y="196" width="28" height="44" rx="3" fill="#063a76" opacity="0.7"/>
                        <rect x="368" y="190" width="22" height="50" rx="3" fill="#005ac7" opacity="0.6"/>
                        <rect x="398" y="200" width="22" height="40" rx="3" fill="#f85e38" opacity="0.5"/>
                        <rect x="90" y="260" width="28" height="55" rx="3" fill="#005ac7" opacity="0.7"/>
                        <rect x="126" y="270" width="25" height="45" rx="3" fill="#063a76" opacity="0.6"/>
                        <rect x="159" y="258" width="32" height="57" rx="3" fill="#f85e38" opacity="0.7"/>
                        <rect x="199" y="265" width="20" height="50" rx="3" fill="#005ac7" opacity="0.5"/>
                        <rect x="227" y="260" width="30" height="55" rx="3" fill="#063a76" opacity="0.8"/>
                        <rect x="265" y="272" width="24" height="43" rx="3" fill="#f85e38" opacity="0.6"/>
                        <rect x="297" y="258" width="28" height="57" rx="3" fill="#005ac7" opacity="0.8"/>
                        <rect x="333" y="268" width="22" height="47" rx="3" fill="#063a76" opacity="0.5"/>
                        <rect x="363" y="260" width="35" height="55" rx="3" fill="#f85e38" opacity="0.7"/>
                        <rect x="406" y="275" width="18" height="40" rx="3" fill="#005ac7" opacity="0.5"/>
                        <circle cx="180" cy="70" r="20" fill="#063a76" opacity="0.4"/>
                        <rect x="160" y="85" width="40" height="30" rx="5" fill="#063a76" opacity="0.3"/>
                        <circle cx="420" cy="60" r="8" fill="#f85e38" opacity="0.3"/>
                        <circle cx="450" cy="100" r="5" fill="#063a76" opacity="0.2"/>
                        <circle cx="40" cy="80" r="6" fill="#f85e38" opacity="0.2"/>
                        <circle cx="70" cy="50" r="4" fill="#005ac7" opacity="0.3"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang -->
    <section id="tentang" class="py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">Tentang SIPUS</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-base-content">
                    Kelola Perpustakaan <span class="text-primary">Tanpa Ribet</span>
                </h2>
                <p class="mt-4 text-base sm:text-lg text-base-content/60 leading-relaxed">
                    SIPUS hadir sebagai solusi all-in-one untuk perpustakaan modern. Dari katalog buku, peminjaman online, persetujuan real-time, hingga laporan PDF — semua terintegrasi dalam satu platform yang bisa diakses kapan saja, di mana saja.
                </p>
            </div>
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="flex flex-col items-center gap-3 bg-white rounded-2xl border border-base-200 p-6 sm:p-8" data-animate data-delay="100">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-3xl sm:text-4xl font-extrabold text-primary" data-counter="100" data-suffix="+">0</span>
                    <span class="text-sm text-base-content/60">Judul Buku</span>
                </div>
                <div class="flex flex-col items-center gap-3 bg-white rounded-2xl border border-base-200 p-6 sm:p-8" data-animate data-delay="200">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-3xl sm:text-4xl font-extrabold text-secondary" data-counter="50" data-suffix="+">0</span>
                    <span class="text-sm text-base-content/60">Anggota Terdaftar</span>
                </div>
                <div class="flex flex-col items-center gap-3 bg-white rounded-2xl border border-base-200 p-6 sm:p-8" data-animate data-delay="300">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-3xl sm:text-4xl font-extrabold text-accent" data-counter="500" data-suffix="+">0</span>
                    <span class="text-sm text-base-content/60">Transaksi Berhasil</span>
                </div>
                <div class="flex flex-col items-center gap-3 bg-white rounded-2xl border border-base-200 p-6 sm:p-8" data-animate data-delay="400">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-3xl sm:text-4xl font-extrabold text-primary" data-counter="100" data-suffix="%">0</span>
                    <span class="text-sm text-base-content/60">Laporan Digital</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section class="py-16 sm:py-24 bg-base-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">Mudah Digunakan</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-base-content">
                    Hanya <span class="text-primary">3 Langkah</span> Saja
                </h2>
                <p class="mt-4 text-base sm:text-lg text-base-content/60 leading-relaxed">
                    Tidak perlu instalasi, tidak perlu training berhari-hari. Siapapun bisa langsung menggunakan SIPUS.
                </p>
            </div>

            <div class="mt-12 grid sm:grid-cols-3 gap-8 relative">
                <div class="hidden sm:block absolute top-16 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-primary/30 via-primary to-primary/30"></div>
                <div class="flex flex-col items-center text-center" data-animate data-delay="100">
                    <div class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold mb-4 shadow-lg shadow-primary/30 relative z-10">1</div>
                    <h3 class="text-lg font-bold text-base-content mb-2">Cari & Pilih Buku</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Jelajahi katalog 100+ judul buku. Filter berdasarkan kategori, penulis, atau penerbit. Cek stok tersedia secara real-time.</p>
                </div>
                <div class="flex flex-col items-center text-center" data-animate data-delay="300">
                    <div class="w-14 h-14 rounded-full bg-secondary text-white flex items-center justify-center text-xl font-bold mb-4 shadow-lg shadow-secondary/30 relative z-10">2</div>
                    <h3 class="text-lg font-bold text-base-content mb-2">Ajukan & Disetujui</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Klik "Ajukan Peminjaman", petugas langsung dapat notifikasi. Status pengajuan bisa dipantau dari dashboard — pending, disetujui, atau ditolak.</p>
                </div>
                <div class="flex flex-col items-center text-center" data-animate data-delay="500">
                    <div class="w-14 h-14 rounded-full bg-accent text-white flex items-center justify-center text-xl font-bold mb-4 shadow-lg shadow-accent/30 relative z-10">3</div>
                    <h3 class="text-lg font-bold text-base-content mb-2">Ambil, Baca, Kembalikan</h3>
                    <p class="text-sm text-base-content/60 leading-relaxed">Ambil buku di perpustakaan. Perpanjang masa pinjam jika butuh waktu lebih. Kembalikan sebelum jatuh tempo — selesai!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="py-16 sm:py-24 bg-base-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-secondary/10 text-secondary text-sm font-medium mb-4">Kenapa SIPUS?</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-base-content">
                    Fitur yang <span class="text-secondary">Membuat Perbedaan</span>
                </h2>
                <p class="mt-4 text-base sm:text-lg text-base-content/60 leading-relaxed">
                    Dirancang dengan teknologi terkini untuk pengalaman terbaik. Setiap fitur dibuat untuk menyelesaikan masalah nyata di perpustakaan Anda.
                </p>
            </div>
            <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white border border-base-200 rounded-2xl p-6 sm:p-8 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-animate data-delay="100">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Kilat & Tanpa Ribet</h3>
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">Cari buku, ajukan pinjaman, dan proses pengembalian dalam hitungan detik. Tidak perlu antri.</p>
                </div>
                <div class="bg-white border border-base-200 rounded-2xl p-6 sm:p-8 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-animate data-delay="200">
                    <div class="w-14 h-14 rounded-2xl bg-secondary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Aman & Terkontrol</h3>
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">Akses dibatasi per role — Admin, Petugas, dan Anggota punya hak akses masing-masing. Data Anda terlindungi.</p>
                </div>
                <div class="bg-white border border-base-200 rounded-2xl p-6 sm:p-8 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-animate data-delay="300">
                    <div class="w-14 h-14 rounded-2xl bg-accent/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Bisa dari Mana Saja</h3>
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">Tampilan sempurna di HP, tablet, dan desktop. Pantau peminjaman dan ajukan buku dari genggaman tangan.</p>
                </div>
                <div class="bg-white border border-base-200 rounded-2xl p-6 sm:p-8 text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300" data-animate data-delay="400">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-base-content">Laporan Sekali Klik</h3>
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">Generate laporan buku, anggota, transaksi, dan denda dalam format PDF profesional. Siap cetak, siap presentasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-secondary/10 text-secondary text-sm font-medium mb-4">Testimoni</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-base-content">
                    Dipercaya <span class="text-secondary">Ribuan Pengguna</span>
                </h2>
                <p class="mt-4 text-base sm:text-lg text-base-content/60 leading-relaxed">
                    Lihat apa kata mereka yang sudah merasakan kemudahan SIPUS.
                </p>
            </div>

            <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-base-200 p-6 hover:shadow-md transition-all" data-animate data-delay="100">
                    <div class="flex gap-1 mb-3">
                        <span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span>
                    </div>
                    <p class="text-sm text-base-content/70 leading-relaxed mb-4">"SIPUS benar-benar mengubah cara kami mengelola perpustakaan. Dulu proses peminjaman butuh waktu 10 menit, sekarang kurang dari 1 menit. Luar biasa!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">RW</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">Rina Wijaya</p>
                            <p class="text-xs text-base-content/50">Kepala Perpustakaan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-base-200 p-6 hover:shadow-md transition-all" data-animate data-delay="200">
                    <div class="flex gap-1 mb-3">
                        <span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span>
                    </div>
                    <p class="text-sm text-base-content/70 leading-relaxed mb-4">"Sebagai petugas, fitur approve/reject peminjaman sangat membantu. Saya bisa langsung tahu ada pengajuan baru dari notifikasi. Tidak ada lagi peminjaman yang terlewat."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold text-sm">DL</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">Dewi Lestari</p>
                            <p class="text-xs text-base-content/50">Petugas Perpustakaan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-base-200 p-6 hover:shadow-md transition-all" data-animate data-delay="300">
                    <div class="flex gap-1 mb-3">
                        <span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span><span class="text-amber-400">★</span>
                    </div>
                    <p class="text-sm text-base-content/70 leading-relaxed mb-4">"Saya bisa cek buku yang tersedia dari HP, langsung ajukan pinjaman, dan dapat notifikasi saat disetujui. Praktis banget, tidak perlu ke perpustakaan dua kali!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center text-accent font-bold text-sm">AP</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">Andi Prasetyo</p>
                            <p class="text-xs text-base-content/50">Anggota Perpustakaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 sm:py-24 bg-base-200/50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 text-primary text-sm font-medium mb-4">FAQ</div>
                <h2 class="text-3xl sm:text-4xl font-bold text-base-content">
                    Pertanyaan <span class="text-primary">Umum</span>
                </h2>
            </div>

            <div class="space-y-3">
                <div class="bg-white rounded-xl border border-base-200 overflow-hidden" data-animate data-delay="100" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="font-semibold text-sm text-base-content">Apakah SIPUS gratis?</span>
                        <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                        Ya, SIPUS adalah sistem open source yang bisa digunakan secara gratis. Tidak ada biaya langganan, tidak ada fitur yang dikunci. Semua fitur bisa digunakan sepenuhnya.
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-base-200 overflow-hidden" data-animate data-delay="150" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="font-semibold text-sm text-base-content">Bagaimana cara mendaftar sebagai anggota?</span>
                        <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                        Hubungi petugas perpustakaan untuk pendaftaran. Admin akan membuatkan akun anggota yang bisa langsung digunakan untuk mengakses katalog dan mengajukan peminjaman.
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-base-200 overflow-hidden" data-animate data-delay="200" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="font-semibold text-sm text-base-content">Berapa lama masa peminjaman?</span>
                        <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                        Masa pinjam default adalah 7 hari dan bisa diperpanjang 1 kali. Jika terlambat, sistem akan menghitung denda otomatis berdasarkan jumlah hari keterlambatan.
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-base-200 overflow-hidden" data-animate data-delay="250" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="font-semibold text-sm text-base-content">Bisakah saya meminjam jika stok buku habis?</span>
                        <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                        Bisa! Anda bisa masuk antrian (queue) untuk buku yang stoknya habis. Saat buku dikembalikan oleh peminjam sebelumnya, Anda akan mendapat notifikasi otomatis dan memiliki waktu 24 jam untuk konfirmasi.
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-base-200 overflow-hidden" data-animate data-delay="300" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-4 text-left">
                        <span class="font-semibold text-sm text-base-content">Apakah data saya aman di SIPUS?</span>
                        <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                        Sangat aman. SIPUS menggunakan proteksi CSRF, session terenkripsi, password hashing bcrypt, dan akses berbasis role. Setiap aksi tercatat di log aktivitas untuk audit trail.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 sm:py-24" data-animate>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-primary to-accent rounded-3xl p-10 sm:p-16 relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                </div>
                <div class="relative">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white">Tunggu Apa Lagi?</h2>
                    <p class="mt-4 text-lg text-white/80 max-w-2xl mx-auto">Ribuan buku menunggu untuk dikelola. Ratusan anggota menunggu pelayanan terbaik. Mulai transformasi perpustakaan Anda sekarang.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="<?= base_url('login') ?>" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-none">Masuk Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-gradient-to-br from-primary to-accent text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">SIPUS</h3>
                            <p class="text-sm text-white/70">Sistem Informasi Perpustakaan</p>
                        </div>
                    </div>
                    <p class="text-sm text-white/80 leading-relaxed max-w-md">
                        Platform manajemen perpustakaan digital terintegrasi yang dirancang untuk memudahkan pengelolaan koleksi buku, transaksi peminjaman, pengembalian, dan pembuatan laporan secara cepat dan akurat.
                    </p>
                    <div class="flex gap-3 mt-6">
                        <a href="https://instagram.com/adee.razer" target="_blank" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                        <a href="mailto:adee.razer@email.com" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-white/70">
                        <li><a href="#" @click.prevent="document.getElementById('home').scrollIntoView({behavior:'smooth'})" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('tentang').scrollIntoView({behavior:'smooth'})" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('fitur').scrollIntoView({behavior:'smooth'})" class="hover:text-white transition-colors">Fitur Unggulan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-white">Kontak</h4>
                    <ul class="space-y-3 text-sm text-white/70">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Merdeka No. 123, Jakarta Pusat, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@perpus.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-sm text-white/50">&copy; <?= date('Y') ?> SIPUS. All rights reserved.</p>
                <p class="text-sm text-white/50">Dikembangkan dengan <span class="text-secondary">&hearts;</span> oleh <strong class="text-white/80">adee.razer</strong></p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-animate]').forEach(function(el) {
            observer.observe(el);
        });

        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-counter'));
            const suffix = el.getAttribute('data-suffix') || '';
            const duration = 1500;
            const step = target / (duration / 16);
            let current = 0;
            const timer = setInterval(function() {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(current) + suffix;
            }, 16);
        }

        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-counter]').forEach(function(el) {
            counterObserver.observe(el);
        });
    });
    </script>

</div>
</body>
</html>
