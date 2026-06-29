<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <h3 class="text-lg font-bold mb-4">Notifikasi</h3>

        <?php if (empty($notifikasi)): ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="text-base-content/50">Tidak ada notifikasi</p>
            </div>
        <?php else: ?>
            <div class="space-y-2">
                <?php foreach ($notifikasi as $n): ?>
                <div class="flex items-start gap-3 p-4 rounded-xl <?= $n['read'] ? 'bg-base-200/50' : 'bg-primary/5 border border-primary/20' ?>">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <?php if (!$n['read']): ?>
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            <?php endif; ?>
                            <h4 class="font-semibold text-sm <?= $n['read'] ? '' : 'text-primary' ?>"><?= $n['judul'] ?></h4>
                            <span class="text-xs text-base-content/50 ml-auto"><?= format_datetime($n['created_at']) ?></span>
                        </div>
                        <p class="text-sm text-base-content/70"><?= $n['pesan'] ?></p>
                        <div class="flex items-center gap-2 mt-2">
                            <?php if ($n['type']): ?>
                            <span class="badge badge-sm <?= $n['type'] === 'success' ? 'badge-success' : ($n['type'] === 'warning' ? 'badge-warning' : ($n['type'] === 'error' ? 'badge-error' : 'badge-info')) ?>">
                                <?= ucfirst($n['type']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!$n['read']): ?>
                            <button onclick="markRead(<?= $n['id'] ?>)" class="btn btn-ghost btn-xs">Tandai Dibaca</button>
                            <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4">
                <?php if (!empty($pager_links)): ?><?= $pager_links ?><?php endif; ?>
            </div>
        <?php endif; ?>
</div>

<script>
function markRead(id) {
    fetch('<?= base_url('notifikasi/read') ?>/' + id, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json()).then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
<?= $this->endSection() ?>
