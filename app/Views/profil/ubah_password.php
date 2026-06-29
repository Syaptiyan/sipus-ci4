<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Ubah Password</h1>
        <a href="<?= base_url('profil') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-sm"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error text-sm"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-base-200 p-6 max-w-lg">
        <form action="<?= base_url('profil/ubah-password') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-control mb-3">
                <label class="label"><span class="label-text">Password Lama</span></label>
                <input type="password" name="password_lama" class="input input-bordered" placeholder="Masukkan password lama" required>
            </div>
            <div class="form-control mb-3">
                <label class="label"><span class="label-text">Password Baru</span></label>
                <input type="password" name="password_baru" class="input input-bordered" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Konfirmasi Password Baru</span></label>
                <input type="password" name="password_confirm" class="input input-bordered" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
