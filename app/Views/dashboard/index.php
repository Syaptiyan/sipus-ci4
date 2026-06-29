<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-xl font-bold text-base-content">Selamat Datang, <?= $user['nama'] ?? 'User' ?>!</h2>
    <p class="text-sm text-base-content/60 mt-1">Sistem Informasi Perpustakaan (SIPUS)</p>
</div>

<?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
<div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
    <a href="<?= base_url('peminjaman?status=pending') ?>" class="bg-amber-50 rounded-xl p-3 border border-amber-200 hover:shadow-md transition-all">
        <div class="text-xl font-bold text-amber-700"><?= $pending_approval ?></div>
        <div class="text-xs text-amber-600 mt-0.5">Pending Approval</div>
    </a>
    <a href="<?= base_url('peminjaman?status=borrowed') ?>" class="bg-blue-50 rounded-xl p-3 border border-blue-200 hover:shadow-md transition-all">
        <div class="text-xl font-bold text-blue-700"><?= $peminjaman_aktif ?></div>
        <div class="text-xs text-blue-600 mt-0.5">Sedang Dipinjam</div>
    </a>
    <a href="<?= base_url('peminjaman?status=late') ?>" class="bg-rose-50 rounded-xl p-3 border border-rose-200 hover:shadow-md transition-all">
        <div class="text-xl font-bold text-rose-700"><?= $terlambat ?></div>
        <div class="text-xs text-rose-600 mt-0.5">Terlambat</div>
    </a>
    <a href="<?= base_url('pengembalian') ?>" class="bg-emerald-50 rounded-xl p-3 border border-emerald-200 hover:shadow-md transition-all">
        <div class="text-xl font-bold text-emerald-700"><?= $dikembalikan_hari_ini ?></div>
        <div class="text-xs text-emerald-600 mt-0.5">Dikembalikan Hari Ini</div>
    </a>
    <div class="bg-purple-50 rounded-xl p-3 border border-purple-200">
        <div class="text-xl font-bold text-purple-700"><?= $antrian_buku ?></div>
        <div class="text-xs text-purple-600 mt-0.5">Antrian Buku</div>
    </div>
    <div class="bg-teal-50 rounded-xl p-3 border border-teal-200">
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
            <div class="text-xl font-bold text-teal-700"><?= $users_online ?? 0 ?></div>
        </div>
        <div class="text-xs text-teal-600 mt-0.5">Online</div>
    </div>
</div>
<?php endif; ?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="bg-white rounded-xl p-3 border border-base-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Total Buku</span>
            <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
        <div class="text-xl md:text-2xl font-bold text-base-content"><?= $total_buku ?></div>
        <div class="mt-0.5 text-xs text-base-content/50"><?= $total_peminjaman ?> peminjaman</div>
    </div>
    <div class="bg-white rounded-xl p-3 border border-base-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Total Anggota</span>
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
        <div class="text-xl md:text-2xl font-bold text-base-content"><?= $total_anggota ?></div>
        <div class="mt-0.5 text-xs text-base-content/50"><?= $total_pengembalian ?> pengembalian</div>
    </div>
    <div class="bg-white rounded-xl p-3 border border-base-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Peminjaman Aktif</span>
            <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
        </div>
        <div class="text-xl md:text-2xl font-bold text-base-content"><?= $peminjaman_aktif ?></div>
        <div class="mt-0.5 text-xs text-base-content/50"><?= $buku_kosong ?> buku habis</div>
    </div>
    <div class="bg-white rounded-xl p-3 border border-base-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-base-content/50 uppercase tracking-wider">Total Denda</span>
            <div class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="text-xl md:text-2xl font-bold text-base-content"><?= format_rupiah($total_denda) ?></div>
        <div class="mt-0.5 text-xs text-base-content/50">Belum dibayar</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 md:p-5 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-4">Statistik</h3>
        <div class="space-y-2">
            <?php $stats = [
                ['label' => 'Penulis', 'value' => $total_penulis],
                ['label' => 'Penerbit', 'value' => $total_penerbit],
                ['label' => 'Kategori', 'value' => $total_kategori],
                ['label' => 'Buku Habis', 'value' => $buku_kosong],
                ['label' => 'Pengembalian', 'value' => $total_pengembalian],
            ]; ?>
            <?php foreach ($stats as $s): ?>
            <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-base-200/50">
                <span class="text-sm text-base-content/70"><?= $s['label'] ?></span>
                <span class="text-sm font-semibold text-base-content"><?= $s['value'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 md:p-5 border border-base-200 lg:col-span-2">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-bold text-base-content">Aksi Cepat</h3>
            <span class="text-xs font-medium text-primary bg-primary/10 px-2 py-0.5 rounded-full"><?= $user['role'] ?? '' ?></span>
        </div>
        <p class="text-sm text-base-content/60 mb-4">Sistem siap digunakan. Pilih aksi di bawah untuk memulai.</p>
        <div class="flex flex-wrap gap-2">
            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <a href="<?= base_url('peminjaman/new') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Peminjaman Baru
            </a>
            <a href="<?= base_url('peminjaman?status=pending') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Lihat Pengajuan
            </a>
            <?php endif; ?>
            <?php if ($user['role'] === 'Anggota'): ?>
            <a href="<?= base_url('peminjaman/ajukan') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Ajukan Peminjaman
            </a>
            <?php endif; ?>
            <a href="<?= base_url('buku') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-base-200 text-base-content/70 hover:bg-base-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Lihat Buku
            </a>
            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <a href="<?= base_url('laporan') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-base-200 text-base-content/70 hover:bg-base-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Peminjaman per Bulan</h3>
        <div class="relative h-48">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Top 5 Buku Terpopuler</h3>
        <div class="relative h-48">
            <canvas id="chartTopBuku"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Buku Paling Diwishlist</h3>
        <div class="relative h-48">
            <canvas id="chartWishlist"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Anggota Paling Aktif</h3>
        <div class="relative h-48">
            <canvas id="chartAnggota"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Statistik Denda</h3>
        <div class="relative h-48">
            <canvas id="chartDenda"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Statistik Kategori</h3>
        <div class="relative h-48">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Anggota Baru per Bulan</h3>
        <div class="relative h-48">
            <canvas id="chartAnggotaBaru"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-2">Transaksi 7 Hari Terakhir</h3>
        <div class="relative h-48">
            <canvas id="chartTransaksi"></canvas>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-xl p-4 md:p-5 border border-base-200">
        <h3 class="text-sm font-bold text-base-content mb-3">Peminjaman Terbaru</h3>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-base-content/50 border-b border-base-200">
                    <th class="text-left font-medium pb-2">Kode</th>
                    <th class="text-left font-medium pb-2">Anggota</th>
                    <th class="text-left font-medium pb-2">Tanggal</th>
                    <th class="text-left font-medium pb-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjaman_terbaru)): ?>
                    <tr><td colspan="4" class="text-center text-base-content/40 py-6">Belum ada peminjaman</td></tr>
                <?php else: ?>
                <?php foreach ($peminjaman_terbaru as $p): ?>
                <?php
                $statusClass = match($p['status']) {
                    'pending'  => 'text-amber-700 bg-amber-50',
                    'approved' => 'text-blue-700 bg-blue-50',
                    'rejected' => 'text-rose-700 bg-rose-50',
                    'borrowed' => 'text-blue-700 bg-blue-50',
                    'returned' => 'text-emerald-700 bg-emerald-50',
                    'late'     => 'text-rose-700 bg-rose-50',
                    'lost'     => 'text-rose-700 bg-rose-50',
                    'damaged'  => 'text-amber-700 bg-amber-50',
                    default    => 'text-base-content/60 bg-base-200'
                };
                $statusLabel = match($p['status']) {
                    'pending'  => 'Pending',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'borrowed' => 'Dipinjam',
                    'returned' => 'Dikembalikan',
                    'late'     => 'Terlambat',
                    'lost'     => 'Hilang',
                    'damaged'  => 'Rusak',
                    default    => ucfirst($p['status'])
                };
                ?>
                <tr class="border-b border-base-100 hover:bg-base-50 transition-colors">
                    <td class="py-2.5 font-mono text-xs text-base-content/70"><?= $p['kode_peminjaman'] ?></td>
                    <td class="py-2.5 text-sm"><?= $p['nama_anggota'] ?></td>
                    <td class="py-2.5 text-sm text-base-content/60"><?= $p['tanggal_pengajuan'] ? format_tanggal($p['tanggal_pengajuan']) : ($p['tanggal_pinjam'] ? format_tanggal($p['tanggal_pinjam']) : '-') ?></td>
                    <td class="py-2.5"><span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl p-4 md:p-5 border border-base-200">
        <?php if ($user['role'] === 'Anggota'): ?>
        <h3 class="text-sm font-bold text-base-content mb-3">Peminjaman Saya</h3>
        <?php if (empty($peminjaman_saya)): ?>
            <p class="text-sm text-base-content/40 text-center py-6">Belum ada peminjaman.</p>
        <?php else: ?>
            <div class="space-y-2">
            <?php foreach ($peminjaman_saya as $p): ?>
            <?php
            $sc = match($p['status']) {
                'pending'  => 'text-amber-700 bg-amber-50',
                'approved' => 'text-blue-700 bg-blue-50',
                'rejected' => 'text-rose-700 bg-rose-50',
                'borrowed' => 'text-blue-700 bg-blue-50',
                'returned' => 'text-emerald-700 bg-emerald-50',
                'late'     => 'text-rose-700 bg-rose-50',
                default    => 'text-base-content/60 bg-base-200'
            };
            $sl = match($p['status']) {
                'pending'  => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'borrowed' => 'Dipinjam',
                'returned' => 'Dikembalikan',
                'late'     => 'Terlambat',
                default    => ucfirst($p['status'])
            };
            ?>
            <a href="<?= base_url('peminjaman/' . $p['id']) ?>" class="flex items-center justify-between p-3 rounded-lg bg-base-200/50 hover:bg-base-200 transition-colors">
                <div>
                    <p class="text-sm font-medium text-base-content"><?= esc($p['judul_buku']) ?></p>
                    <p class="text-xs text-base-content/50"><?= $p['kode_peminjaman'] ?> • <?= $p['tanggal_pengajuan'] ? format_tanggal($p['tanggal_pengajuan']) : '-' ?></p>
                </div>
                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full <?= $sc ?>"><?= $sl ?></span>
            </a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="divider my-3"></div>
        <h3 class="text-sm font-bold text-base-content mb-3">Buku Favorit Saya</h3>
        <?php if (empty($favorit_saya)): ?>
            <p class="text-sm text-base-content/40 text-center py-4">Belum ada buku favorit.</p>
            <a href="<?= base_url('buku') ?>" class="btn btn-outline btn-xs w-full mt-2">Lihat Katalog</a>
        <?php else: ?>
            <div class="space-y-2">
            <?php foreach ($favorit_saya as $f): ?>
            <a href="<?= base_url('buku/' . $f['id_buku']) ?>" class="flex items-center gap-3 p-2 rounded-lg hover:bg-base-200/50 transition-colors">
                <?php if (!empty($f['isbn'])): ?>
                    <img src="https://covers.openlibrary.org/b/isbn/<?= esc($f['isbn']) ?>-S.jpg"
                         class="w-8 h-11 object-cover rounded shadow-sm bg-base-200"
                         loading="lazy"
                         onerror="this.style.display='none'">
                <?php endif; ?>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-base-content truncate"><?= esc($f['judul']) ?></p>
                    <p class="text-xs text-base-content/50"><?= esc($f['nama_penulis'] ?? '-') ?></p>
                </div>
                <?php if ($f['stok_tersedia'] > 0): ?>
                    <span class="badge badge-success badge-xs">Tersedia</span>
                <?php else: ?>
                    <span class="badge badge-error badge-xs">Habis</span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
            </div>
            <a href="<?= base_url('favorit') ?>" class="btn btn-ghost btn-xs w-full mt-3">Lihat Semua</a>
        <?php endif; ?>
        <?php else: ?>
        <h3 class="text-sm font-bold text-base-content mb-3">Aktivitas Terbaru</h3>
        <?php if (empty($aktivitas)): ?>
            <p class="text-sm text-base-content/40 text-center py-6">Belum ada aktivitas.</p>
        <?php else: ?>
            <?php foreach ($aktivitas as $l): ?>
            <div class="flex items-start gap-3 py-2.5 border-b border-base-100 last:border-0">
                <div class="w-2 h-2 rounded-full bg-primary/40 mt-1.5 shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-base-content"><?= $l['aktivitas'] ?></p>
                    <div class="flex items-center gap-2 text-xs text-base-content/40 mt-0.5">
                        <span><?= $l['nama_user'] ?? 'Sistem' ?></span>
                        <span>•</span>
                        <span><?= format_datetime($l['created_at']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script src="<?= base_url('assets/js/chart.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const primary = '#063a76';

    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                data: <?= json_encode($chart_data) ?>,
                backgroundColor: primary + '20',
                borderColor: primary,
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartTopBuku'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(function($l) { return mb_strlen($l) > 15 ? mb_substr($l, 0, 15) . '...' : $l; }, $top_buku_labels)) ?>,
            datasets: [{
                data: <?= json_encode($top_buku_data) ?>,
                backgroundColor: primary + '20',
                borderColor: primary,
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartWishlist'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(function($l) { return mb_strlen($l) > 15 ? mb_substr($l, 0, 15) . '...' : $l; }, $top_wishlist_labels)) ?>,
            datasets: [{
                data: <?= json_encode($top_wishlist_data) ?>,
                backgroundColor: '#f85e3820',
                borderColor: '#f85e38',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartAnggota'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_map(function($l) { return mb_strlen($l) > 15 ? mb_substr($l, 0, 15) . '...' : $l; }, $top_anggota_labels)) ?>,
            datasets: [{
                data: <?= json_encode($top_anggota_data) ?>,
                backgroundColor: '#005ac720',
                borderColor: '#005ac7',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartDenda'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($denda_labels) ?>,
            datasets: [{
                data: <?= json_encode($denda_data) ?>,
                backgroundColor: ['#ef4444', '#10b981'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($kategori_labels) ?>,
            datasets: [{
                data: <?= json_encode($kategori_data) ?>,
                backgroundColor: ['#063a76', '#f85e38', '#005ac7', '#10b981', '#f59e0b'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
        }
    });

    new Chart(document.getElementById('chartAnggotaBaru'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($anggota_baru_labels) ?>,
            datasets: [{
                data: <?= json_encode($anggota_baru_data) ?>,
                backgroundColor: '#10b98120',
                borderColor: '#10b981',
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartTransaksi'), {
        type: 'line',
        data: {
            labels: <?= json_encode($transaksi_labels) ?>,
            datasets: [{
                data: <?= json_encode($transaksi_data) ?>,
                borderColor: primary,
                backgroundColor: primary + '20',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: primary,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
});
</script>
<?= $this->endSection() ?>
