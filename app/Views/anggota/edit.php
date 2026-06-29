<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold">Edit Anggota</h3>
        <form action="<?= base_url('anggota/' . $anggota['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Kode Anggota</span>
                </label>
                <input type="text" name="kode_anggota" class="input input-bordered" value="<?= $anggota['kode_anggota'] ?>" readonly>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" value="<?= $anggota['nama'] ?>" required>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Jenis Kelamin</span>
                </label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" class="radio radio-primary" value="L" <?= $anggota['jenis_kelamin'] === 'L' ? 'checked' : '' ?>>
                        <span>Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" class="radio radio-primary" value="P" <?= $anggota['jenis_kelamin'] === 'P' ? 'checked' : '' ?>>
                        <span>Perempuan</span>
                    </label>
                </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Tempat Lahir</span>
                </label>
                <input type="text" name="tempat_lahir" class="input input-bordered" value="<?= $anggota['tempat_lahir'] ?>">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Tanggal Lahir</span>
                </label>
                <input type="date" name="tanggal_lahir" class="input input-bordered" value="<?= $anggota['tanggal_lahir'] ?>">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea name="alamat" class="textarea textarea-bordered"><?= $anggota['alamat'] ?></textarea>
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Telp</span>
                </label>
                <input type="text" name="telp" class="input input-bordered" value="<?= $anggota['telp'] ?>">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered" value="<?= $anggota['email'] ?>">
            </div>
            <div class="form-control mt-2">
                <label class="label">
                    <span class="label-text">Foto</span>
                </label>
                <input type="text" name="foto" class="input input-bordered" value="<?= $anggota['foto'] ?>">
            </div>
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('anggota') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
