<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Log Error Sistem</h1>
        <span class="text-sm text-base-content/50 font-mono"><?= basename($log_file) ?></span>
    </div>
    <?php if (!$file_exists): ?>
        <div class="bg-white rounded-xl border border-base-200 p-12 text-center">
            <p class="text-base-content/50">Belum ada log error hari ini.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-base-200 p-4">
            <div class="bg-base-200 rounded-lg p-4 max-h-[600px] overflow-y-auto font-mono text-xs leading-relaxed">
                <?php foreach ($lines as $line): ?>
                    <div class="py-0.5 border-b border-base-300/50 <?= str_contains($line, 'ERROR') ? 'text-error' : (str_contains($line, 'WARNING') ? 'text-warning' : 'text-base-content/70') ?>"><?= esc($line) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
