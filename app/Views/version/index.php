<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Riwayat Perubahan Data</h1>

    <form method="GET" class="flex gap-2">
        <select name="tipe" class="select select-bordered select-sm" onchange="this.form.submit()">
            <option value="">Semua Tipe</option>
            <option value="buku" <?= ($tipe ?? '') === 'buku' ? 'selected' : '' ?>>Buku</option>
            <option value="anggota" <?= ($tipe ?? '') === 'anggota' ? 'selected' : '' ?>>Anggota</option>
            <option value="peminjaman" <?= ($tipe ?? '') === 'peminjaman' ? 'selected' : '' ?>>Peminjaman</option>
            <option value="denda" <?= ($tipe ?? '') === 'denda' ? 'selected' : '' ?>>Denda</option>
            <option value="user" <?= ($tipe ?? '') === 'user' ? 'selected' : '' ?>>User</option>
            <option value="setting" <?= ($tipe ?? '') === 'setting' ? 'selected' : '' ?>>Setting</option>
        </select>
    </form>

    <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
        <table class="table table-sm">
            <thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th><th>Tipe</th><th>Keterangan</th></tr></thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $l): ?>
                    <tr>
                        <td class="text-sm whitespace-nowrap"><?= format_datetime($l['created_at']) ?></td>
                        <td class="text-sm font-semibold"><?= esc($l['nama_user'] ?? 'Sistem') ?></td>
                        <td class="text-sm"><?= esc($l['aktivitas']) ?></td>
                        <td><span class="badge badge-outline badge-sm"><?= esc($l['tipe'] ?? '-') ?></span></td>
                        <td class="text-sm text-base-content/60 max-w-[200px] truncate"><?= esc($l['keterangan'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (!empty($pager_links)): ?><div class="flex justify-center"><?= $pager_links ?></div><?php endif; ?>
</div>
<?= $this->endSection() ?>
