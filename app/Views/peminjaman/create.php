<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Peminjaman Baru</h1>

    <form method="POST" action="<?= base_url('peminjaman') ?>" class="flex flex-col gap-3 max-w-2xl">
        <?= csrf_field() ?>

        <div class="form-control">
            <label class="label"><span class="label-text">Anggota</span></label>
            <select name="id_anggota" class="select select-bordered" required>
                <option value="">-- Pilih Anggota --</option>
                <?php foreach ($anggota as $a): ?>
                    <option value="<?= $a['id'] ?>"><?= esc($a['kode_anggota']) ?> - <?= esc($a['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text">Tanggal Pinjam</span></label>
            <input type="date" name="tanggal_pinjam" class="input input-bordered" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text">Pilih Buku</span>
                <span class="label-text-alt">Maksimal <?= $settings['maks_pinjam'] ?? 3 ?> buku</span>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto border border-base-300 rounded-box p-2">
                <?php if (empty($buku)): ?>
                    <p class="text-sm text-base-content/60 col-span-full">Tidak ada buku tersedia.</p>
                <?php else: ?>
                    <?php foreach ($buku as $b): ?>
                        <label class="flex items-center gap-2 p-2 hover:bg-base-200 rounded-lg cursor-pointer">
                            <input type="checkbox" name="id_buku[]" value="<?= $b['id'] ?>" class="checkbox checkbox-sm">
                            <span class="text-sm"><?= esc($b['judul']) ?> <span class="text-base-content/50">(stok: <?= $b['stok_tersedia'] ?>)</span></span>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="alert alert-info shadow-sm text-sm">
            Masa pinjam: <strong><?= $settings['masa_pinjam'] ?? 7 ?> hari</strong> | Maksimal: <strong><?= $settings['maks_pinjam'] ?? 3 ?> buku</strong>
        </div>

        <div class="flex gap-2 mt-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
