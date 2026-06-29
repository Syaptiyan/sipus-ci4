<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-lg mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Cek Update</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6 text-center">
        <?php if ($available): ?>
            <div class="w-16 h-16 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-xl font-bold text-success mb-2">Update Tersedia!</h3>
            <p class="text-base-content/60 mb-1">Versi: v<?= $current ?> → v<?= $latest ?></p>
            <form action="<?= base_url('update/apply') ?>" method="post" class="mt-6">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Update sistem ke v<?= $latest ?>?')">Update Sekarang</button>
            </form>
        <?php else: ?>
            <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Sistem Sudah Terbaru</h3>
            <p class="text-base-content/60">v<?= $current ?> — tidak ada update tersedia.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
