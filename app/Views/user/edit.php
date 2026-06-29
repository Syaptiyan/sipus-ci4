<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6 max-w-2xl mx-auto">
        <h3 class="text-lg font-bold mb-4">Edit Pengguna</h3>
        <form action="<?= base_url('user/' . $user['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="username" class="input input-bordered" value="<?= old('username', $user['username']) ?>" required>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" value="<?= old('email', $user['email']) ?>" required>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered" placeholder="Kosongkan jika tidak diubah">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Lengkap</span>
                    </label>
                    <input type="text" name="nama" class="input input-bordered" value="<?= old('nama', $user['nama']) ?>" required>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">NIP</span>
                    </label>
                    <input type="text" name="nip" class="input input-bordered" value="<?= old('nip', $user['nip']) ?>">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Role</span>
                    </label>
                    <select name="role" class="select select-bordered">
                        <option value="Petugas" <?= (old('role', $user['role']) === 'Petugas') ? 'selected' : '' ?>>Petugas</option>
                        <option value="Admin" <?= (old('role', $user['role']) === 'Admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="Anggota" <?= (old('role', $user['role']) === 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                    </select>
            <div class="flex justify-end gap-2 mt-6">
                <a href="<?= base_url('user') ?>" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
</div>
<?= $this->endSection() ?>
