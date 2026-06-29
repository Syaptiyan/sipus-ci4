<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Update Sistem</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-lg">Versi Saat Ini: v<?= $current_version ?></h3>
                <p class="text-sm text-base-content/60">SIPUS - Sistem Informasi Perpustakaan</p>
            </div>
        </div>
        <a href="<?= base_url('update/check') ?>" class="btn btn-primary btn-sm">Cek Update</a>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-6">
        <h3 class="font-bold mb-4">Changelog</h3>
        <div class="bg-base-200/50 rounded-lg p-4 max-h-96 overflow-y-auto">
            <pre class="text-xs text-base-content/70 whitespace-pre-wrap"><?= esc(substr($changelog, 0, 2000)) ?></pre>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
