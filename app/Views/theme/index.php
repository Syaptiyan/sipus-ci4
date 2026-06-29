<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Pilih Tema</h1>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <?php foreach ($themes as $t): ?>
        <button onclick="setTheme('<?= $t['id'] ?>')" class="bg-white rounded-xl border-2 border-base-200 p-4 hover:border-primary transition-all cursor-pointer text-left">
            <div class="flex gap-2 mb-3">
                <div class="w-8 h-8 rounded-full" style="background: <?= $t['primary'] ?>"></div>
                <div class="w-8 h-8 rounded-full" style="background: <?= $t['secondary'] ?>"></div>
            </div>
            <p class="font-semibold text-sm"><?= $t['name'] ?></p>
        </button>
        <?php endforeach; ?>
    </div>
</div>
<script>
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    location.reload();
}
</script>
<?= $this->endSection() ?>
