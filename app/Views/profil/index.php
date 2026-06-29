<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Profil Saya</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-sm"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error text-sm"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-base-200 p-6 text-center">
            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4 overflow-hidden">
                <?php if ($profil['foto']): ?>
                    <img src="<?= base_url($profil['foto']) ?>" alt="Foto" class="w-full h-full object-cover">
                <?php else: ?>
                    <span class="text-3xl font-bold text-primary"><?= strtoupper(substr($profil['nama'], 0, 1)) ?></span>
                <?php endif; ?>
            </div>
            <h3 class="font-bold text-lg"><?= esc($profil['nama']) ?></h3>
            <p class="text-sm text-base-content/50"><?= esc($profil['role']) ?></p>
            <p class="text-xs text-base-content/40 mt-1">@<?= esc($profil['username']) ?></p>
            <div class="divider"></div>
            <a href="<?= base_url('profil/ubah-password') ?>" class="btn btn-outline btn-sm w-full">Ubah Password</a>
            <a href="<?= base_url('profil/login-history') ?>" class="btn btn-ghost btn-sm w-full mt-2">Riwayat Login</a>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Edit Profil</h3>
            <form action="<?= base_url('profil') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Foto Profil</span></label>
                    <input type="file" name="foto" class="file-input file-input-bordered file-input-sm w-full" accept="image/*">
                    <label class="label"><span class="label-text-alt">Maks 2MB, format JPG/PNG/WEBP</span></label>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Nama Lengkap</span></label>
                    <input type="text" name="nama" class="input input-bordered" value="<?= esc($profil['nama']) ?>" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered" value="<?= esc($profil['email']) ?>" required>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">NIP</span></label>
                    <input type="text" name="nip" class="input input-bordered" value="<?= esc($profil['nip'] ?? '') ?>">
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" class="input input-bordered bg-base-200" value="<?= esc($profil['username']) ?>" disabled>
                    <label class="label"><span class="label-text-alt">Username tidak bisa diubah</span></label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
