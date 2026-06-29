<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Ajukan Peminjaman</h1>
        <a href="<?= base_url('buku') ?>" class="btn btn-outline btn-sm">Kembali ke Katalog</a>
    </div>

    <?php if ($buku): ?>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="font-bold mb-3">Buku yang Ingin Dipinjam</h3>
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <table class="text-sm">
                    <tr>
                        <td class="text-base-content/60 py-1 pr-4">Judul</td>
                        <td class="font-semibold"><?= esc($buku['judul']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-base-content/60 py-1 pr-4">ISBN</td>
                        <td class="font-mono text-xs"><?= esc($buku['isbn']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-base-content/60 py-1 pr-4">Kategori</td>
                        <td><?= esc($buku['nama_kategori'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-base-content/60 py-1 pr-4">Penulis</td>
                        <td><?= esc($buku['nama_penulis'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-base-content/60 py-1 pr-4">Stok Tersedia</td>
                        <td>
                            <?php if ($buku['stok_tersedia'] > 0): ?>
                                <span class="badge badge-success badge-sm"><?= $buku['stok_tersedia'] ?></span>
                            <?php else: ?>
                                <span class="badge badge-error badge-sm">Habis</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php if ($buku['stok_tersedia'] < 1): ?>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="alert alert-warning shadow-sm mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div>
                <p class="font-semibold">Stok buku kosong</p>
                <p class="text-sm">Anda bisa masuk antrian untuk mendapat notifikasi saat buku tersedia kembali.</p>
            </div>
        </div>
        <form method="POST" action="<?= base_url('peminjaman/antrian/' . $buku['id']) ?>">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Masuk Antrian
            </button>
        </form>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="alert alert-info shadow-sm mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="font-semibold">Proses Pengajuan</p>
                <p class="text-sm">Pengajuan akan dikirim ke petugas untuk disetujui. Stok belum berkurang sampai disetujui.</p>
            </div>
        </div>
        <form method="POST" action="<?= base_url('peminjaman/ajukan') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id_buku" value="<?= $buku['id'] ?>">
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Kirim pengajuan peminjaman buku ini?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajukan Peminjaman
            </button>
        </form>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="bg-white rounded-xl border border-base-200 p-8 text-center">
        <svg class="w-12 h-12 text-base-content/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <p class="text-base-content/60 mb-4">Pilih buku dari katalog untuk mengajukan peminjaman.</p>
        <a href="<?= base_url('buku') ?>" class="btn btn-primary btn-sm">Lihat Katalog Buku</a>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
