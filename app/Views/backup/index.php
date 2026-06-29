<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Backup Database</h1>

    <div class="bg-white rounded-xl border border-base-200 p-6 max-w-2xl">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center">
                <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg text-base-content">Download Backup</h3>
                <p class="text-sm text-base-content/60">Export seluruh database ke file SQL</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-base-200/50 rounded-lg p-4">
                <p class="text-xs text-base-content/50 uppercase tracking-wider">Total Tabel</p>
                <p class="text-2xl font-bold text-primary"><?= $total_tables ?></p>
            </div>
            <div class="bg-base-200/50 rounded-lg p-4">
                <p class="text-xs text-base-content/50 uppercase tracking-wider">Total Baris</p>
                <p class="text-2xl font-bold text-secondary"><?= number_format($total_rows) ?></p>
            </div>
        </div>

        <div class="mb-6">
            <p class="text-sm font-semibold mb-2">Tabel yang akan di-backup:</p>
            <div class="flex flex-wrap gap-1.5">
                <?php foreach ($tables as $t): ?>
                    <span class="badge badge-outline badge-sm"><?= esc($t) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="alert alert-info shadow-sm mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-semibold">Informasi</p>
                <p class="text-xs">File backup berformat SQL dan bisa di-restore langsung ke MySQL/MariaDB.</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="<?= base_url('backup/download') ?>" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download Backup
            </a>
            <a href="<?= base_url('backup/restore') ?>" class="btn btn-outline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Restore Database
            </a>
            <a href="<?= base_url('backup/history') ?>" class="btn btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
