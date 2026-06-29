<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Broadcast Pengumuman</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Kirim Pengumuman</h3>
            <form action="<?= base_url('broadcast/send') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Target</span></label>
                    <select name="target" class="select select-bordered">
                        <option value="all">Semua Pengguna</option>
                        <option value="Anggota">Hanya Anggota</option>
                        <option value="Petugas">Hanya Petugas</option>
                        <option value="Admin">Hanya Admin</option>
                    </select>
                </div>
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Judul</span></label>
                    <input type="text" name="judul" class="input input-bordered" placeholder="Judul pengumuman" required>
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Pesan</span></label>
                    <textarea name="pesan" class="textarea textarea-bordered" rows="4" placeholder="Isi pengumuman..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Kirim pengumuman ini?')">Kirim Pengumuman</button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-base-200 p-6">
            <h3 class="font-bold mb-4">Riwayat Broadcast</h3>
            <?php if (empty($broadcasts)): ?>
                <p class="text-sm text-base-content/40 text-center py-8">Belum ada broadcast.</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($broadcasts as $b): ?>
                    <div class="p-3 bg-base-200/50 rounded-lg">
                        <p class="text-sm font-semibold"><?= esc($b['judul']) ?></p>
                        <p class="text-xs text-base-content/60 mt-1"><?= esc($b['pesan']) ?></p>
                        <p class="text-xs text-base-content/40 mt-2"><?= format_datetime($b['created_at']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
