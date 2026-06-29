<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Rekomendasi Buku</h1>
    <p class="text-sm text-base-content/60">Buku yang direkomendasikan berdasarkan riwayat peminjaman Anda.</p>

    <?php if (empty($rekomendasi)): ?>
        <div class="bg-white rounded-xl border border-base-200 p-12 text-center">
            <p class="text-base-content/50">Belum ada rekomendasi. Mulai pinjam buku untuk mendapat rekomendasi.</p>
            <a href="<?= base_url('buku') ?>" class="btn btn-primary btn-sm mt-4">Lihat Katalog</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            <?php foreach ($rekomendasi as $b): ?>
            <a href="<?= base_url('buku/' . $b['id']) ?>" class="group bg-white rounded-xl border border-base-200 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <div class="aspect-[3/4] bg-base-200 relative overflow-hidden">
                    <?php if (!empty($b['isbn'])): ?>
                        <img src="https://covers.openlibrary.org/b/isbn/<?= esc($b['isbn']) ?>-L.jpg"
                             alt="<?= esc($b['judul']) ?>"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'">
                    <?php endif; ?>
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-semibold line-clamp-2 group-hover:text-primary transition-colors"><?= esc($b['judul']) ?></h3>
                    <p class="text-xs text-base-content/50 mt-1"><?= esc($b['nama_penulis'] ?? '-') ?></p>
                    <span class="text-xs text-base-content/40"><?= esc($b['nama_kategori'] ?? '-') ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
