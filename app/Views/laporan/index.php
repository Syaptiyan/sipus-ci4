<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-6" x-data="{ jenis: '', loading: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="text-2xl font-bold">Cetak Laporan</h1>
        <template x-if="jenis">
            <span class="badge badge-primary badge-sm">
                Terpilih: <span x-text="{
                    buku: 'Data Buku',
                    peminjaman: 'Data Peminjaman',
                    anggota: 'Data Anggota',
                    denda: 'Data Denda'
                }[jenis]"></span>
            </span>
        </template>
    </div>

    <form action="<?= base_url('laporan/print') ?>" method="post" target="_blank" @submit="loading = true; setTimeout(() => loading = false, 5000)">
        <?= csrf_field() ?>
        <input type="hidden" name="jenis" :value="jenis">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="cursor-pointer rounded-xl" :class="jenis === 'buku' ? 'ring-2 ring-primary' : ''" @click="jenis = jenis === 'buku' ? '' : 'buku'">
                <div class="p-4 rounded-xl border-2 bg-white transition-all duration-200" :class="jenis === 'buku' ? 'border-primary bg-primary/5' : 'border-base-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <svg x-show="jenis === 'buku'" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="font-semibold text-sm">Data Buku</p>
                    <p class="text-xs text-base-content/50 mt-1">Laporan daftar seluruh buku</p>
                </div>
            </div>

            <div class="cursor-pointer rounded-xl" :class="jenis === 'peminjaman' ? 'ring-2 ring-primary' : ''" @click="jenis = jenis === 'peminjaman' ? '' : 'peminjaman'">
                <div class="p-4 rounded-xl border-2 bg-white transition-all duration-200" :class="jenis === 'peminjaman' ? 'border-primary bg-primary/5' : 'border-base-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <svg x-show="jenis === 'peminjaman'" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="font-semibold text-sm">Data Peminjaman</p>
                    <p class="text-xs text-base-content/50 mt-1">Laporan riwayat peminjaman</p>
                </div>
            </div>

            <div class="cursor-pointer rounded-xl" :class="jenis === 'anggota' ? 'ring-2 ring-primary' : ''" @click="jenis = jenis === 'anggota' ? '' : 'anggota'">
                <div class="p-4 rounded-xl border-2 bg-white transition-all duration-200" :class="jenis === 'anggota' ? 'border-primary bg-primary/5' : 'border-base-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <svg x-show="jenis === 'anggota'" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="font-semibold text-sm">Data Anggota</p>
                    <p class="text-xs text-base-content/50 mt-1">Laporan daftar seluruh anggota</p>
                </div>
            </div>

            <div class="cursor-pointer rounded-xl" :class="jenis === 'denda' ? 'ring-2 ring-primary' : ''" @click="jenis = jenis === 'denda' ? '' : 'denda'">
                <div class="p-4 rounded-xl border-2 bg-white transition-all duration-200" :class="jenis === 'denda' ? 'border-primary bg-primary/5' : 'border-base-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <svg x-show="jenis === 'denda'" class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <p class="font-semibold text-sm">Data Denda</p>
                    <p class="text-xs text-base-content/50 mt-1">Laporan data denda & pembayaran</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
            <p class="text-sm font-semibold mb-3">Filter Tanggal <span class="text-xs text-base-content/50 font-normal">(hanya untuk Peminjaman & Denda)</span></p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Dari Tanggal</span>
                    </label>
                    <input type="date" name="dari" class="input input-bordered input-sm" :disabled="jenis && jenis !== 'peminjaman' && jenis !== 'denda'">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Sampai Tanggal</span>
                    </label>
                    <input type="date" name="sampai" class="input input-bordered input-sm" :disabled="jenis && jenis !== 'peminjaman' && jenis !== 'denda'">
                </div>
                <button type="submit" class="btn btn-primary" :disabled="!jenis || loading">
                    <svg x-show="!loading" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span x-show="loading" class="loading loading-spinner loading-sm mr-1"></span>
                    <span x-text="loading ? 'Mencetak...' : 'Cetak Laporan'"></span>
                </button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-base-200 p-4 md:p-6">
        <p class="text-sm font-semibold mb-3">Export Data (CSV)</p>
        <p class="text-xs text-base-content/50 mb-4">Download data mentah dalam format CSV yang bisa dibuka di Excel.</p>
        <div class="flex flex-wrap gap-2">
            <a href="<?= base_url('export/buku') ?>" class="btn btn-outline btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Buku
            </a>
            <a href="<?= base_url('export/anggota') ?>" class="btn btn-outline btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Anggota
            </a>
            <a href="<?= base_url('export/peminjaman') ?>" class="btn btn-outline btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Peminjaman
            </a>
            <a href="<?= base_url('export/denda') ?>" class="btn btn-outline btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Denda
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
