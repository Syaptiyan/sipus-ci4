<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold">White Label Preview</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <h3 class="font-bold mb-4">Preview Branding</h3>
        <div class="flex items-center gap-4 mb-6">
            <?php if (!empty($pengaturan['logo'])): ?>
                <img src="<?= base_url($pengaturan['logo']) ?>" class="w-16 h-16 rounded-xl object-contain">
            <?php else: ?>
                <div class="w-16 h-16 rounded-xl bg-primary flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-content" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            <?php endif; ?>
            <div>
                <h2 class="text-xl font-bold"><?= esc($pengaturan['nama_aplikasi'] ?? 'SIPUS') ?></h2>
                <p class="text-sm text-base-content/60"><?= esc($pengaturan['tagline'] ?? '') ?></p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50">Nama Aplikasi</p>
                <p class="font-semibold"><?= esc($pengaturan['nama_aplikasi'] ?? '-') ?></p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50">Tagline</p>
                <p class="font-semibold"><?= esc($pengaturan['tagline'] ?? '-') ?></p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50">Email</p>
                <p class="font-semibold"><?= esc($pengaturan['kontak_email'] ?? '-') ?></p>
            </div>
            <div class="p-4 bg-base-200/50 rounded-lg">
                <p class="text-xs text-base-content/50">Telepon</p>
                <p class="font-semibold"><?= esc($pengaturan['kontak_telepon'] ?? '-') ?></p>
            </div>
        </div>
        <div class="mt-4">
            <a href="<?= base_url('pengaturan') ?>" class="btn btn-primary btn-sm">Edit di Pengaturan</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
