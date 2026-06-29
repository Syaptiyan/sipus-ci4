<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold">Tambah Kategori</h3>
        <form action="<?= base_url('kategori') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" placeholder="Nama kategori" required>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Deskripsi</span>
                </label>
                <textarea name="deskripsi" class="textarea textarea-bordered" placeholder="Deskripsi kategori"></textarea>
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('kategori') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
