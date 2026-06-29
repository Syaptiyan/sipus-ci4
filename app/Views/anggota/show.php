<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Anggota</h1>
        <div class="flex gap-2">
            <a href="<?= base_url('anggota/' . $anggota['id'] . '/kartu') ?>" class="btn btn-primary btn-sm" target="_blank">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Kartu
            </a>
            <a href="<?= base_url('anggota/' . $anggota['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="<?= base_url('anggota') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Kode Anggota</p>
                <p class="font-semibold"><?= esc($anggota['kode_anggota']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Nama</p>
                <p class="font-semibold"><?= esc($anggota['nama']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Jenis Kelamin</p>
                <p class="font-semibold"><?= $anggota['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tempat, Tanggal Lahir</p>
                <p class="font-semibold"><?= esc($anggota['tempat_lahir'] ?? '-') ?><?= $anggota['tanggal_lahir'] ? ', ' . date('d/m/Y', strtotime($anggota['tanggal_lahir'])) : '' ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Telepon</p>
                <p class="font-semibold"><?= esc($anggota['telp'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Email</p>
                <p class="font-semibold"><?= esc($anggota['email'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Aktif</p>
                <p class="font-semibold"><?= $anggota['tanggal_aktif'] ? date('d/m/Y', strtotime($anggota['tanggal_aktif'])) : '-' ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Masa Aktif Hingga</p>
                <p class="font-semibold">
                    <?php if ($anggota['tanggal_expired']): ?>
                        <?php if (strtotime($anggota['tanggal_expired']) < time()): ?>
                            <span class="text-error">Expired (<?= date('d/m/Y', strtotime($anggota['tanggal_expired'])) ?>)</span>
                        <?php else: ?>
                            <span class="text-success"><?= date('d/m/Y', strtotime($anggota['tanggal_expired'])) ?></span>
                            <span class="text-xs text-base-content/50 ml-1">(<?= floor((strtotime($anggota['tanggal_expired']) - time()) / 86400) ?> hari lagi)</span>
                        <?php endif; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <?php if ($anggota['alamat']): ?>
        <div class="mt-4">
            <p class="text-sm text-base-content/60 mb-1">Alamat</p>
            <p class="text-sm"><?= esc($anggota['alamat']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
