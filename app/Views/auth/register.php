<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold">Daftar Akun</h1>
                <p class="text-base-content/60 text-sm mt-1">Buat akun baru untuk mengakses SIPUS</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error mb-4 text-sm"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Nama Lengkap</span></label>
                    <input type="text" name="nama" class="input input-bordered" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" class="input input-bordered" placeholder="Buat username" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered" placeholder="Masukkan email" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                    <input type="password" name="password_confirm" class="input input-bordered" placeholder="Ulangi password" required>
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Verifikasi Keamanan</span></label>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold bg-base-200 px-3 py-2 rounded-lg font-mono"><?= $captcha ?? '...' ?></span>
                        <input type="number" name="captcha_answer" class="input input-bordered input-sm w-24" placeholder="Jawaban" required>
                    </div>
                    <label class="label"><span class="label-text-alt">Jawab pertanyaan matematika di atas</span></label>
                </div>
                <button type="submit" class="btn btn-primary w-full">Daftar</button>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-base-content/60">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary hover:underline font-semibold">Login</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
