<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Buku</h1>
        <div class="flex gap-2">
            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <a href="<?= base_url('buku/' . $buku['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
            <?php endif; ?>
            <a href="<?= base_url('buku') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="flex flex-col sm:flex-row gap-6">
            <?php if (!empty($buku['isbn'])): ?>
            <div class="shrink-0">
                <img src="https://covers.openlibrary.org/b/isbn/<?= esc($buku['isbn']) ?>-L.jpg"
                     alt="<?= esc($buku['judul']) ?>"
                     loading="lazy"
                     class="w-40 h-56 object-cover rounded-lg shadow-md border border-base-200 bg-base-200"
                     onload="if(this.naturalWidth < 50) this.style.display='none'; this.nextElementSibling.style.display='flex';"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="w-40 h-56 bg-base-200 rounded-lg items-center justify-center border border-base-200" style="display:none;">
                    <div class="text-center">
                        <svg class="w-10 h-10 text-base-content/20 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-xs text-base-content/30">Tanpa Cover</p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="shrink-0">
                <div class="w-40 h-56 bg-base-200 rounded-lg flex items-center justify-center border border-base-200">
                    <div class="text-center">
                        <svg class="w-10 h-10 text-base-content/20 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-xs text-base-content/30">Tanpa Cover</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-base-content/60">ISBN</p>
                    <p class="font-semibold font-mono text-sm"><?= esc($buku['isbn'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Judul</p>
                    <p class="font-semibold"><?= esc($buku['judul']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Kategori</p>
                    <p class="font-semibold"><?= esc($buku['nama_kategori'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Penulis</p>
                    <p class="font-semibold"><?= esc($buku['nama_penulis'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Penerbit</p>
                    <p class="font-semibold"><?= esc($buku['nama_penerbit'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Rak</p>
                    <p class="font-semibold"><?= esc($buku['nama_rak'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Tahun Terbit</p>
                    <p class="font-semibold"><?= esc($buku['tahun_terbit'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Jumlah Halaman</p>
                    <p class="font-semibold"><?= $buku['jumlah_halaman'] ?? '-' ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Bahasa</p>
                    <p class="font-semibold"><?= esc($buku['bahasa'] ?? 'Indonesia') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Edisi</p>
                    <p class="font-semibold"><?= esc($buku['edisi'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Stok</p>
                    <p class="font-semibold"><?= $buku['stok'] ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Stok Tersedia</p>
                    <p class="font-semibold">
                        <?php if ($buku['stok_tersedia'] > 0): ?>
                            <span class="badge badge-success badge-sm"><?= $buku['stok_tersedia'] ?></span>
                        <?php else: ?>
                            <span class="badge badge-error badge-sm">Kosong</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <?php if ($buku['deskripsi']): ?>
        <div class="mt-5 pt-5 border-t border-base-200">
            <p class="text-sm text-base-content/60 mb-2">Deskripsi</p>
            <p class="text-sm leading-relaxed"><?= esc($buku['deskripsi']) ?></p>
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($buku['isbn'])): ?>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="font-bold text-sm mb-3">Barcode & QR Code</h3>
        <div class="flex flex-wrap items-start gap-6">
            <div class="flex flex-col items-center gap-2">
                <svg class="barcode-<?= esc($buku['id']) ?>"></svg>
                <p class="text-xs text-base-content/40 font-mono"><?= esc($buku['isbn']) ?></p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= urlencode($buku['isbn']) ?>&bgcolor=ffffff&color=063a76"
                     alt="QR Code"
                     class="w-24 h-24 rounded-lg border border-base-200">
                <p class="text-xs text-base-content/40 font-mono">QR Code</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($user['role'] === 'Anggota'): ?>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="flex flex-wrap gap-2">
            <?php if ($buku['stok_tersedia'] > 0): ?>
                <a href="<?= base_url('peminjaman/ajukan?id_buku=' . $buku['id']) ?>" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Ajukan Peminjaman
                </a>
            <?php else: ?>
                <form method="POST" action="<?= base_url('peminjaman/antrian/' . $buku['id']) ?>">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Masuk Antrian
                </button>
            </form>
        <?php endif; ?>
        <form method="POST" action="<?= base_url('favorit/' . $buku['id']) ?>">
            <?= csrf_field() ?>
            <?php if (!empty($is_favorited)): ?>
                <button type="submit" class="btn btn-error btn-sm btn-outline">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Hapus dari Favorit
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-outline btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Tambah ke Favorit
                </button>
            <?php endif; ?>
        </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-base-content">Review & Rating</h3>
            <div class="flex items-center gap-2">
                <div class="flex gap-0.5">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-5 h-5 <?= $i <= round($avg_rating) ? 'text-amber-400' : 'text-base-content/20' ?>" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <span class="text-sm font-semibold text-base-content"><?= $avg_rating ?>/5</span>
                <span class="text-xs text-base-content/50">(<?= $total_review ?> review)</span>
            </div>
        </div>

        <?php if ($user['role'] === 'Anggota' && empty($sudah_review)): ?>
        <form method="POST" action="<?= base_url('buku/' . $buku['id'] . '/review') ?>" class="mb-6 p-4 bg-base-200/50 rounded-lg">
            <?= csrf_field() ?>
            <p class="text-sm font-semibold mb-3">Beri Review</p>
            <div class="form-control mb-3">
                <label class="label"><span class="label-text text-sm">Rating</span></label>
                <div class="flex gap-1" x-data="{ rating: 0 }">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <button type="button" @click="rating = <?= $i ?>" class="focus:outline-none">
                        <svg class="w-7 h-7 transition-colors" :class="rating >= <?= $i ?> ? 'text-amber-400' : 'text-base-content/20'" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </button>
                    <?php endfor; ?>
                    <input type="hidden" name="rating" :value="rating" required>
                </div>
            </div>
            <div class="form-control mb-3">
                <label class="label"><span class="label-text text-sm">Review (opsional)</span></label>
                <textarea name="review" class="textarea textarea-bordered textarea-sm" rows="3" placeholder="Tulis pendapat Anda tentang buku ini..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Kirim Review</button>
        </form>
        <?php endif; ?>

        <?php if (empty($reviews)): ?>
            <p class="text-sm text-base-content/40 text-center py-4">Belum ada review.</p>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($reviews as $r): ?>
                <div class="p-3 bg-base-200/30 rounded-lg">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                <?= strtoupper(substr($r['nama_anggota'], 0, 1)) ?>
                            </div>
                            <span class="text-sm font-semibold text-base-content"><?= esc($r['nama_anggota']) ?></span>
                        </div>
                        <div class="flex gap-0.5">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 <?= $i <= $r['rating'] ? 'text-amber-400' : 'text-base-content/20' ?>" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if ($r['review']): ?>
                        <p class="text-sm text-base-content/70 mt-1"><?= esc($r['review']) ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-base-content/40 mt-1"><?= format_datetime($r['created_at']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<script src="<?= base_url('assets/js/jsbarcode.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.querySelector('.barcode-<?= esc($buku['id']) ?>');
    if (el) {
        JsBarcode(el, '<?= esc($buku['isbn']) ?>', {
            format: 'CODE128',
            width: 1.5,
            height: 50,
            displayValue: true,
            fontSize: 12,
            margin: 5,
            lineColor: '#063a76',
            background: 'transparent'
        });
    }
});
</script>
<?= $this->endSection() ?>
