<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Daftar Rak</h3>
            <a href="<?= base_url('rak/new') ?>" class="btn btn-primary btn-sm">Tambah</a>
        </div>

        <form action="" method="GET" class="mb-4">
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="search" class="input input-bordered input-sm w-full sm:max-w-xs" placeholder="Cari rak..." value="<?= $search ?? '' ?>">
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($rak as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $r['nama'] ?></td>
                        <td>
                            <a href="<?= base_url('rak/' . $r['id']) ?>" class="btn btn-info btn-xs">Detail</a>
                            <a href="<?= base_url('rak/' . $r['id'] . '/edit') ?>" class="btn btn-warning btn-xs">Edit</a>
                            <form action="<?= base_url('rak/delete/' . $r['id']) ?>" method="post" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-error btn-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($rak)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($pager_links)): ?>
        <div class="mt-4 flex justify-center">
            <?= $pager_links ?>
        </div>
        <?php endif; ?>
</div>
<?= $this->endSection() ?>
