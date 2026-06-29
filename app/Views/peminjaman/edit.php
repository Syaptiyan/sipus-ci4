<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<?php
$statusBadge = match($peminjaman['status']) {
    'pending'  => 'badge-warning',
    'approved' => 'badge-info',
    'rejected' => 'badge-error',
    'borrowed' => 'badge-accent',
    'returned' => 'badge-success',
    'late'     => 'badge-error',
    'lost'     => 'badge-error',
    'damaged'  => 'badge-warning',
    default    => 'badge-ghost',
};
$statusLabel = match($peminjaman['status']) {
    'pending'  => 'Menunggu Persetujuan',
    'approved' => 'Disetujui',
    'rejected' => 'Ditolak',
    'borrowed' => 'Sedang Dipinjam',
    'returned' => 'Sudah Dikembalikan',
    'late'     => 'Terlambat',
    'lost'     => 'Hilang',
    'damaged'  => 'Rusak',
    default    => ucfirst($peminjaman['status']),
};
?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Edit Peminjaman</h1>
        <a href="<?= base_url('peminjaman/' . $peminjaman['id']) ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <form action="<?= base_url('peminjaman/' . $peminjaman['id']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-base-content/60">Kode Peminjaman</p>
                    <p class="font-semibold"><?= esc($peminjaman['kode_peminjaman']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Status</p>
                    <span class="badge <?= $statusBadge ?>"><?= $statusLabel ?></span>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Anggota</p>
                    <p class="font-semibold"><?= esc($peminjaman['nama_anggota']) ?> (<?= esc($peminjaman['kode_anggota']) ?>)</p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Petugas</p>
                    <p class="font-semibold"><?= esc($peminjaman['nama_petugas']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-base-content/60">Tanggal Pinjam</p>
                    <p class="font-semibold"><?= $peminjaman['tanggal_pinjam'] ? date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])) : '-' ?></p>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal Jatuh Tempo</span>
                    </label>
                    <input type="date" name="tanggal_jatuh_tempo" class="input input-bordered input-sm" value="<?= $peminjaman['tanggal_jatuh_tempo'] ?>">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
            <h3 class="font-bold mb-2">Buku yang Dipinjam</h3>
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($detail)): ?>
                            <tr><td colspan="3" class="text-center">Tidak ada data buku.</td></tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($detail as $d): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($d['isbn']) ?></td>
                                    <td><?= esc($d['judul']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex gap-2 justify-end">
            <a href="<?= base_url('peminjaman/' . $peminjaman['id']) ?>" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
