<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold">Tambah Penerbit</h3>
        <form action="<?= base_url('penerbit') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" placeholder="Nama penerbit" required>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea name="alamat" class="textarea textarea-bordered" placeholder="Alamat penerbit"></textarea>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Telp</span>
                </label>
                <input type="text" name="telp" class="input input-bordered" placeholder="Nomor telepon">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered" placeholder="Email penerbit">
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('penerbit') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
