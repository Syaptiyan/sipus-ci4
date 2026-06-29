<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Riwayat Login</h1>

    <form method="GET" action="<?= base_url('audit/login-history') ?>" class="flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" class="input input-bordered input-sm w-full sm:w-64" placeholder="Cari nama atau username..." value="<?= esc($search ?? '') ?>">
        <select name="status" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="success" <?= ($status ?? '') === 'success' ? 'selected' : '' ?>>Berhasil</option>
            <option value="failed" <?= ($status ?? '') === 'failed' ? 'selected' : '' ?>>Gagal</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Cari</button>
        <?php if ($search || $status): ?>
            <a href="<?= base_url('audit/login-history') ?>" class="btn btn-ghost btn-sm text-base-content/60">✕ Clear</a>
        <?php endif; ?>
    </form>

    <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Nama</th>
                    <th class="hidden md:table-cell">Username</th>
                    <th class="hidden md:table-cell">Role</th>
                    <th class="hidden md:table-cell">IP</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-sm"><?= format_datetime($h['created_at']) ?></td>
                            <td class="font-semibold text-sm"><?= esc($h['nama']) ?></td>
                            <td class="hidden md:table-cell font-mono text-xs"><?= esc($h['username']) ?></td>
                            <td class="hidden md:table-cell"><span class="badge badge-outline badge-sm"><?= esc($h['role']) ?></span></td>
                            <td class="hidden md:table-cell font-mono text-xs"><?= esc($h['ip_address']) ?></td>
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
