<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Data Pengguna</h1>
        <div class="flex gap-2">
            <a href="<?= base_url('user/pending') ?>" class="btn btn-warning btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Menunggu Aktivasi
            </a>
            <a href="<?= base_url('user/new') ?>" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th class="hidden md:table-cell">Email</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                <?php else: ?>
                    <?php $no = 1 + (($currentPage - 1) * $perPage); ?>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="font-mono text-xs"><?= esc($u['username']) ?></td>
                        <td class="hidden md:table-cell text-sm"><?= esc($u['email']) ?></td>
                        <td class="font-semibold text-sm"><?= esc($u['nama']) ?></td>
                        <td>
                            <span class="badge badge-sm <?= $u['role'] === 'Admin' ? 'badge-primary' : ($u['role'] === 'Petugas' ? 'badge-secondary' : 'badge-ghost') ?>">
                                <?= $u['role'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($u['active']): ?>
                                <span class="badge badge-sm badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-sm badge-error">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <a href="<?= base_url('user/' . $u['id'] . '/edit') ?>" class="btn btn-warning btn-xs">Edit</a>
                                <?php if ($u['id'] != session()->get('user')['id']): ?>
                                    <a href="<?= base_url('user/' . $u['id'] . '/toggle-active') ?>" class="btn <?= $u['active'] ? 'btn-ghost' : 'btn-success' ?> btn-xs" onclick="return confirm('<?= $u['active'] ? 'Nonaktifkan' : 'Aktifkan' ?> akun ini?')">
                                        <?= $u['active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                                    </a>
                                    <a href="<?= base_url('user/delete/' . $u['id']) ?>" class="btn btn-error btn-xs" onclick="event.preventDefault(); if(confirm('Hapus pengguna ini?')) { document.getElementById('del-<?= $u['id'] ?>').submit(); }">Hapus</a>
                                    <form id="del-<?= $u['id'] ?>" method="POST" action="<?= base_url('user/delete/' . $u['id']) ?>" class="hidden"><?= csrf_field() ?></form>
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
        <div class="flex justify-center"><?= $pager_links ?></div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
