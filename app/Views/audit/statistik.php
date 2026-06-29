<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Statistik Aktivitas Pengguna</h1>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Total Aktivitas</p>
            <p class="text-2xl font-bold text-primary mt-1"><?= number_format($total_aktivitas) ?></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Login Hari Ini</p>
            <p class="text-2xl font-bold text-success mt-1"><?= $total_login_hari_ini ?></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Login Gagal Hari Ini</p>
            <p class="text-2xl font-bold text-error mt-1"><?= $total_login_gagal_hari_ini ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-4">
        <h3 class="font-bold mb-3">Top 10 Pengguna Paling Aktif</h3>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Total Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top_users as $i => $u): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="font-semibold"><?= esc($u['nama']) ?></td>
                    <td><span class="badge badge-outline badge-sm"><?= esc($u['role']) ?></span></td>
                    <td><?= number_format($u['total']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
