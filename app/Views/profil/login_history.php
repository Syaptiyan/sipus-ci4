<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Riwayat Login</h1>
        <a href="<?= base_url('profil') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>IP Address</th>
                    <th>Browser</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="5" class="text-center">Belum ada riwayat login.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-sm"><?= format_datetime($h['created_at']) ?></td>
                            <td class="font-mono text-xs"><?= esc($h['ip_address']) ?></td>
                            <td class="text-xs max-w-[200px] truncate"><?= esc($h['user_agent']) ?></td>
                            <td>
                                <?php if ($h['status'] === 'success'): ?>
                                    <span class="badge badge-success badge-sm">Berhasil</span>
                                <?php else: ?>
                                    <span class="badge badge-error badge-sm">Gagal</span>
                                <?php endif; ?>
                            </td>
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
