<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col gap-4" x-data="{ view: localStorage.getItem('bukuView') || 'table' }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Data Buku</h1>
        <div class="flex gap-2">
            <div class="btn-group">
                <button class="btn btn-sm" :class="view === 'table' ? 'btn-active' : 'btn-ghost'" @click="view = 'table'; localStorage.setItem('bukuView', 'table')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </button>
                <button class="btn btn-sm" :class="view === 'grid' ? 'btn-active' : 'btn-ghost'" @click="view = 'grid'; localStorage.setItem('bukuView', 'grid')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
            </div>
            <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
            <a href="<?= base_url('buku/new') ?>" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Buku
            </a>
            <button class="btn btn-outline btn-sm" onclick="importModal.showModal()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import OpenLibrary
            </button>
            <?php endif; ?>
        </div>
    </div>

    <form method="GET" action="<?= base_url('buku') ?>" x-data="{ search: '<?= esc($search ?? '') ?>' }" class="flex flex-col gap-3">
        <div class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1 max-w-sm">
                <input type="text" name="search" x-model="search" @input.debounce.300ms="$el.form.submit()" class="input input-bordered input-sm w-full pr-8" placeholder="Cari judul, ISBN, atau penulis..." value="<?= esc($search ?? '') ?>">
                <?php if ($search || ($kategori_filter ?? '') || ($penerbit_filter ?? '') || ($rak_filter ?? '') || ($tahun_dari ?? '') || ($tersedia ?? '') || ($rating_min ?? '') || ($sort ?? '')): ?>
                <a href="<?= base_url('buku') ?>" class="absolute right-2 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content text-sm">✕</a>
                <?php endif; ?>
            </div>
            <select name="kategori" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori_list as $k): ?>
                    <option value="<?= $k['id'] ?>" <?= ($kategori_filter ?? '') == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="penerbit" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Semua Penerbit</option>
                <?php foreach ($penerbit_list as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($penerbit_filter ?? '') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="rak" class="select select-bordered select-sm w-full sm:w-36" onchange="this.form.submit()">
                <option value="">Semua Rak</option>
                <?php foreach ($rak_list as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= ($rak_filter ?? '') == $r['id'] ? 'selected' : '' ?>><?= esc($r['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Terbaru</option>
                <option value="terlama" <?= ($sort ?? '') === 'terlama' ? 'selected' : '' ?>>Terlama</option>
                <option value="judul_az" <?= ($sort ?? '') === 'judul_az' ? 'selected' : '' ?>>Judul A-Z</option>
                <option value="judul_za" <?= ($sort ?? '') === 'judul_za' ? 'selected' : '' ?>>Judul Z-A</option>
                <option value="tahun_baru" <?= ($sort ?? '') === 'tahun_baru' ? 'selected' : '' ?>>Tahun Terbaru</option>
                <option value="tahun_lama" <?= ($sort ?? '') === 'tahun_lama' ? 'selected' : '' ?>>Tahun Terlama</option>
                <option value="populer" <?= ($sort ?? '') === 'populer' ? 'selected' : '' ?>>Terpopuler</option>
            </select>
        </div>
        <div class="flex flex-wrap gap-2">
            <select name="tersedia" class="select select-bordered select-sm w-full sm:w-36" onchange="this.form.submit()">
                <option value="">Semua Stok</option>
                <option value="tersedia" <?= ($tersedia ?? '') === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= ($tersedia ?? '') === 'habis' ? 'selected' : '' ?>>Habis</option>
            </select>
            <select name="rating_min" class="select select-bordered select-sm w-full sm:w-36" onchange="this.form.submit()">
                <option value="">Semua Rating</option>
                <option value="1" <?= ($rating_min ?? '') === '1' ? 'selected' : '' ?>>1+ ★</option>
                <option value="2" <?= ($rating_min ?? '') === '2' ? 'selected' : '' ?>>2+ ★</option>
                <option value="3" <?= ($rating_min ?? '') === '3' ? 'selected' : '' ?>>3+ ★</option>
                <option value="4" <?= ($rating_min ?? '') === '4' ? 'selected' : '' ?>>4+ ★</option>
            </select>
            <div class="flex gap-1 items-center">
                <input type="number" name="tahun_dari" class="input input-bordered input-sm w-24" placeholder="Dari" value="<?= esc($tahun_dari ?? '') ?>" onchange="this.form.submit()">
                <span class="text-xs text-base-content/40">-</span>
                <input type="number" name="tahun_sampai" class="input input-bordered input-sm w-24" placeholder="Sampai" value="<?= esc($tahun_sampai ?? '') ?>" onchange="this.form.submit()">
            </div>
            <button type="submit" class="btn btn-outline btn-sm">Cari</button>
        </div>
    </form>

    <!-- Table View -->
    <div x-show="view === 'table'" class="overflow-x-auto">
        <table class="table table-zebra table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th class="hidden md:table-cell">Kategori</th>
                    <th class="hidden md:table-cell">Penulis</th>
                    <th class="hidden md:table-cell">Penerbit</th>
                    <th>Stok</th>
                    <th>Tersedia</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($buku)): ?>
                    <tr><td colspan="9" class="text-center">Tidak ada data buku.</td></tr>
                <?php else: ?>
                    <?php $no = ($currentPage - 1) * $perPage + 1; ?>
                    <?php foreach ($buku as $b): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if (!empty($b['isbn'])): ?>
                                    <img src="https://covers.openlibrary.org/b/isbn/<?= esc($b['isbn']) ?>-S.jpg"
                                         alt="<?= esc($b['judul']) ?>"
                                         loading="lazy"
                                         class="w-8 h-11 object-cover rounded shadow-sm bg-base-200"
                                         onload="if(this.naturalWidth < 20) this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-8 h-11 bg-base-200 rounded items-center justify-center" style="display:none;">
                                        <svg class="w-3 h-3 text-base-content/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                <?php else: ?>
                                    <div class="w-8 h-11 bg-base-200 rounded flex items-center justify-center">
                                        <svg class="w-3 h-3 text-base-content/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="max-w-[200px] truncate"><?= esc($b['judul']) ?></td>
                            <td class="hidden md:table-cell"><span class="badge badge-outline"><?= esc($b['nama_kategori']) ?></span></td>
                            <td class="hidden md:table-cell"><?= esc($b['nama_penulis']) ?></td>
                            <td class="hidden md:table-cell"><?= esc($b['nama_penerbit']) ?></td>
                            <td><?= $b['stok'] ?></td>
                            <td>
                                <?php if ($b['stok_tersedia'] > 0): ?>
                                    <span class="badge badge-success badge-sm"><?= $b['stok_tersedia'] ?></span>
                                <?php else: ?>
                                    <span class="badge badge-error badge-sm"><?= $b['stok_tersedia'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="flex gap-1">
                                 <a href="<?= base_url('buku/' . $b['id']) ?>" class="btn btn-info btn-xs">Detail</a>
                                <?php if (in_array($user['role'], ['Admin', 'Petugas'])): ?>
                                <a href="<?= base_url('buku/' . $b['id'] . '/edit') ?>" class="btn btn-warning btn-xs">Edit</a>
                                <a href="<?= base_url('buku/delete/' . $b['id']) ?>" class="btn btn-error btn-xs" onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus buku ini?')) { document.getElementById('delete-form-<?= $b['id'] ?>').submit(); }">Delete</a>
                                <form id="delete-form-<?= $b['id'] ?>" method="POST" action="<?= base_url('buku/delete/' . $b['id']) ?>" class="hidden">
                                    <?= csrf_field() ?>
                                </form>
                                <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Grid View -->
    <div x-show="view === 'grid'" x-cloak>
        <?php if (empty($buku)): ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-base-content/50">Tidak ada data buku.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php foreach ($buku as $b): ?>
                <a href="<?= base_url('buku/' . $b['id']) ?>" class="group bg-white rounded-xl border border-base-200 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-[3/4] bg-base-200 relative overflow-hidden">
                        <?php if (!empty($b['isbn'])): ?>
                            <img src="https://covers.openlibrary.org/b/isbn/<?= esc($b['isbn']) ?>-L.jpg"
                                 alt="<?= esc($b['judul']) ?>"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onload="if(this.naturalWidth < 50) { this.style.display='none'; this.nextElementSibling.style.display='flex'; }"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="absolute inset-0 bg-base-200 items-center justify-center" style="display:none;">
                                <svg class="w-12 h-12 text-base-content/15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-base-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-base-content/15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <?php if ($b['stok_tersedia'] < 1): ?>
                        <div class="absolute top-2 right-2">
                            <span class="badge badge-error badge-sm">Habis</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-base-content line-clamp-2 mb-1 group-hover:text-primary transition-colors"><?= esc($b['judul']) ?></h3>
                        <p class="text-xs text-base-content/50 mb-2"><?= esc($b['nama_penulis'] ?? '-') ?></p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-base-content/40"><?= esc($b['nama_kategori'] ?? '-') ?></span>
                            <?php if ($b['stok_tersedia'] > 0): ?>
                                <span class="text-xs text-success font-medium"><?= $b['stok_tersedia'] ?> tersedia</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($pager_links)): ?><?= $pager_links ?><?php endif; ?>
</div>

<dialog id="importModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Import Buku dari OpenLibrary</h3>
        <form id="importForm">
            <?= csrf_field() ?>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">ISBN</span>
                </label>
                <input type="text" name="isbn" class="input input-bordered" placeholder="Masukkan ISBN..." required>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-primary" id="importBtn">
                    <span id="importSpinner" class="loading loading-spinner loading-sm hidden"></span>
                    Import
                </button>
                <button type="button" class="btn" onclick="importModal.close()">Batal</button>
            </div>
        </form>
        <div id="importResult" class="mt-4 hidden"></div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<script>
document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('importBtn');
    const spinner = document.getElementById('importSpinner');
    const result = document.getElementById('importResult');

    btn.disabled = true;
    spinner.classList.remove('hidden');
    result.classList.add('hidden');

    const formData = new FormData(this);
    const params = new URLSearchParams();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('<?= base_url('buku/import') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            isbn: formData.get('isbn'),
            csrf_test_name: csrfToken,
        })
    })
    .then(res => res.json())
    .then(data => {
        result.classList.remove('hidden');
        if (data.success) {
            result.className = 'mt-4 alert alert-success';
            result.textContent = data.message;
            setTimeout(() => { location.reload(); }, 1500);
        } else {
            result.className = 'mt-4 alert alert-error';
            result.textContent = data.message;
        }
    })
    .catch(err => {
        result.classList.remove('hidden');
        result.className = 'mt-4 alert alert-error';
        result.textContent = 'Terjadi kesalahan koneksi.';
    })
    .finally(() => {
        btn.disabled = false;
        spinner.classList.add('hidden');
    });
});
</script>
<?= $this->endSection() ?>
