<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Data Peminjaman</h1>
        <div class="flex gap-2">
            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <a href="<?= base_url('peminjaman/new') ?>" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Peminjaman Baru
            </a>
            <?php else: ?>
            <a href="<?= base_url('peminjaman/ajukan') ?>" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajukan Peminjaman
            </a>
            <?php endif; ?>
        </div>
    </div>

    <form method="GET" action="<?= base_url('peminjaman') ?>" x-data="{ search: '<?= esc($search ?? '') ?>' }" class="flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1 max-w-sm">
            <input type="text" name="search" x-model="search" @input.debounce.300ms="$el.form.submit()" class="input input-bordered input-sm w-full pr-8" placeholder="Cari kode atau anggota..." value="<?= esc($search ?? '') ?>">
            <?php if ($search || $status): ?>
            <a href="<?= base_url('peminjaman') ?>" class="absolute right-2 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content text-sm">✕</a>
            <?php endif; ?>
        </div>
        <select name="status" class="select select-bordered select-sm w-full sm:w-48" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <?php foreach ($status_list as $s): ?>
                <option value="<?= $s ?>" <?= ($status ?? '') == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Anggota</th>
                    <th class="hidden md:table-cell">Tgl Pengajuan</th>
                    <th class="hidden md:table-cell">Tgl Pinjam</th>
                    <th class="hidden md:table-cell">Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjaman)): ?>
                    <tr><td colspan="8" class="text-center">Tidak ada data peminjaman.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($peminjaman as $p): ?>
                        <?php
                        $badge = match($p['status']) {
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
                        $label = match($p['status']) {
                            'pending'  => 'Pending',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            'borrowed' => 'Dipinjam',
                            'returned' => 'Dikembalikan',
                            'late'     => 'Terlambat',
                            'lost'     => 'Hilang',
                            'damaged'  => 'Rusak',
                            default    => $p['status'],
                        };
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="font-mono text-xs"><?= esc($p['kode_peminjaman']) ?></td>
                            <td class="max-w-[150px] truncate"><?= esc($p['nama_anggota']) ?></td>
                            <td class="hidden md:table-cell"><?= $p['tanggal_pengajuan'] ? date('d/m/Y', strtotime($p['tanggal_pengajuan'])) : '-' ?></td>
                            <td class="hidden md:table-cell"><?= $p['tanggal_pinjam'] ? date('d/m/Y', strtotime($p['tanggal_pinjam'])) : '-' ?></td>
                            <td class="hidden md:table-cell"><?= $p['tanggal_jatuh_tempo'] ? date('d/m/Y', strtotime($p['tanggal_jatuh_tempo'])) : '-' ?></td>
                            <td><span class="badge <?= $badge ?> badge-sm"><?= $label ?></span></td>
                            <td class="whitespace-nowrap">
                                <div class="flex gap-1">
                                    <a href="<?= base_url('peminjaman/' . $p['id']) ?>" class="btn btn-info btn-xs">Detail</a>
                                    <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
                                        <?php if ($p['status'] === 'pending'): ?>
                                            <form method="POST" action="<?= base_url('peminjaman/' . $p['id'] . '/setujui') ?>" class="inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Setujui?')">Setujui</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if (in_array($p['status'], ['borrowed', 'late'])): ?>
                                            <a href="<?= base_url('peminjaman/' . $p['id'] . '/edit') ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <?php endif; ?>
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
