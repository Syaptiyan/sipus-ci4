<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto flex flex-col gap-6">
    <h1 class="text-2xl font-bold">Tentang SIPUS</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold"><?= esc($pengaturan['nama_aplikasi'] ?? 'SIPUS') ?></h2>
                <p class="text-sm text-base-content/60">Versi 3.0</p>
            </div>
        </div>
        <p class="text-base-content/70 leading-relaxed mb-4">
            SIPUS (Sistem Informasi Perpustakaan) adalah platform manajemen perpustakaan digital yang dirancang untuk memudahkan pengelolaan koleksi buku, transaksi peminjaman dan pengembalian, serta pembuatan laporan secara cepat dan akurat.
        </p>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50 uppercase tracking-wider">Teknologi</p>
                <p class="text-sm font-semibold mt-1">CodeIgniter 4 + Tailwind CSS + Alpine.js</p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50 uppercase tracking-wider">Versi</p>
                <p class="text-sm font-semibold mt-1">3.0 (2026)</p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50 uppercase tracking-wear">Developer</p>
                <p class="text-sm font-semibold mt-1">adee.razer</p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50 uppercase tracking-wider">Lisensi</p>
                <p class="text-sm font-semibold mt-1">Open Source</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
