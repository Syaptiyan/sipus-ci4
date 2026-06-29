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
        <h1 class="text-2xl font-bold">Detail Peminjaman</h1>
        <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="badge <?= $statusBadge ?> badge-lg"><?= $statusLabel ?></span>
            <span class="text-sm text-base-content/50"><?= esc($peminjaman['kode_peminjaman']) ?></span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Anggota</p>
                <p class="font-semibold"><?= esc($peminjaman['nama_anggota']) ?> (<?= esc($peminjaman['kode_anggota']) ?>)</p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Diajukan Oleh</p>
                <p class="font-semibold"><?= esc($peminjaman['nama_petugas'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Pengajuan</p>
                <p class="font-semibold"><?= $peminjaman['tanggal_pengajuan'] ? date('d/m/Y', strtotime($peminjaman['tanggal_pengajuan'])) : '-' ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Disetujui Oleh</p>
                <p class="font-semibold"><?= esc($peminjaman['nama_petugas_approve'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Pinjam</p>
                <p class="font-semibold"><?= $peminjaman['tanggal_pinjam'] ? date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])) : '-' ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Jatuh Tempo</p>
                <p class="font-semibold"><?= $peminjaman['tanggal_jatuh_tempo'] ? date('d/m/Y', strtotime($peminjaman['tanggal_jatuh_tempo'])) : '-' ?></p>
            </div>
            <?php if ($peminjaman['tanggal_dikembalikan']): ?>
            <div>
                <p class="text-sm text-base-content/60">Tanggal Dikembalikan</p>
                <p class="font-semibold"><?= date('d/m/Y', strtotime($peminjaman['tanggal_dikembalikan'])) ?></p>
            </div>
            <?php endif; ?>
            <?php if ($peminjaman['tanggal_perpanjangan']): ?>
            <div>
                <p class="text-sm text-base-content/60">Diperpanjang Pada</p>
                <p class="font-semibold"><?= date('d/m/Y', strtotime($peminjaman['tanggal_perpanjangan'])) ?></p>
            </div>
            <?php endif; ?>
            <?php if ($peminjaman['alasan_tolak']): ?>
            <div class="sm:col-span-2">
                <p class="text-sm text-base-content/60">Alasan Ditolak</p>
                <p class="font-semibold text-error"><?= esc($peminjaman['alasan_tolak']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="font-bold mb-3">Buku yang <?= in_array($peminjaman['status'], ['returned']) ? 'Dikembalikan' : 'Dipinjam' ?></h3>
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

    <div class="flex flex-wrap gap-2">
        <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <?php if ($peminjaman['status'] === 'pending'): ?>
                <form method="POST" action="<?= base_url('peminjaman/' . $peminjaman['id'] . '/setujui') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini?')">Setujui</button>
                </form>
                <button class="btn btn-error btn-sm" onclick="document.getElementById('tolak-modal').showModal()">Tolak</button>
                <dialog id="tolak-modal" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Tolak Peminjaman</h3>
                        <form method="POST" action="<?= base_url('peminjaman/' . $peminjaman['id'] . '/tolak') ?>" class="mt-4">
                            <?= csrf_field() ?>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Alasan Penolakan</span></label>
                                <textarea name="alasan" class="textarea textarea-bordered" required placeholder="Masukkan alasan penolakan..."></textarea>
                            </div>
                            <div class="modal-action">
                                <button type="button" class="btn btn-ghost" onclick="this.closest('dialog').close()">Batal</button>
                                <button type="submit" class="btn btn-error">Tolak</button>
                            </div>
                        </form>
                    </div>
                    <form method="dialog" class="modal-backdrop"><button>close</button></form>
                </dialog>
            <?php endif; ?>
            <?php if (in_array($peminjaman['status'], ['borrowed', 'late'])): ?>
                <form method="POST" action="<?= base_url('peminjaman/' . $peminjaman['id'] . '/kembali') ?>">
                    <?= csrf_field() ?>
                    <div class="flex gap-2 items-end">
                        <div class="form-control">
                            <input type="date" name="tanggal_kembali" class="input input-bordered input-sm" value="<?= date('Y-m-d') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Proses pengembalian?')">Proses Kembali</button>
                    </div>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($user['role'] === 'Anggota'): ?>
            <?php if ($peminjaman['status'] === 'pending'): ?>
                <form method="POST" action="<?= base_url('peminjaman/' . $peminjaman['id'] . '/batalkan') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-error btn-sm" onclick="return confirm('Batalkan pengajuan ini?')">Batalkan Pengajuan</button>
                </form>
            <?php endif; ?>
            <?php if (in_array($peminjaman['status'], ['borrowed', 'late']) && !$peminjaman['tanggal_perpanjangan']): ?>
                <form method="POST" action="<?= base_url('peminjaman/' . $peminjaman['id'] . '/perpanjang') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Perpanjang peminjaman ini?')">Perpanjang</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
