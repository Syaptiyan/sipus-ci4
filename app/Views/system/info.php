<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">System Information</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Server</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">PHP Version</span><span class="text-sm font-semibold"><?= $php_version ?></span></div>
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">CodeIgniter</span><span class="text-sm font-semibold"><?= $ci_version ?></span></div>
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">Server</span><span class="text-sm font-semibold"><?= esc($server_software) ?></span></div>
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">OS</span><span class="text-sm font-semibold"><?= esc($os) ?></span></div>
                <div class="flex justify-between py-2"><span class="text-sm text-base-content/60">Timezone</span><span class="text-sm font-semibold"><?= $timezone ?></span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Database</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">Driver</span><span class="text-sm font-semibold"><?= esc($db_driver) ?></span></div>
                <div class="flex justify-between py-2"><span class="text-sm text-base-content/60">Version</span><span class="text-sm font-semibold"><?= esc($db_version) ?></span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">PHP Limits</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">Memory Limit</span><span class="text-sm font-semibold"><?= $memory_limit ?></span></div>
                <div class="flex justify-between py-2 border-b border-base-100"><span class="text-sm text-base-content/60">Max Upload</span><span class="text-sm font-semibold"><?= $max_upload ?></span></div>
                <div class="flex justify-between py-2"><span class="text-sm text-base-content/60">Max POST</span><span class="text-sm font-semibold"><?= $max_post ?></span></div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Extensions</h3>
            <div class="flex flex-wrap gap-1.5">
                <?php foreach ($extensions as $ext): ?>
                    <span class="badge badge-outline badge-sm"><?= esc($ext) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
