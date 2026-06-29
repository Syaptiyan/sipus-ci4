<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Penulis</h1>
        <div class="flex gap-2">
            <a href="<?= base_url('penulis/' . $penulis['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="<?= base_url('penulis') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Nama</p>
                <p class="font-semibold"><?= esc($penulis['nama']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Slug</p>
                <p class="font-semibold"><?= esc($penulis['slug']) ?></p>
            </div>
        </div>
        <?php if ($penulis['bio']): ?>
        <div class="mt-4">
            <p class="text-sm text-base-content/60 mb-1">Bio</p>
            <p class="text-sm"><?= esc($penulis['bio']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
