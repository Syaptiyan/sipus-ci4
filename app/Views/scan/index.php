<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-4" x-data="scanner()">
    <h1 class="text-2xl font-bold">Scan QR Code Buku</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Scanner -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
            <h3 class="font-bold mb-3">Kamera Scanner</h3>
            <div id="reader" class="rounded-lg overflow-hidden" style="width: 100%;"></div>
            <div class="mt-3 flex gap-2">
                <button @click="startScanner()" class="btn btn-primary btn-sm" :disabled="scanning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Mulai Scan
                </button>
                <button @click="stopScanner()" class="btn btn-ghost btn-sm" :disabled="!scanning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                    Stop
                </button>
            </div>
            <div class="divider">atau</div>
            <div class="flex gap-2">
                <input type="text" x-model="manualIsbn" class="input input-bordered input-sm flex-1" placeholder="Masukkan ISBN manual..." @keyup.enter="lookupIsbn(manualIsbn)">
                <button @click="lookupIsbn(manualIsbn)" class="btn btn-outline btn-sm">Cari</button>
            </div>
        </div>

        <!-- Hasil -->
        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
            <h3 class="font-bold mb-3">Hasil Scan</h3>
            <div x-show="!result" class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <p class="text-base-content/50">Scan QR code atau masukkan ISBN</p>
            </div>
            <div x-show="result && !result.success" class="alert alert-error">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span x-text="result?.message"></span>
            </div>
            <div x-show="result?.success" class="flex flex-col gap-4">
                <div class="flex gap-4">
                    <img :src="'https://covers.openlibrary.org/b/isbn/' + result?.buku?.isbn + '-M.jpg'"
                         class="w-20 h-28 object-cover rounded-lg bg-base-200"
                         onerror="this.style.display='none'">
                    <div>
                        <h3 class="font-bold text-lg" x-text="result?.buku?.judul"></h3>
                        <p class="text-sm text-base-content/60">ISBN: <span class="font-mono" x-text="result?.buku?.isbn"></span></p>
                        <p class="text-sm text-base-content/60">Kategori: <span x-text="result?.buku?.kategori"></span></p>
                        <div class="flex gap-2 mt-2">
                            <span class="badge badge-sm" :class="result?.buku?.stok_tersedia > 0 ? 'badge-success' : 'badge-error'" x-text="result?.buku?.stok_tersedia > 0 ? 'Tersedia: ' + result?.buku?.stok_tersedia : 'Habis'"></span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a :href="result?.buku?.url" class="btn btn-info btn-sm">Detail Buku</a>
                    <a x-show="result?.buku?.stok_tersedia > 0" :href="result?.buku?.url_pinjam" class="btn btn-primary btn-sm">Buat Peminjaman</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/html5-qrcode.min.js') ?>"></script>
<script>
function scanner() {
    return {
        scanning: false,
        result: null,
        manualIsbn: '',
        html5QrCode: null,

        startScanner() {
            this.scanning = true;
            this.html5QrCode = new Html5Qrcode('reader');
            this.html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    this.lookupIsbn(decodedText);
                    this.stopScanner();
                },
                (errorMessage) => {}
            ).catch((err) => {
                console.error('Camera error:', err);
                this.scanning = false;
            });
        },

        stopScanner() {
            if (this.html5QrCode) {
                this.html5QrCode.stop().then(() => {
                    this.scanning = false;
                }).catch(() => {
                    this.scanning = false;
                });
            }
        },

        lookupIsbn(isbn) {
            if (!isbn) return;
            this.result = null;
            fetch('<?= base_url('scan/lookup') ?>?isbn=' + encodeURIComponent(isbn))
                .then(res => res.json())
                .then(data => {
                    this.result = data;
                })
                .catch(() => {
                    this.result = { success: false, message: 'Terjadi kesalahan koneksi.' };
                });
        }
    };
}
</script>
<?= $this->endSection() ?>
