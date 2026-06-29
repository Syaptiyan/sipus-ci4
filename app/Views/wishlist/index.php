<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Wishlist Buku</h1>
        <?php if ($user['role'] === 'Anggota'): ?>
        <a href="<?= base_url('wishlist/create') ?>" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Request Buku
        </a>
        <?php endif; ?>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th class="hidden md:table-cell">Pengarang</th>
                    <?php if ($user['role'] !== 'Anggota'): ?>
                    <th>Anggota</th>
                    <?php endif; ?>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($wishlist)): ?>
                    <tr><td colspan="<?= $user['role'] !== 'Anggota' ? 6 : 5 ?>" class="text-center">Belum ada wishlist.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($wishlist as $w): ?>
                        <?php
                        $badge = match($w['status']) {
                            'pending'  => 'badge-warning',
                            'approved' => 'badge-success',
                            'rejected' => 'badge-error',
                            default    => 'badge-ghost',
                        };
                        $label = match($w['status']) {
                            'pending'  => 'Menunggu',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            default    => ucfirst($w['status']),
                        };
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="max-w-[200px] truncate"><?= esc($w['judul_buku']) ?></td>
                            <td class="hidden md:table-cell"><?= esc($w['pengarang'] ?? '-') ?></td>
                            <?php if ($user['role'] !== 'Anggota'): ?>
                            <td><?= esc($w['nama_anggota']) ?></td>
                            <?php endif; ?>
                            <td><span class="badge <?= $badge ?> badge-sm"><?= $label ?></span></td>
                            <td>
                                <div class="flex gap-1">
                                    <?php if ($user['role'] !== 'Anggota' && $w['status'] === 'pending'): ?>
                                    <form method="POST" action="<?= base_url('wishlist/' . $w['id'] . '/proses') ?>" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Setujui request ini?')">Setujui</button>
                                    </form>
                                    <form method="POST" action="<?= base_url('wishlist/' . $w['id'] . '/proses') ?>" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-error btn-xs" onclick="return confirm('Tolak request ini?')">Tolak</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($w['catatan_admin']): ?>
                                    <span class="text-xs text-base-content/50"><?= esc($w['catatan_admin']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pager_links)): ?>
        <div class="flex justify-center">
            <?= $pager_links ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
