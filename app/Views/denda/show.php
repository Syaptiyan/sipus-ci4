<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Denda</h1>
        <div class="flex gap-2">
            <?php if ($denda['status'] === 'Lunas'): ?>
            <a href="<?= base_url('denda/' . $denda['id'] . '/kwitansi') ?>" class="btn btn-primary btn-sm" target="_blank">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Kwitansi
            </a>
            <?php endif; ?>
            <a href="<?= base_url('denda') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Kode Peminjaman</p>
                <p class="font-semibold"><?= esc($denda['kode_peminjaman']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Anggota</p>
                <p class="font-semibold"><?= esc($denda['nama_anggota']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Jumlah Denda</p>
                <p class="font-semibold">Rp <?= number_format($denda['jumlah'], 0, ',', '.') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Status</p>
                <?php if ($denda['status'] == 'Belum Dibayar'): ?>
                    <span class="badge badge-error">Belum Dibayar</span>
                <?php else: ?>
                    <span class="badge badge-success">Lunas</span>
                <?php endif; ?>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Bayar</p>
                <p class="font-semibold"><?= $denda['tanggal_bayar'] ? date('d/m/Y H:i', strtotime($denda['tanggal_bayar'])) : '-' ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
