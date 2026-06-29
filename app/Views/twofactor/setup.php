<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body p-8 text-center">
            <h1 class="text-2xl font-bold mb-2">Setup 2FA</h1>
            <p class="text-sm text-base-content/60 mb-6">Scan QR code dengan Google Authenticator atau app TOTP lainnya</p>

            <img src="<?= $qr_url ?>" alt="QR Code" class="mx-auto rounded-xl border border-base-200 mb-4">

            <div class="bg-base-200 rounded-lg p-3 mb-6">
                <p class="text-xs text-base-content/50 mb-1">Manual Entry Key:</p>
                <p class="font-mono text-sm font-bold tracking-widest"><?= $secret ?></p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error mb-4 text-sm"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('2fa/verify') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Masukkan Kode 6 Digit</span></label>
                    <input type="text" name="code" class="input input-bordered text-center text-2xl tracking-[0.5em] font-mono" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary w-full">Verifikasi & Aktifkan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
