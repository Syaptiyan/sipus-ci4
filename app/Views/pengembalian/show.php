<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Pengembalian</h1>
        <div class="flex gap-2">
            <a href="<?= base_url('pengembalian') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Kode Pengembalian</p>
                <p class="font-semibold"><?= esc($pengembalian['kode_pengembalian']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Kode Peminjaman</p>
                <p class="font-semibold"><?= esc($pengembalian['kode_peminjaman']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Anggota</p>
                <p class="font-semibold"><?= esc($pengembalian['nama_anggota']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Petugas</p>
                <p class="font-semibold"><?= esc($pengembalian['nama_petugas']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Kembali</p>
                <p class="font-semibold"><?= date('d/m/Y', strtotime($pengembalian['tanggal_kembali'])) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Denda</p>
                <p class="font-semibold">Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
