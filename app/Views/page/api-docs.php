<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <h1 class="text-2xl font-bold">API Documentation</h1>

    <div class="bg-white rounded-xl border border-base-200 p-6">
        <h3 class="font-bold mb-2">Authentication</h3>
        <p class="text-sm text-base-content/60 mb-3">Semua API request harus menyertakan token di header:</p>
        <div class="bg-base-200 rounded-lg p-3 font-mono text-sm">
            Authorization: Bearer <?= esc($api_token) ?>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-6">
        <h3 class="font-bold mb-4">Endpoints</h3>

        <div class="space-y-4">
            <div class="border border-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge badge-success badge-sm">GET</span>
                    <code class="text-sm">/api/buku</code>
                </div>
                <p class="text-sm text-base-content/60 mb-2">Daftar semua buku</p>
                <p class="text-xs text-base-content/40">Query: search, kategori, page</p>
            </div>

            <div class="border border-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge badge-success badge-sm">GET</span>
                    <code class="text-sm">/api/buku/{id}</code>
                </div>
                <p class="text-sm text-base-content/60">Detail buku berdasarkan ID</p>
            </div>

            <div class="border border-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge badge-success badge-sm">GET</span>
                    <code class="text-sm">/api/peminjaman</code>
                </div>
                <p class="text-sm text-base-content/60 mb-2">Daftar peminjaman</p>
                <p class="text-xs text-base-content/40">Query: status, page</p>
            </div>

            <div class="border border-base-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge badge-success badge-sm">GET</span>
                    <code class="text-sm">/api/peminjaman/{id}</code>
                </div>
                <p class="text-sm text-base-content/60">Detail peminjaman + daftar buku</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-base-200 p-6">
        <h3 class="font-bold mb-4">Contoh Request</h3>
        <div class="bg-base-200 rounded-lg p-4 font-mono text-sm space-y-2">
            <p><span class="text-success">GET</span> /api/buku?search=clean+code</p>
            <p><span class="text-success">GET</span> /api/buku?kategori=1&page=2</p>
            <p><span class="text-success">GET</span> /api/peminjaman?status=borrowed</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
