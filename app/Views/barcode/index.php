<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4" x-data="{ selected: [] }">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Cetak Barcode Buku</h1>
        <div class="flex gap-2">
            <button @click="selected = <?= json_encode(array_column($buku, 'id')) ?>" class="btn btn-ghost btn-sm">Pilih Semua</button>
            <button @click="selected = []" class="btn btn-ghost btn-sm">Batal Pilih</button>
            <form method="POST" action="<?= base_url('barcode/cetak') ?>" target="_blank" class="inline">
                <?= csrf_field() ?>
                <template x-for="id in selected"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="btn btn-primary btn-sm" :disabled="selected.length === 0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak (<span x-text="selected.length"></span> buku)
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        <?php foreach ($buku as $b): ?>
        <div class="bg-white rounded-xl border border-base-200 p-3 cursor-pointer transition-all"
             :class="selected.includes(<?= $b['id'] ?>) ? 'ring-2 ring-primary border-primary' : ''"
             @click="selected.includes(<?= $b['id'] ?>) ? selected = selected.filter(i => i !== <?= $b['id'] ?>) : selected.push(<?= $b['id'] ?>)">
            <div class="flex flex-col items-center gap-2 mb-2">
                <?php if (!empty($b['isbn'])): ?>
                    <svg class="bc-<?= $b['id'] ?>"></svg>
                <?php else: ?>
                    <div class="w-full h-12 bg-base-200 rounded flex items-center justify-center">
                        <span class="text-xs text-base-content/30">No ISBN</span>
                    </div>
                <?php endif; ?>
            </div>
            <p class="text-xs font-semibold text-center truncate"><?= esc($b['judul']) ?></p>
            <p class="text-xs text-base-content/40 text-center font-mono"><?= esc($b['isbn'] ?? '-') ?></p>
            <div class="mt-2 flex justify-center">
                <span class="badge badge-xs" x-show="selected.includes(<?= $b['id'] ?>)">Dipilih</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?= base_url('assets/js/jsbarcode.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php foreach ($buku as $b): ?>
    <?php if (!empty($b['isbn'])): ?>
    try {
        JsBarcode('.bc-<?= $b['id'] ?>', '<?= esc($b['isbn']) ?>', {
            format: 'CODE128', width: 1.2, height: 40,
            displayValue: true, fontSize: 9, margin: 2,
            lineColor: '#063a76', background: 'transparent'
        });
    } catch(e) {}
    <?php endif; ?>
    <?php endforeach; ?>
});
</script>
<?= $this->endSection() ?>
