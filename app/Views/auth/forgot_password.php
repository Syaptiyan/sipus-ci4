<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Lupa Password</h1>
                <p class="text-base-content/60 text-sm mt-1">Masukkan email untuk reset password</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error mb-4 text-sm"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-4 text-sm"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('forgot-password') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered" placeholder="Masukkan email terdaftar" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">Kirim Link Reset</button>
            </form>

            <div class="text-center mt-4">
                <a href="<?= base_url('login') ?>" class="text-sm text-primary hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
