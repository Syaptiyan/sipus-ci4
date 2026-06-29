<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Request Buku Baru</h1>
        <a href="<?= base_url('wishlist') ?>" class="btn btn-outline btn-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 max-w-2xl">
        <form method="POST" action="<?= base_url('wishlist') ?>">
            <?= csrf_field() ?>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Judul Buku <span class="text-error">*</span></span></label>
                <input type="text" name="judul_buku" class="input input-bordered" placeholder="Masukkan judul buku yang diinginkan" required>
            </div>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Pengarang</span></label>
                <input type="text" name="pengarang" class="input input-bordered" placeholder="Nama penulis/pengarang">
            </div>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Penerbit</span></label>
                <input type="text" name="penerbit" class="input input-bordered" placeholder="Nama penerbit">
            </div>
            <div class="form-control mb-4">
                <label class="label"><span class="label-text">Alasan Request</span></label>
                <textarea name="alasan" class="textarea textarea-bordered" rows="3" placeholder="Mengapa Anda membutuhkan buku ini?"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Kirim Request</button>
                <a href="<?= base_url('wishlist') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
