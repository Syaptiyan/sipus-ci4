<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Data Denda</h1>
    </div>

    <form method="GET" action="<?= base_url('denda') ?>" x-data="{ search: '<?= esc($search ?? '') ?>' }" class="flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1 max-w-sm">
            <input type="text" name="search" x-model="search" @input.debounce.300ms="$el.form.submit()" class="input input-bordered input-sm w-full pr-8" placeholder="Cari kode peminjaman atau anggota..." value="<?= esc($search ?? '') ?>">
            <?php if ($search || $status): ?>
            <a href="<?= base_url('denda') ?>" class="absolute right-2 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content text-sm">✕</a>
            <?php endif; ?>
        </div>
        <select name="status" class="select select-bordered select-sm w-full sm:w-48" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="Belum Dibayar" <?= ($status ?? '') == 'Belum Dibayar' ? 'selected' : '' ?>>Belum Dibayar</option>
            <option value="Lunas" <?= ($status ?? '') == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="hidden md:table-cell">Kode Peminjaman</th>
                    <th>Anggota</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th class="hidden md:table-cell">Tgl Bayar</th>
                    <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($denda)): ?>
                    <tr><td colspan="<?= in_array($user['role'], ['Admin', 'Petugas']) ? 7 : 6 ?>" class="text-center">Tidak ada data denda.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($denda as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="hidden md:table-cell"><?= esc($d['kode_peminjaman']) ?></td>
                            <td class="max-w-[150px] truncate"><?= esc($d['nama_anggota']) ?></td>
                            <td>Rp <?= number_format($d['jumlah'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($d['status'] == 'Belum Dibayar'): ?>
                                    <span class="badge badge-error badge-sm">Belum Dibayar</span>
                                <?php elseif ($d['status'] == 'Lunas'): ?>
                                    <span class="badge badge-success badge-sm">Lunas</span>
                                <?php endif; ?>
                            </td>
                            <td class="hidden md:table-cell"><?= $d['tanggal_bayar'] ? date('d/m/Y H:i', strtotime($d['tanggal_bayar'])) : '-' ?></td>
                            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
                            <td class="whitespace-nowrap">
                                <div class="flex gap-1">
                                <a href="<?= base_url('denda/' . $d['id']) ?>" class="btn btn-info btn-xs">Detail</a>
                                <?php if ($d['status'] == 'Belum Dibayar'): ?>
                                    <a href="<?= base_url('denda/bayar/' . $d['id']) ?>" class="btn btn-success btn-xs" onclick="event.preventDefault(); if(confirm('Konfirmasi pembayaran denda ini?')) { document.getElementById('bayar-denda-<?= $d['id'] ?>').submit(); }">Bayar</a>
                                    <form id="bayar-denda-<?= $d['id'] ?>" method="POST" action="<?= base_url('denda/bayar/' . $d['id']) ?>" class="hidden">
                                        <?= csrf_field() ?>
                                    </form>
                                <?php endif; ?>
                                <a href="<?= base_url('denda/delete/' . $d['id']) ?>" class="btn btn-error btn-xs" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data denda ini?')) { document.getElementById('delete-denda-<?= $d['id'] ?>').submit(); }">Hapus</a>
                                <form id="delete-denda-<?= $d['id'] ?>" method="POST" action="<?= base_url('denda/delete/' . $d['id']) ?>" class="hidden">
                                    <?= csrf_field() ?>
                                </form>
                                </div>
                            </td>
                            <?php endif; ?>
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
