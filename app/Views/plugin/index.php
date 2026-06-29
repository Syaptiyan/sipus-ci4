<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Plugin Manager</h1>
    <p class="text-sm text-base-content/60">Kelola plugin untuk memperluas fitur SIPUS. Plugin ditempatkan di folder <code class="bg-base-200 px-1 rounded">app/Plugins/</code></p>

    <?php if (empty($plugins)): ?>
        <div class="bg-white rounded-xl border border-base-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            <p class="text-base-content/50 mb-2">Belum ada plugin terinstall</p>
            <p class="text-xs text-base-content/40">Tambahkan plugin di folder <code>app/Plugins/</code></p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($plugins as $p): ?>
            <div class="bg-white rounded-xl border border-base-200 p-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold"><?= esc($p['name']) ?></h3>
                    <p class="text-sm text-base-content/60"><?= esc($p['description']) ?></p>
                    <p class="text-xs text-base-content/40 mt-1">v<?= esc($p['version']) ?></p>
                </div>
                <a href="<?= base_url('plugin/' . $p['name'] . '/toggle') ?>" class="btn btn-sm <?= $p['enabled'] ? 'btn-success' : 'btn-ghost' ?>">
                    <?= $p['enabled'] ? 'Aktif' : 'Nonaktif' ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
