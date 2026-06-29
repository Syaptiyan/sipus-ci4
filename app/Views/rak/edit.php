<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold">Edit Rak</h3>
        <form action="<?= base_url('rak/' . $rak['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" value="<?= $rak['nama'] ?>" required>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Lokasi</span>
                </label>
                <input type="text" name="lokasi" class="input input-bordered" value="<?= $rak['lokasi'] ?>">
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('rak') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
