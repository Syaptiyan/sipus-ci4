<div align="center">

# 📚 SIPUS — Sistem Informasi Perpustakaan

**Aplikasi manajemen perpustakaan modern berbasis web**

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](https://codeigniter.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

[![Stars](https://img.shields.io/github/stars/Syaptiyan/sipus-ci4?style=social)](https://github.com/Syaptiyan/sipus-ci4/stargazers)
[![Forks](https://img.shields.io/github/forks/Syaptiyan/sipus-ci4?style=social)](https://github.com/Syaptiyan/sipus-ci4/network/members)
[![Issues](https://img.shields.io/github/issues/Syaptiyan/sipus-ci4?style=social)](https://github.com/Syaptiyan/sipus-ci4/issues)

</div>

---

## ✨ Fitur Utama

<table>
<tr>
<td width="50%">

### 📖 Manajemen Buku
- CRUD buku lengkap
- Upload cover buku
- Barcode & QR Code
- Pencarian fulltext
- Kategori, penulis, penerbit, rak

</td>
<td width="50%">

### 👥 Manajemen Anggota
- Data anggota lengkap
- Kartu anggota (cetak)
- Status keanggotaan
- Masa aktif keanggotaan

</td>
</tr>
<tr>
<td width="50%">

### 📋 Peminjaman & Pengembalian
- Proses peminjaman & pengembalian
- Tracking denda keterlambatan
- Riwayat peminjaman per anggota
- Pengajuan peminjaman online

</td>
<td width="50%">

### 📊 Dashboard & Laporan
- Dashboard statistik interaktif
- Grafik peminjaman per bulan
- Laporan buku, anggota, denda
- Export laporan

</td>
</tr>
<tr>
<td width="50%">

### 🔐 Autentikasi & Keamanan
- Login & registrasi
- Two-Factor Authentication (2FA)
- Role-based access control
- API token untuk integrasi

</td>
<td width="50%">

### ⚙️ Pengaturan Sistem
- Pengaturan perpustakaan
- Backup & restore database
- Maintenance mode
- Whitelabel (custom branding)

</td>
</tr>
</table>

### 🎯 Fitur Tambahan
- 📅 Kalender peminjaman
- 🔔 Notifikasi sistem
- ❤️ Wishlist & favorit buku
- 💡 Rekomendasi buku
- 📱 Scan barcode
- 📢 Broadcast pesan
- 📝 Audit log aktivitas
- 🌐 REST API

---

## 🛠️ Teknologi

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| **Backend** | PHP | 8.2+ |
| **Framework** | CodeIgniter | 4.7 |
| **Database** | MySQL | 8.0+ |
| **Frontend** | Tailwind CSS | 3.x |
| **JavaScript** | Alpine.js | 3.x |
| **Chart** | Chart.js | 4.x |
| **Calendar** | FullCalendar | 6.x |
| **Barcode** | JsBarcode | 4.x |
| **QR Code** | Html5-QRCode | 2.x |
| **Container** | Docker | - |

---

## 🚀 Instalasi

### Prasyarat
- PHP 8.2+ dengan ekstensi: `intl`, `mbstring`, `mysqlnd`, `json`, `gd`, `curl`
- MySQL 8.0+
- Composer 2.x
- Node.js 18+ (opsional)

### Quick Start

```bash
# 1. Clone repository
git clone https://github.com/Syaptiyan/sipus-ci4.git
cd sipus-ci4

# 2. Install dependencies
composer install

# 3. Setup environment
cp env .env
# Edit .env sesuai konfigurasi database Anda

# 4. Jalankan migrasi
php spark migrate

# 5. Seed data dummy (opsional)
php spark db:seed DatabaseSeeder

# 6. Jalankan server
php spark serve

# 7. Buka browser
# http://localhost:8080
```

### Menggunakan Docker

```bash
docker-compose up -d
# Akses: http://localhost:8080
```

### Menggunakan XAMPP/WAMP

1. Copy project ke folder `htdocs/` atau `www/`
2. Buat database `sipus` di phpMyAdmin
3. Copy `env` ke `.env` dan sesuaikan konfigurasi
4. Buka `http://localhost/sipus-ci4/public/`

---

## 👤 Akun Default

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| 🔴 Admin | `admin` | `password` | Full akses |
| 🟡 Petugas | `petugas` | `password` | Operasional |
| 🟢 Anggota | `anggota` | `password` | Lihat & pinjam |

---

## 📸 Screenshots

<div align="center">

### 🌐 Live Demo
**[https://syaptiyan.github.io/sipus](https://syaptiyan.github.io/sipus)**

Login: `admin` / `password`

---

### Login Page
![Login Page](images/login.png)

### Dashboard
![Dashboard](images/dashboard.png)

### Manajemen Buku
![Manajemen Buku](images/buku.png)

### Manajemen Anggota
![Manajemen Anggota](images/anggota.png)

### Peminjaman
![Peminjaman](images/peminjaman.png)

### Mobile View
![Mobile View](images/mobile.png)

</div>

> 📝 **Cara Screenshot:** Buka [demo](https://syaptiyan.github.io/sipus), login, lalu screenshot setiap halaman. Simpan di folder `images/` dengan nama sesuai di atas.

---

## 📁 Struktur Project

```
sipus-ci4/
├── 📁 app/
│   ├── 📁 Commands/          # CLI commands
│   ├── 📁 Config/            # Konfigurasi aplikasi
│   ├── 📁 Controllers/       # 39 controllers
│   ├── 📁 Database/          # Migrations & seeds
│   ├── 📁 Filters/           # Auth & maintenance filters
│   ├── 📁 Helpers/           # Helper functions
│   ├── 📁 Models/            # 19 models
│   ├── 📁 Modules/           # Modular architecture
│   ├── 📁 Views/             # 40+ view files
│   └── 📁 Services/          # Service layer
├── 📁 public/                # Document root
│   ├── 📁 assets/            # CSS, JS, images
│   └── 📄 index.php          # Entry point
├── 📁 writable/              # Logs, cache, session
├── 📁 docker/                # Docker configuration
├── 📄 composer.json          # PHP dependencies
├── 📄 docker-compose.yml     # Docker Compose
└── 📄 spark                  # CI4 CLI tool
```

---

## 🔌 API Documentation

SIPUS menyediakan REST API untuk integrasi:

```bash
# Generate API token
POST /api/auth/token

# Get semua buku
GET /api/buku
Authorization: Bearer {token}

# Get buku by ID
GET /api/buku/{id}

# Create peminjaman
POST /api/peminjaman
Authorization: Bearer {token}
```

📖 [Dokumentasi API Lengkap](app/Views/page/api-docs.php)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Berikut cara berkontribusi:

1. **Fork** repository ini
2. Buat **branch** baru: `git checkout -b fitur-baru`
3. **Commit** perubahan: `git commit -m 'feat: tambah fitur baru'`
4. **Push** ke branch: `git push origin fitur-baru`
5. Buat **Pull Request**

### Panduan Commit
- `feat:` fitur baru
- `fix:` perbaikan bug
- `docs:` dokumentasi
- `style:` formatting
- `refactor:` refactoring
- `test:` testing
- `chore:` maintenance

---

## 🐛 Bug Reports

Jika menemukan bug, silakan buat [issue](https://github.com/Syaptiyan/sipus-ci4/issues/new) dengan template:

1. **Deskripsi bug**
2. **Langkah reproduce**
3. **Expected behavior**
4. **Actual behavior**
5. **Screenshot** (jika ada)
6. **Environment** (PHP version, OS, browser)

---

## 📝 Changelog

### v1.0.0 (2026-06-29)
- 🎉 Initial release
- ✅ Manajemen buku, anggota, peminjaman
- ✅ Dashboard & laporan
- ✅ Autentikasi & 2FA
- ✅ REST API
- ✅ Backup & restore
- ✅ Barcode & QR Code
- ✅ Docker support

---

## 📄 License

MIT License — bebas digunakan untuk project personal maupun komersial.

---

## 👨‍💻 Author

**Syaptiyan Ade Putra**

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Syaptiyan)
[![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://instagram.com/adee.razer)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/syaptiyan-ade-putra-b4945120b)

---

<div align="center">

**⭐ Star repo ini jika bermanfaat! ⭐**

Made with ❤️ by [Syaptiyan](https://github.com/Syaptiyan)

</div>
