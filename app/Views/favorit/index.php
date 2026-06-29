<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Buku Favorit Saya</h1>

    <?php if (empty($favorit)): ?>
        <div class="bg-white rounded-xl border border-base-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <p class="text-base-content/50 mb-4">Belum ada buku favorit.</p>
            <a href="<?= base_url('buku') ?>" class="btn btn-primary btn-sm">Lihat Katalog Buku</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php foreach ($favorit as $f): ?>
            <div class="group bg-white rounded-xl border border-base-200 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative">
                <a href="<?= base_url('buku/' . $f['id_buku']) ?>" class="block">
                    <div class="aspect-[3/4] bg-base-200 relative overflow-hidden">
                        <?php if (!empty($f['isbn'])): ?>
                            <img src="https://covers.openlibrary.org/b/isbn/<?= esc($f['isbn']) ?>-L.jpg"
                                 alt="<?= esc($f['judul']) ?>"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onload="if(this.naturalWidth < 50) { this.style.display='none'; this.nextElementSibling.style.display='flex'; }"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="absolute inset-0 bg-base-200 items-center justify-center" style="display:none;">
                                <svg class="w-12 h-12 text-base-content/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-base-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-base-content/15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-base-content line-clamp-2 mb-1 group-hover:text-primary transition-colors"><?= esc($f['judul']) ?></h3>
                        <p class="text-xs text-base-content/50"><?= esc($f['nama_penulis'] ?? '-') ?></p>
                    </div>
                </a>
                <form method="POST" action="<?= base_url('favorit/' . $f['id_buku']) ?>" class="absolute top-2 right-2">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-ghost btn-xs text-red-500 hover:bg-red-50" title="Hapus dari favorit">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
