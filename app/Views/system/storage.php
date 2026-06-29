<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Monitoring Storage</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Disk Usage</h3>
            <?php $used = $disk_total - $disk_free; $pct = $disk_total > 0 ? round(($used / $disk_total) * 100) : 0; ?>
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span>Used: <?= number_format($used / 1073741824, 1) ?> GB</span>
                    <span>Free: <?= number_format($disk_free / 1073741824, 1) ?> GB</span>
                </div>
                <div class="w-full bg-base-200 rounded-full h-3">
                    <div class="h-3 rounded-full <?= $pct > 90 ? 'bg-error' : ($pct > 70 ? 'bg-warning' : 'bg-success') ?>" style="width: <?= $pct ?>%"></div>
                </div>
                <p class="text-xs text-base-content/50 mt-1"><?= $pct ?>% used of <?= number_format($disk_total / 1073741824, 1) ?> GB</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Upload Folder</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-base-100">
                    <span class="text-sm text-base-content/60">Status</span>
                    <?php if ($upload_exists && $upload_writable): ?>
                        <span class="badge badge-success badge-sm">OK</span>
                    <?php else: ?>
                        <span class="badge badge-error badge-sm">Error</span>
                    <?php endif; ?>
                </div>
                <div class="flex justify-between py-2 border-b border-base-100">
                    <span class="text-sm text-base-content/60">Total Files</span>
                    <span class="text-sm font-semibold"><?= $upload_files ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-base-100">
                    <span class="text-sm text-base-content/60">Total Size</span>
                    <span class="text-sm font-semibold"><?= number_format($upload_size / 1024, 1) ?> KB</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-sm text-base-content/60">Profil Photos</span>
                    <span class="text-sm font-semibold"><?= $profil_files ?> files</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
