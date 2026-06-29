CHANGELOG SIPUS

## 2026-06-28

### v4.0 - Grid View, Statistik, Kartu, Backup & Advanced Search by adee.razer

**Grid View Katalog Buku**
- Toggle antara tampilan tabel ↔ grid (card) di halaman katalog
- Grid view: card dengan cover buku, judul, penulis, kategori, stok
- Cover dari OpenLibrary API dengan fallback placeholder
- Hover effect: scale + shadow
- Preferensi tersimpan di localStorage

**Statistik Peminjaman Anggota**
- Halaman statistik pribadi untuk Anggota (/statistik)
- Data: total pinjam, sedang pinjam, total denda, rating rata-rata
- Grafik peminjaman per bulan (Chart.js, 6 bulan terakhir)
- Kategori favorit (progress bar)
- Penulis favorit (progress bar)
- Ringkasan statistik

**Print Kartu Anggota**
- Format kartu PVC standar (85.6mm × 54mm)
- Gradient biru dengan desain profesional
- QR code dari API qrserver.com (tanpa library tambahan)
- Nama + kode anggota + QR code
- Tombol cetak langsung dari browser (window.print)
- Routes: /anggota/kartu (anggota sendiri), /anggota/{id}/kartu (admin/petugas)
- Menu "Kartu Saya" di sidebar untuk Anggota

**Backup Database dari UI**
- Admin bisa download backup database dalam format SQL
- Export semua tabel dengan CREATE TABLE + INSERT statements
- Info: total tabel, total baris, daftar tabel
- File SQL bisa langsung di-restore ke MySQL/MariaDB
- Menu "Backup Database" di sidebar untuk Admin

**Advanced Search & Filter**
- Filter kategori (sudah ada)
- Filter ketersediaan: Tersedia / Habis
- Filter tahun terbit: range dari-sampai
- Sort options: Terbaru, Terlama, Judul A-Z, Judul Z-A, Tahun Terbaru, Tahun Terlama
- Search diperluas: bisa cari berdasarkan nama penulis
- Rating rata-rata ditampilkan di hasil pencarian

### v3.0 - Rating, Charts, Export, Wishlist & Dark Mode by adee.razer

**Rating & Review Buku**
- Migration CreateReviewBukuTable: tabel review_buku (id_buku, id_anggota, rating, review)
- Anggota bisa kasih bintang 1-5 + tulis review di setiap buku
- Rating rata-rata + total review tampil di detail buku
- 1 anggota hanya bisa 1 review per buku (dicek di controller)
- Star picker interaktif pakai Alpine.js
- Tombol "Ajukan Peminjaman" & review form hanya untuk Anggota
- Fix: `$sudah_review` default 0 untuk non-Anggota (undefined variable)

**Grafik & Statistik Dashboard**
- 2 chart di dashboard (Admin/Petugas saja):
  - Peminjaman per bulan (6 bulan terakhir) — vertical bar chart
  - Top 5 buku terpopuler — vertical bar chart
- Container tinggi tetap 192px (h-48), tidak stretch
- Single color outline style (biru navy), tidak warna-warni
- Label buku truncate ke 15 karakter
- Library: Chart.js v4 via CDN (cached browser)

**Export Data ke CSV**
- ExportController: 4 method (buku, anggota, peminjaman, denda)
- Format CSV dengan UTF-8 BOM (support karakter Indonesia)
- Download otomatis dengan filename ber tanggal
- Tombol export di halaman Laporan (4 tombol per jenis data)
- Routes: GET /export/{buku|anggota|peminjaman|denda}

**Wishlist / Request Buku**
- Migration CreateWishlistBukuTable: tabel wishlist_buku
- Anggota bisa request buku yang belum ada di katalog
- Isi: judul, pengarang, penerbit, alasan request
- Admin/Petugas bisa setujui/tolak dengan catatan
- Notifikasi otomatis ke anggota saat request diproses
- Menu Wishlist di sidebar untuk semua role (ikon hati)

**Dark Mode**
- Tambah tema "jaklitera-dark" di CSS (daisyUI theme)
- Toggle button di navbar (ikon sun/moon)
- Simpan preference di localStorage
- Auto-detect preferensi sistem (prefers-color-scheme)
- Script inline di layout/main.php, load sebelum render

---

### v2.0 - Landing Page, Role-Based Access & Request Flow by adee.razer

**Landing Page**
- Halaman depan profesional sebelum login dengan 8 section: Hero, Tentang, Cara Kerja, Fitur, Testimoni, FAQ, CTA, Footer
- Navbar sticky dengan smooth scroll (URL tetap bersih, tanpa hash)
- Hero section: headline "Perpustakaan Digital Serba Otomatis" + ilustrasi SVG bookshelf
- Tentang section: deskripsi + counter animasi (angka naik saat scroll)
- Cara Kerja: 3 langkah visual (Cari & Pilih → Ajukan & Disetujui → Ambil, Baca, Kembalikan)
- Fitur: 4 kartu benefit (Kilat & Tanpa Ribet, Aman & Terkontrol, Bisa dari Mana Saja, Laporan Sekali Klik)
- Testimoni: 3 review bintang 5 dari Kepala Perpustakaan, Petugas, Anggota
- FAQ: 5 pertanyaan accordion (Alpine.js)
- CTA: "Tunggu Apa Lagi?" + tombol Masuk
- Footer: gradient biru, 4 kolom (logo, navigasi, kontak, social icons)
- Animasi fade-in + slide-up (Intersection Observer) untuk semua section
- Live search di form pencarian (debounce 300ms) + clear button di dalam input
- Dropdown auto-submit (status/kategori) tanpa klik tombol Cari

**Role-Based Access Control**
- Route dibagi 3 level:
  - Semua Role: lihat buku, peminjaman, denda, notifikasi
  - Petugas + Admin: CRUD data master, transaksi, laporan, approve/reject/return
  - Admin Only: manajemen user, pengaturan
- Sidebar menyesuaikan role (Anggota: Dashboard, Buku, Peminjaman, Denda)
- Dashboard berbeda per role:
  - Anggota: widget Peminjaman Saya (status pengajuan terakhir)
  - Petugas/Admin: widget status (Pending, Dipinjam, Terlambat, Dikembalikan Hari Ini, Antrian) + Aktivitas Terbaru
- Tombol CRUD disembunyikan untuk Anggota di semua halaman
- Data difilter per role (Anggota hanya lihat miliknya sendiri)

**Request → Approval → Borrowed Flow**
- Redesign alur peminjaman:
  - Anggota ajukan → status=pending (stok tidak berkurang)
  - Petugas setujui → status=borrowed, stok-1
  - Petugas tolak → status=rejected, isi alasan
  - Petugas proses kembali → status=returned, stok+1, auto-denda
- 8 status: pending, approved, rejected, borrowed, returned, late, lost, damaged
- Anggota bisa: batalkan pengajuan, perpanjang masa pinjam
- Sistem antrian/reservasi saat stok=0 (notif otomatis saat buku tersedia)

**Database**
- Migration UpdatePeminjamanTable: ubah ENUM→VARCHAR, tambah 6 kolom baru
- Migration CreateAntrianBukuTable: tabel antrian buku
- Migration AddIdUserToAnggotaTable: link anggota ke user account
- Data buku: hapus buku test, perbanyak deskripsi semua buku (1-4 paragraf)

**Notifikasi Otomatis**
- Pengajuan baru → notif ke Petugas/Admin
- Disetujui → notif ke Anggota
- Ditolak → notif ke Anggota (dengan alasan)
- Buku tersedia dari antrian → notif ke Anggota #1

**Perbaikan Lain**
- Logout redirect ke landing page (/) bukan /login
- indexPage dikosongkan agar URL tanpa index.php
- Nama user diupdate (Rina Wijaya, Dewi Lestari, Andi Prasetyo)
- Email user diupdate ke format profesional
- Demo credentials di halaman login ditambah nama

---

### v1.7 - Notifikasi Aktif, Pagination Dinamis, 8 Halaman Detail by adee.razer
- Pagination dinamis dari tabel pengaturan
- 8 halaman detail baru (show.php) untuk semua entity
- Notifikasi otomatis dibuat dari transaksi

---

### v1.6 - Validasi, Try/Catch, Notifikasi, RoleFilter by adee.razer
- Validasi server-side ditambah ke semua controller
- Exception handling (try/catch) di semua operasi DB
- RoleFilter diterapkan ke route admin

---

### v1.5 - Import Buku, Slug Unique, Peminjaman Edit by adee.razer
- Import OpenLibrary diubah dari GET ke POST
- Slug buku dicek keunikan
- Peminjaman edit/update diperbaiki

---

### v1.4 - Fix Bug Kritis (Soft Delete, CSRF, HTML, XSS) by adee.razer
- Soft delete error: migration tambah kolom deleted_at
- CSRF diaktifkan secara global
- HTML broken diperbaiki di 3 view
- XSS fix: esc() pada output user

---

### v1.3 - Template PDF Laporan by adee.razer
- Font Times New Roman, border, header abu-abu
- Baris total + ringkasan footer
- Kop surat + tanda tangan proper

---

### v1.2 - Redesain Halaman Laporan by adee.razer
- Layout card-based dengan Alpine.js
- Loading spinner di tombol Cetak
- Toggle deselection kartu

---

### v1.1 - Responsive Tabel & Tampilan Laporan by adee.razer
- Tabel responsive: hidden kolom di HP, truncate teks panjang
- Tabel muat di mobile tanpa scroll horizontal
