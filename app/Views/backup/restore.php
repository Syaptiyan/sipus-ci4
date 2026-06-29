<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Restore Database</h1>
        <a href="<?= base_url('backup') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error text-sm"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-base-200 p-6 max-w-2xl">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-warning/10 flex items-center justify-center">
                <svg class="w-7 h-7 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg text-base-content">Upload & Restore</h3>
                <p class="text-sm text-base-content/60">Restore database dari file backup SQL</p>
            </div>
        </div>

        <div class="alert alert-warning shadow-sm mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div>
                <p class="text-sm font-semibold">Peringatan!</p>
                <p class="text-xs">Restore akan menimpa data yang ada. Pastikan Anda sudah backup data saat ini terlebih dahulu.</p>
            </div>
        </div>

        <form action="<?= base_url('backup/restore') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">File Backup (.sql)</span></label>
                <input type="file" name="backup_file" class="file-input file-input-bordered w-full" accept=".sql" required>
                <label class="label"><span class="label-text-alt">Maks 50MB, format .sql</span></label>
            </div>
            <button type="submit" class="btn btn-warning" onclick="return confirm('PERINGATAN: Restore akan menimpa data. Lanjutkan?')">Restore Database</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
