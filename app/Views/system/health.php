<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Health Check</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <?php if ($all_ok): ?>
                <div class="w-10 h-10 rounded-full bg-success/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-success">Semua Normal</h3>
                    <p class="text-sm text-base-content/60">Semua pemeriksaan sistem berhasil</p>
                </div>
            <?php else: ?>
                <div class="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-error">Ada Masalah</h3>
                    <p class="text-sm text-base-content/60">Beberapa pemeriksaan gagal</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="space-y-3">
            <?php foreach ($checks as $name => $check): ?>
            <div class="flex items-center justify-between p-3 rounded-lg <?= $check['status'] === 'ok' ? 'bg-success/5' : ($check['status'] === 'warning' ? 'bg-warning/5' : 'bg-error/5') ?>">
                <div class="flex items-center gap-3">
                    <?php if ($check['status'] === 'ok'): ?>
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <?php elseif ($check['status'] === 'warning'): ?>
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <?php else: ?>
                        <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <?php endif; ?>
                    <span class="font-semibold text-sm capitalize"><?= esc($name) ?></span>
                </div>
                <span class="text-sm text-base-content/60"><?= esc($check['message']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
