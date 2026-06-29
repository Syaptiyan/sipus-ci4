<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Data Pengembalian</h1>
        <a href="<?= base_url('pengembalian/new') ?>" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Pengembalian Baru
        </a>
    </div>

    <form method="GET" action="<?= base_url('pengembalian') ?>" x-data="{ search: '<?= esc($search ?? '') ?>' }" class="flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1 max-w-sm">
            <input type="text" name="search" x-model="search" @input.debounce.300ms="$el.form.submit()" class="input input-bordered input-sm w-full pr-8" placeholder="Cari kode pengembalian, anggota..." value="<?= esc($search ?? '') ?>">
            <?php if ($search): ?>
            <a href="<?= base_url('pengembalian') ?>" class="absolute right-2 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content text-sm">✕</a>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-outline btn-sm">Cari</button>
    </form>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pengembalian</th>
                    <th class="hidden md:table-cell">Kode Peminjaman</th>
                    <th>Anggota</th>
                    <th class="hidden md:table-cell">Petugas</th>
                    <th class="hidden md:table-cell">Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengembalian)): ?>
                    <tr><td colspan="8" class="text-center">Tidak ada data pengembalian.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($pengembalian as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($p['kode_pengembalian']) ?></td>
                            <td class="hidden md:table-cell"><?= esc($p['kode_peminjaman']) ?></td>
                            <td class="max-w-[150px] truncate"><?= esc($p['nama_anggota']) ?></td>
                            <td class="hidden md:table-cell"><?= esc($p['nama_petugas']) ?></td>
                            <td class="hidden md:table-cell"><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></td>
                            <td>Rp <?= number_format($p['denda'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?= base_url('pengembalian/' . $p['id']) ?>" class="btn btn-info btn-xs">Detail</a>
                                <a href="<?= base_url('pengembalian/delete/' . $p['id']) ?>" class="btn btn-error btn-xs" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus data pengembalian ini?')) { document.getElementById('delete-kembali-<?= $p['id'] ?>').submit(); }">Hapus</a>
                                <form id="delete-kembali-<?= $p['id'] ?>" method="POST" action="<?= base_url('pengembalian/delete/' . $p['id']) ?>" class="hidden">
                                    <?= csrf_field() ?>
                                </form>
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
