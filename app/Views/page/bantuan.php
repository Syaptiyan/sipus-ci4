<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto flex flex-col gap-6">
    <h1 class="text-2xl font-bold">Bantuan & FAQ</h1>

    <div class="space-y-3" x-data="{ open: null }">
        <?php $faqs = [
            ['q' => 'Bagaimana cara mengajukan peminjaman?', 'a' => 'Login sebagai Anggota, buka katalog buku, pilih buku, lalu klik "Ajukan Peminjaman". Petugas akan memproses pengajuan Anda.'],
            ['q' => 'Bagaimana cara memperpanjang masa pinjam?', 'a' => 'Buka halaman Peminjaman, klik detail peminjaman yang sedang berjalan, lalu klik tombol "Perpanjang". Hanya bisa dilakukan 1 kali.'],
            ['q' => 'Apa yang terjadi jika buku terlambat dikembalikan?', 'a' => 'Sistem akan otomatis menghitung denda berdasarkan jumlah hari keterlambatan × denda per hari. Notifikasi akan dikirim ke akun Anda.'],
            ['q' => 'Bagaimana jika stok buku habis?', 'a' => 'Anda bisa masuk ke antrian (queue) dengan klik "Masuk Antrian" di halaman detail buku. Saat buku dikembalikan, Anda akan mendapat notifikasi.'],
            ['q' => 'Bagaimana cara mengubah password?', 'a' => 'Klik profil di pojok kanan atas, pilih "Profil Saya", lalu klik "Ubah Password".'],
            ['q' => 'Bagaimana cara mendapat kartu anggota?', 'a' => 'Login sebagai Anggota, klik "Kartu Saya" di sidebar. Kartu bisa dicetak langsung dari browser.'],
            ['q' => 'Apakah saya bisa request buku baru?', 'a' => 'Ya, buka menu "Wishlist" di sidebar, lalu klik "Request Buku Baru". Admin akan memproses request Anda.'],
        ]; ?>

        <?php foreach ($faqs as $i => $faq): ?>
        <div class="bg-white rounded-xl border border-base-200 overflow-hidden">
            <button @click="open = open === <?= $i ?> ? null : <?= $i ?>" class="w-full flex items-center justify-between p-4 text-left">
                <span class="font-semibold text-sm"><?= esc($faq['q']) ?></span>
                <svg class="w-4 h-4 text-base-content/50 transition-transform" :class="open === <?= $i ?> && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open === <?= $i ?>" x-collapse class="px-4 pb-4 text-sm text-base-content/70 leading-relaxed">
                <?= esc($faq['a']) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
