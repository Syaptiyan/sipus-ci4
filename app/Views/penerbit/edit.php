<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold">Edit Penerbit</h3>
        <form action="<?= base_url('penerbit/' . $penerbit['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" value="<?= $penerbit['nama'] ?>" required>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea name="alamat" class="textarea textarea-bordered"><?= $penerbit['alamat'] ?></textarea>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Telp</span>
                </label>
                <input type="text" name="telp" class="input input-bordered" value="<?= $penerbit['telp'] ?>">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered" value="<?= $penerbit['email'] ?>">
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('penerbit') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
