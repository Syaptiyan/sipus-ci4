<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-lg mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Two-Factor Authentication</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl <?= $enabled ? 'bg-success/10' : 'bg-base-200' ?> flex items-center justify-center">
                <svg class="w-6 h-6 <?= $enabled ? 'text-success' : 'text-base-content/40' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <h3 class="font-bold"><?= $enabled ? '2FA Aktif' : '2FA Nonaktif' ?></h3>
                <p class="text-sm text-base-content/60"><?= $enabled ? 'Akun Anda terlindungi dengan 2FA' : 'Aktifkan 2FA untuk keamanan tambahan' ?></p>
            </div>
        </div>
        <?php if ($enabled): ?>
            <a href="<?= base_url('2fa/disable') ?>" class="btn btn-error btn-sm" onclick="return confirm('Nonaktifkan 2FA?')">Nonaktifkan 2FA</a>
        <?php else: ?>
            <a href="<?= base_url('2fa/enable') ?>" class="btn btn-primary btn-sm">Aktifkan 2FA</a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
