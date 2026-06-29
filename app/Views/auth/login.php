<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary/30">
                    <svg class="w-8 h-8 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">SIPUS</h1>
                <p class="text-base-content/60 text-sm mt-1">Sistem Informasi Perpustakaan</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error mb-4 text-sm"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mb-4 text-sm"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (!empty($is_blocked)): ?>
                <div class="alert alert-warning mb-4 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Terlalu banyak percobaan. Coba lagi dalam 15 menit.
                </div>
            <?php else: ?>
                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Username atau Email</span></label>
                        <input type="text" name="login" class="input input-bordered" placeholder="Masukkan username atau email" required autofocus>
                    </div>
                    <div class="form-control mb-2">
                        <label class="label"><span class="label-text">Password</span></label>
                        <input type="password" name="password" class="input input-bordered" placeholder="Masukkan password" required>
                    </div>
                    <div class="text-right mb-4">
                        <a href="<?= base_url('forgot-password') ?>" class="text-sm text-primary hover:underline">Lupa Password?</a>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text">Verifikasi Keamanan</span></label>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold bg-base-200 px-3 py-2 rounded-lg font-mono"><?= $captcha ?? '...' ?></span>
                            <input type="number" name="captcha_answer" class="input input-bordered input-sm w-24" placeholder="Jawaban" required>
                        </div>
                        <label class="label"><span class="label-text-alt">Jawab pertanyaan matematika di atas</span></label>
                    </div>

                    <?php if (!empty($remaining_attempts) && $remaining_attempts < 5): ?>
                    <div class="text-xs text-base-content/50 mb-3 text-center">
                        Sisa <?= $remaining_attempts ?> percobaan sebelum diblokir sementara
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary w-full">Masuk</button>
                </form>
            <?php endif; ?>

            <div class="divider text-xs">atau</div>
            <a href="<?= base_url('register') ?>" class="btn btn-outline w-full">Daftar Akun Baru</a>

            <div class="mt-6 p-4 bg-base-200 rounded-xl">
                <p class="text-xs font-semibold mb-2">Akun Demo:</p>
                <div class="text-xs space-y-1 text-base-content/70">
                    <div><strong>Admin</strong> (Rina Wijaya): <strong>admin</strong> / <strong>password123</strong></div>
                    <div><strong>Petugas</strong> (Dewi Lestari): <strong>petugas</strong> / <strong>password123</strong></div>
                    <div><strong>Anggota</strong> (Andi Prasetyo): <strong>anggota</strong> / <strong>password123</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
