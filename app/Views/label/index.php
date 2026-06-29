<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4" x-data="{ selected: [] }">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Label Rak Buku</h1>
        <div class="flex gap-2">
            <button @click="selected = <?= json_encode(array_column($rak, 'id')) ?>" class="btn btn-ghost btn-sm">Pilih Semua</button>
            <form method="POST" action="<?= base_url('label/cetak') ?>" target="_blank" class="inline">
                <?= csrf_field() ?>
                <template x-for="id in selected"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="btn btn-primary btn-sm" :disabled="selected.length === 0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Label (<span x-text="selected.length"></span>)
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        <?php foreach ($rak as $r): ?>
        <div class="bg-white rounded-xl border border-base-200 p-4 cursor-pointer transition-all"
             :class="selected.includes(<?= $r['id'] ?>) ? 'ring-2 ring-primary border-primary' : ''"
             @click="selected.includes(<?= $r['id'] ?>) ? selected = selected.filter(i => i !== <?= $r['id'] ?>) : selected.push(<?= $r['id'] ?>)">
            <div class="text-center">
                <svg class="w-8 h-8 text-primary mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h3 class="font-bold text-lg"><?= esc($r['nama']) ?></h3>
                <p class="text-xs text-base-content/50"><?= esc($r['lokasi'] ?? '-') ?></p>
                <span class="badge badge-outline badge-sm mt-2"><?= $r['jumlah_buku'] ?> buku</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
