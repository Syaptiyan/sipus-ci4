<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Riwayat Backup</h1>
        <a href="<?= base_url('backup') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>File</th>
                    <th>Ukuran</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($backups)): ?>
                    <tr><td colspan="5" class="text-center">Belum ada backup.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($backups as $b): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-sm"><?= format_datetime($b['created_at']) ?></td>
                            <td class="font-mono text-xs"><?= esc($b['filename']) ?></td>
                            <td class="text-sm"><?= number_format($b['ukuran'] / 1024, 1) ?> KB</td>
                            <td class="text-sm"><?= esc($b['nama']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pager_links)): ?>
        <div class="flex justify-center"><?= $pager_links ?></div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
