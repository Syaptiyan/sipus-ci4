<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Reset Password</h1>
                <p class="text-base-content/60 text-sm mt-1">Masukkan password baru Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error mb-4 text-sm"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('reset-password') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Password Baru</span></label>
                    <input type="password" name="password" class="input input-bordered" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                    <input type="password" name="password_confirm" class="input input-bordered" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">Reset Password</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
