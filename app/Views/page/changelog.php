<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <h1 class="text-2xl font-bold">Changelog</h1>
    <div class="bg-white rounded-xl border border-base-200 p-6">
        <div class="prose prose-sm max-w-none">
            <?php
            $lines = explode("\n", $changelog);
            foreach ($lines as $line):
                if (strpos($line, '### v') === 0): ?>
                    <h3 class="text-lg font-bold text-primary mt-6 mb-2"><?= esc(substr($line, 4)) ?></h3>
                <?php elseif (strpos($line, '**') === 0 && substr($line, -2) === '**'): ?>
                    <h4 class="font-semibold text-base-content mt-4 mb-1"><?= esc(str_replace('*', '', $line)) ?></h4>
                <?php elseif (strpos($line, '- ') === 0): ?>
                    <p class="text-sm text-base-content/70 ml-4 mb-1"><?= esc(substr($line, 2)) ?></p>
                <?php elseif (trim($line) === '---'): ?>
                    <hr class="my-4 border-base-200">
                <?php elseif (trim($line) !== ''): ?>
                    <p class="text-sm text-base-content/60 mb-1"><?= esc($line) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
