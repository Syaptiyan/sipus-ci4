<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Statistik Saya</h1>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Total Pinjam</p>
            <p class="text-2xl font-bold text-primary mt-1"><?= $total_pinjam ?></p>
            <p class="text-xs text-base-content/40 mt-1">buku</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Sedang Pinjam</p>
            <p class="text-2xl font-bold text-secondary mt-1"><?= $sedang_pinjam ?></p>
            <p class="text-xs text-base-content/40 mt-1">buku</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Total Denda</p>
            <p class="text-2xl font-bold text-error mt-1">Rp <?= number_format($total_denda, 0, ',', '.') ?></p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <p class="text-xs text-base-content/50 uppercase tracking-wider">Rating Rata-rata</p>
            <p class="text-2xl font-bold text-amber-500 mt-1"><?= round($rating_rata, 1) ?></p>
            <p class="text-xs text-base-content/40 mt-1">dari 5</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <h3 class="text-sm font-bold text-base-content mb-3">Peminjaman per Bulan</h3>
            <div class="relative h-48">
                <canvas id="chartPeminjaman"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <h3 class="text-sm font-bold text-base-content mb-3">Kategori Favorit</h3>
            <?php if (empty($kategori_fav)): ?>
                <p class="text-sm text-base-content/40 text-center py-8">Belum ada data.</p>
            <?php else: ?>
                <div class="space-y-2">
                    <?php foreach ($kategori_fav as $k): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-base-content/70"><?= esc($k['nama']) ?></span>
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-base-200 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full" style="width: <?= min(100, ($k['total'] / max(array_column($kategori_fav, 'total'))) * 100) ?>%"></div>
                            </div>
                            <span class="text-xs font-semibold text-base-content w-8 text-right"><?= $k['total'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <h3 class="text-sm font-bold text-base-content mb-3">Penulis Favorit</h3>
            <?php if (empty($penulis_fav)): ?>
                <p class="text-sm text-base-content/40 text-center py-8">Belum ada data.</p>
            <?php else: ?>
                <div class="space-y-2">
                    <?php foreach ($penulis_fav as $p): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-base-content/70"><?= esc($p['nama']) ?></span>
                        <div class="flex items-center gap-2">
                            <div class="w-24 bg-base-200 rounded-full h-2">
                                <div class="bg-secondary h-2 rounded-full" style="width: <?= min(100, ($p['total'] / max(array_column($penulis_fav, 'total'))) * 100) ?>%"></div>
                            </div>
                            <span class="text-xs font-semibold text-base-content w-8 text-right"><?= $p['total'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="bg-white rounded-xl p-4 border border-base-200">
            <h3 class="text-sm font-bold text-base-content mb-3">Ringkasan</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-base-200/50">
                    <span class="text-sm text-base-content/70">Total Buku Dibaca</span>
                    <span class="text-sm font-semibold"><?= $total_pinjam ?> buku</span>
                </div>
                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-base-200/50">
                    <span class="text-sm text-base-content/70">Sedang Dipinjam</span>
                    <span class="text-sm font-semibold"><?= $sedang_pinjam ?> buku</span>
                </div>
                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-base-200/50">
                    <span class="text-sm text-base-content/70">Total Denda</span>
                    <span class="text-sm font-semibold text-error">Rp <?= number_format($total_denda, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center py-2 px-3 rounded-lg bg-base-200/50">
                    <span class="text-sm text-base-content/70">Review Diberikan</span>
                    <span class="text-sm font-semibold"><?= round($rating_rata, 1) ?> ★</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/chart.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('chartPeminjaman'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                data: <?= json_encode($chart_data) ?>,
                backgroundColor: '#063a7620',
                borderColor: '#063a76',
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
});
</script>
<?= $this->endSection() ?>
