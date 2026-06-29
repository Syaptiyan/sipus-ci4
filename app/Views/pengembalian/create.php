<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Pengembalian Buku</h1>

    <form method="POST" action="<?= base_url('pengembalian') ?>" class="flex flex-col gap-3 max-w-2xl">
        <?= csrf_field() ?>

        <div class="form-control">
            <label class="label"><span class="label-text">Pilih Peminjaman</span></label>
            <select name="id_peminjaman" class="select select-bordered" required id="id_peminjaman">
                <option value="">-- Pilih Peminjaman --</option>
                <?php foreach ($peminjaman as $p): ?>
                    <option value="<?= $p['id'] ?>" data-tgl-jatuh-tempo="<?= $p['tanggal_jatuh_tempo'] ?>">
                        <?= esc($p['kode_peminjaman']) ?> - <?= esc($p['nama_anggota']) ?> (<?= date('d/m/Y', strtotime($p['tanggal_pinjam'])) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text">Tanggal Kembali</span></label>
            <input type="date" name="tanggal_kembali" class="input input-bordered" value="<?= date('Y-m-d') ?>" id="tanggal_kembali">
        </div>

        <div class="card bg-base-200 p-4 rounded-box">
            <div class="flex justify-between items-center">
                <span class="text-sm">Denda per hari:</span>
                <span class="font-semibold">Rp <?= number_format($denda_per_hari, 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-sm">Total Denda:</span>
                <span class="font-bold text-lg text-error" id="total_denda">Rp 0</span>
            </div>
        </div>

        <div class="flex gap-2 mt-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('pengembalian') ?>" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
const dendaPerHari = <?= $denda_per_hari ?>;
const pinjamSelect = document.getElementById('id_peminjaman');
const tglKembali = document.getElementById('tanggal_kembali');

function hitungDenda() {
    const selected = pinjamSelect.options[pinjamSelect.selectedIndex];
    if (!selected || !selected.value) {
        document.getElementById('total_denda').textContent = 'Rp 0';
        return;
    }
    const jatuhTempo = new Date(selected.dataset.tglJatuhTempo);
    const kembali = new Date(tglKembali.value);
    const selisih = Math.floor((kembali - jatuhTempo) / (1000 * 60 * 60 * 24));
    const denda = Math.max(0, selisih * dendaPerHari);
    document.getElementById('total_denda').textContent = 'Rp ' + denda.toLocaleString('id-ID');
}

pinjamSelect.addEventListener('change', hitungDenda);
tglKembali.addEventListener('change', hitungDenda);
</script>
<?= $this->endSection() ?>
