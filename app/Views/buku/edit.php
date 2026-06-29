<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Edit Buku</h1>

    <form method="POST" action="<?= base_url('buku/' . $buku['id']) ?>" class="flex flex-col gap-3 max-w-2xl">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="form-control">
            <label class="label"><span class="label-text">ISBN</span></label>
            <input type="text" name="isbn" class="input input-bordered" value="<?= esc($buku['isbn']) ?>" required>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text">Judul</span></label>
            <input type="text" name="judul" class="input input-bordered" value="<?= esc($buku['judul']) ?>" required>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="form-control">
                <label class="label"><span class="label-text">Kategori</span></label>
                <select name="id_kategori" class="select select-bordered" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= $k['id'] == $buku['id_kategori'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Penulis</span></label>
                <select name="id_penulis" class="select select-bordered" required>
                    <option value="">-- Pilih Penulis --</option>
                    <?php foreach ($penulis as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $buku['id_penulis'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Penerbit</span></label>
                <select name="id_penerbit" class="select select-bordered" required>
                    <option value="">-- Pilih Penerbit --</option>
                    <?php foreach ($penerbit as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $buku['id_penerbit'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Rak</span></label>
                <select name="id_rak" class="select select-bordered" required>
                    <option value="">-- Pilih Rak --</option>
                    <?php foreach ($rak as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= $r['id'] == $buku['id_rak'] ? 'selected' : '' ?>><?= esc($r['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Tahun Terbit</span></label>
                <input type="number" name="tahun_terbit" class="input input-bordered" value="<?= esc($buku['tahun_terbit']) ?>">
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Jumlah Halaman</span></label>
                <input type="number" name="jumlah_halaman" class="input input-bordered" value="<?= esc($buku['jumlah_halaman']) ?>">
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Bahasa</span></label>
                <input type="text" name="bahasa" class="input input-bordered" value="<?= esc($buku['bahasa'] ?? 'Indonesia') ?>">
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Edisi</span></label>
                <input type="text" name="edisi" class="input input-bordered" value="<?= esc($buku['edisi'] ?? '') ?>">
            </div>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text">Deskripsi</span></label>
            <textarea name="deskripsi" class="textarea textarea-bordered" rows="4"><?= esc($buku['deskripsi']) ?></textarea>
        </div>

        <div class="form-control w-full sm:w-48">
            <label class="label"><span class="label-text">Stok</span></label>
            <input type="number" name="stok" class="input input-bordered" value="<?= $buku['stok'] ?>" min="0">
        </div>

        <div class="flex gap-2 mt-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('buku') ?>" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
