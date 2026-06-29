<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Menunggu Aktivasi</h1>
        <a href="<?= base_url('user') ?>" class="btn btn-outline btn-sm">Semua Pengguna</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-sm"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error text-sm"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (empty($pending_users)): ?>
        <div class="bg-white rounded-xl border border-base-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-base-content/50">Tidak ada akun yang menunggu aktivasi.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-base-200 overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Daftar</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($pending_users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-sm"><?= format_datetime($u['created_at']) ?></td>
                            <td class="font-semibold"><?= esc($u['nama']) ?></td>
                            <td class="font-mono text-xs"><?= esc($u['username']) ?></td>
                            <td class="text-sm"><?= esc($u['email']) ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?= base_url('user/' . $u['id'] . '/activate') ?>" class="btn btn-success btn-xs" onclick="return confirm('Aktifkan akun ini?')">
                                        Aktifkan
                                    </a>
                                    <a href="<?= base_url('user/' . $u['id'] . '/edit') ?>" class="btn btn-warning btn-xs">Edit</a>
                                    <a href="<?= base_url('user/delete/' . $u['id']) ?>" class="btn btn-error btn-xs" onclick="event.preventDefault(); if(confirm('Hapus akun ini?')) { document.getElementById('del-<?= $u['id'] ?>').submit(); }">Hapus</a>
                                    <form id="del-<?= $u['id'] ?>" method="POST" action="<?= base_url('user/delete/' . $u['id']) ?>" class="hidden"><?= csrf_field() ?></form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
