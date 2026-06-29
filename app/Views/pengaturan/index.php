<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold">Pengaturan Sistem</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-sm"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error text-sm"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('pengaturan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Umum -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 mb-4">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Umum
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Nama Aplikasi</span></label>
                    <input type="text" name="nama_aplikasi" class="input input-bordered" value="<?= esc($settings['nama_aplikasi'] ?? 'SIPUS') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Tagline</span></label>
                    <input type="text" name="tagline" class="input input-bordered" value="<?= esc($settings['tagline'] ?? '') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Logo Aplikasi</span></label>
                    <input type="file" name="logo" class="file-input file-input-bordered file-input-sm w-full" accept="image/*">
                    <?php if (!empty($settings['logo'])): ?>
                        <label class="label"><span class="label-text-alt">Saat ini: <?= esc($settings['logo']) ?></span></label>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Favicon</span></label>
                    <input type="file" name="favicon" class="file-input file-input-bordered file-input-sm w-full" accept=".ico,.png,.svg">
                    <?php if (!empty($settings['favicon'])): ?>
                        <label class="label"><span class="label-text-alt">Saat ini: <?= esc($settings['favicon']) ?></span></label>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Data per Halaman</span></label>
                    <input type="number" name="per_page" class="input input-bordered" value="<?= esc($settings['per_page'] ?? '10') ?>">
                </div>
            </div>
        </div>

        <!-- Kontak -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 mb-4">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Kontak Perpustakaan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control md:col-span-2">
                    <label class="label"><span class="label-text">Alamat</span></label>
                    <textarea name="kontak_alamat" class="textarea textarea-bordered" rows="2"><?= esc($settings['kontak_alamat'] ?? '') ?></textarea>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Telepon</span></label>
                    <input type="text" name="kontak_telepon" class="input input-bordered" value="<?= esc($settings['kontak_telepon'] ?? '') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="kontak_email" class="input input-bordered" value="<?= esc($settings['kontak_email'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Operasional -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 mb-4">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Jam Operasional
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Jam Buka</span></label>
                    <input type="time" name="jam_buka" class="input input-bordered" value="<?= esc($settings['jam_buka'] ?? '08:00') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Jam Tutup</span></label>
                    <input type="time" name="jam_tutup" class="input input-bordered" value="<?= esc($settings['jam_tutup'] ?? '16:00') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Hari Operasional</span></label>
                    <input type="text" name="hari_operasional" class="input input-bordered" value="<?= esc($settings['hari_operasional'] ?? 'Senin - Sabtu') ?>">
                </div>
            </div>
        </div>

        <!-- Peminjaman -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 mb-4">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Peminjaman & Denda
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Masa Pinjam (Hari)</span></label>
                    <input type="number" name="masa_pinjam" class="input input-bordered" value="<?= esc($settings['masa_pinjam'] ?? '7') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Maksimal Pinjam (Buku)</span></label>
                    <input type="number" name="maks_pinjam" class="input input-bordered" value="<?= esc($settings['maks_pinjam'] ?? '3') ?>">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Denda per Hari (Rp)</span></label>
                    <input type="number" name="denda_per_hari" class="input input-bordered" value="<?= esc($settings['denda_per_hari'] ?? '1000') ?>">
                </div>
            </div>
        </div>

        <!-- Maintenance -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 mb-4">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                Mode Maintenance
            </h3>
            <div class="form-control mb-4">
                <label class="cursor-pointer flex items-center gap-3">
                    <input type="checkbox" name="maintenance_mode" value="1" class="toggle toggle-warning" <?= ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?>>
                    <span class="label-text">Aktifkan Mode Maintenance</span>
                </label>
                <label class="label"><span class="label-text-alt">Saat aktif, hanya Admin yang bisa mengakses sistem.</span></label>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Pesan Maintenance</span></label>
                <textarea name="maintenance_message" class="textarea textarea-bordered" rows="2"><?= esc($settings['maintenance_message'] ?? 'Sistem sedang dalam pemeliharaan. Silakan coba lagi nanti.') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
