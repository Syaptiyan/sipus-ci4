<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Detail Penerbit</h1>
        <div class="flex gap-2">
            <a href="<?= base_url('penerbit/' . $penerbit['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="<?= base_url('penerbit') ?>" class="btn btn-outline btn-sm">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-base-content/60">Nama</p>
                <p class="font-semibold"><?= esc($penerbit['nama']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Slug</p>
                <p class="font-semibold"><?= esc($penerbit['slug']) ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Telepon</p>
                <p class="font-semibold"><?= esc($penerbit['telp'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-sm text-base-content/60">Email</p>
                <p class="font-semibold"><?= esc($penerbit['email'] ?? '-') ?></p>
            </div>
        </div>
        <?php if ($penerbit['alamat']): ?>
        <div class="mt-4">
            <p class="text-sm text-base-content/60 mb-1">Alamat</p>
            <p class="text-sm"><?= esc($penerbit['alamat']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
