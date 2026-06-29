<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Auth (public)
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::registerStore');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::sendResetLink');
$routes->get('/reset-password', 'AuthController::resetPassword');
$routes->post('/reset-password', 'AuthController::resetPasswordStore');

// Profil
$routes->get('/profil', 'ProfilController::index', ['filter' => 'auth']);
$routes->post('/profil', 'ProfilController::update', ['filter' => 'auth']);
$routes->get('/profil/ubah-password', 'ProfilController::ubahPassword', ['filter' => 'auth']);
$routes->post('/profil/ubah-password', 'ProfilController::ubahPasswordStore', ['filter' => 'auth']);
$routes->get('/profil/login-history', 'ProfilController::loginHistory', ['filter' => 'auth']);

// Landing page (public)
$routes->get('/', 'Home::index');
$routes->get('/maintenance', 'Home::maintenance');

// Dashboard (all roles)
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

// ========== ALL ROLES (Anggota, Petugas, Admin) ==========
// Read-only: lihat index + detail saja

$routes->get('/buku', 'BukuController::index', ['filter' => 'auth']);
$routes->post('/buku/(:num)/review', 'BukuController::submitReview/$1', ['filter' => 'auth']);
$routes->get('/buku/(:num)', 'BukuController::show/$1', ['filter' => 'auth']);

$routes->get('/peminjaman', 'PeminjamanController::index', ['filter' => 'auth']);
$routes->get('/peminjaman/ajukan', 'PeminjamanController::ajukan', ['filter' => 'auth']);
$routes->post('/peminjaman/ajukan', 'PeminjamanController::simpanAjuan', ['filter' => 'auth']);
$routes->post('/peminjaman/antrian/(:num)', 'PeminjamanController::masukAntrian/$1', ['filter' => 'auth']);
$routes->post('/peminjaman/(:num)/batalkan', 'PeminjamanController::batalkan/$1', ['filter' => 'auth']);
$routes->post('/peminjaman/(:num)/perpanjang', 'PeminjamanController::perpanjang/$1', ['filter' => 'auth']);
$routes->get('/peminjaman/(:num)', 'PeminjamanController::show/$1', ['filter' => 'auth']);

$routes->get('/denda', 'DendaController::index', ['filter' => 'auth']);
$routes->get('/denda/(:num)', 'DendaController::show/$1', ['filter' => 'auth']);
$routes->get('/denda/(:num)/kwitansi', 'DendaController::kwitansi/$1', ['filter' => 'auth']);

$routes->get('/notifikasi', 'NotifikasiController::index', ['filter' => 'auth']);
$routes->post('/notifikasi/read/(:num)', 'NotifikasiController::read/$1', ['filter' => 'auth']);

// ========== PETUGAS + ADMIN only ==========
// Buku CRUD
$routes->get('/buku/create', 'BukuController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/buku/new', 'BukuController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/buku', 'BukuController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/buku/(:num)/edit', 'BukuController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/buku/(:num)', 'BukuController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/buku/import', 'BukuController::import', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/buku/(:num)/restore', 'BukuController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/buku/delete/(:num)', 'BukuController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Kategori
$routes->get('/kategori', 'KategoriController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kategori/create', 'KategoriController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kategori/new', 'KategoriController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/kategori', 'KategoriController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kategori/(:num)', 'KategoriController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kategori/(:num)/edit', 'KategoriController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/kategori/(:num)', 'KategoriController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kategori/(:num)/restore', 'KategoriController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/kategori/delete/(:num)', 'KategoriController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Penulis
$routes->get('/penulis', 'PenulisController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penulis/create', 'PenulisController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penulis/new', 'PenulisController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/penulis', 'PenulisController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penulis/(:num)', 'PenulisController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penulis/(:num)/edit', 'PenulisController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/penulis/(:num)', 'PenulisController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penulis/(:num)/restore', 'PenulisController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/penulis/delete/(:num)', 'PenulisController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Penerbit
$routes->get('/penerbit', 'PenerbitController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penerbit/create', 'PenerbitController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penerbit/new', 'PenerbitController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/penerbit', 'PenerbitController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penerbit/(:num)', 'PenerbitController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penerbit/(:num)/edit', 'PenerbitController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/penerbit/(:num)', 'PenerbitController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/penerbit/(:num)/restore', 'PenerbitController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/penerbit/delete/(:num)', 'PenerbitController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Rak
$routes->get('/rak', 'RakController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/rak/create', 'RakController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/rak/new', 'RakController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/rak', 'RakController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/rak/(:num)', 'RakController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/rak/(:num)/edit', 'RakController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/rak/(:num)', 'RakController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/rak/(:num)/restore', 'RakController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/rak/delete/(:num)', 'RakController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Anggota
$routes->get('/anggota', 'AnggotaController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/anggota/create', 'AnggotaController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/anggota/new', 'AnggotaController::create', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/anggota', 'AnggotaController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/anggota/(:num)', 'AnggotaController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/anggota/(:num)/edit', 'AnggotaController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/anggota/(:num)', 'AnggotaController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/anggota/(:num)/restore', 'AnggotaController::restore/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/anggota/delete/(:num)', 'AnggotaController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Peminjaman CRUD (new, store, edit, update, delete, approve, reject, return)
$routes->get('/peminjaman/new', 'PeminjamanController::new', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/peminjaman', 'PeminjamanController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/peminjaman/(:num)/setujui', 'PeminjamanController::setujui/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/peminjaman/(:num)/tolak', 'PeminjamanController::tolak/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post'], '/peminjaman/(:num)/kembali', 'PeminjamanController::prosesKembali/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/peminjaman/(:num)/edit', 'PeminjamanController::edit/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['post', 'put'], '/peminjaman/(:num)', 'PeminjamanController::update/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/peminjaman/delete/(:num)', 'PeminjamanController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Pengembalian
$routes->get('/pengembalian', 'PengembalianController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/pengembalian/new', 'PengembalianController::new', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/pengembalian', 'PengembalianController::store', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/pengembalian/(:num)', 'PengembalianController::show/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/pengembalian/delete/(:num)', 'PengembalianController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Denda (bayar & delete)
$routes->match(['get', 'post'], '/denda/bayar/(:num)', 'DendaController::bayar/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->match(['get', 'post', 'delete'], '/denda/delete/(:num)', 'DendaController::delete/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Laporan
$routes->get('/laporan', 'LaporanController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/laporan/print', 'LaporanController::print', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Export CSV
$routes->get('/export/buku', 'ExportController::buku', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/export/anggota', 'ExportController::anggota', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/export/peminjaman', 'ExportController::peminjaman', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/export/denda', 'ExportController::denda', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Wishlist
$routes->get('/wishlist', 'WishlistController::index', ['filter' => 'auth']);
$routes->get('/wishlist/create', 'WishlistController::create', ['filter' => 'auth']);
$routes->post('/wishlist', 'WishlistController::store', ['filter' => 'auth']);
$routes->post('/wishlist/(:num)/proses', 'WishlistController::proses/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Favorit Buku
$routes->get('/favorit', 'FavoritController::index', ['filter' => 'auth']);
$routes->post('/favorit/(:num)', 'FavoritController::toggle/$1', ['filter' => 'auth']);

// Statistik Anggota
$routes->get('/statistik', 'AnggotaController::statistik', ['filter' => 'auth']);

// Kartu Anggota
$routes->get('/anggota/kartu', 'AnggotaController::kartuSaya', ['filter' => 'auth']);
$routes->get('/anggota/(:num)/kartu', 'AnggotaController::kartu/$1', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Backup Database
$routes->get('/backup', 'BackupController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/backup/download', 'BackupController::download', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/backup/restore', 'BackupController::restore', ['filter' => ['auth', 'role:Admin']]);
$routes->post('/backup/restore', 'BackupController::restoreProcess', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/backup/history', 'BackupController::history', ['filter' => ['auth', 'role:Admin']]);

// Audit & Monitoring
$routes->get('/audit/login-history', 'AuditController::loginHistory', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/audit/statistik', 'AuditController::statistikUser', ['filter' => ['auth', 'role:Admin']]);

// System Admin
$routes->get('/system/health', 'SystemController::health', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/system/info', 'SystemController::info', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/system/logs', 'SystemController::logs', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/system/storage', 'SystemController::storage', ['filter' => ['auth', 'role:Admin']]);

// Scan QR Code
$routes->get('/scan', 'ScanController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/scan/lookup', 'ScanController::lookup', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Barcode
$routes->get('/barcode', 'BarcodeController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/barcode/cetak', 'BarcodeController::cetak', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Broadcast
$routes->get('/broadcast', 'BroadcastController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->post('/broadcast/send', 'BroadcastController::send', ['filter' => ['auth', 'role:Admin']]);

// Version History
$routes->get('/version', 'VersionController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Rekomendasi
$routes->get('/rekomendasi', 'RekomendasiController::index', ['filter' => 'auth']);

// Label Rak
$routes->get('/label', 'LabelController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->post('/label/cetak', 'LabelController::cetak', ['filter' => ['auth', 'role:Admin,Petugas']]);

// Pages (public)
$routes->get('/tentang', 'PageController::tentang');
$routes->get('/changelog', 'PageController::changelog');
$routes->get('/bantuan', 'PageController::bantuan', ['filter' => 'auth']);

// 2FA
$routes->get('/2fa', 'TwoFactorController::index', ['filter' => 'auth']);
$routes->get('/2fa/enable', 'TwoFactorController::enable', ['filter' => 'auth']);
$routes->post('/2fa/verify', 'TwoFactorController::verify', ['filter' => 'auth']);
$routes->get('/2fa/disable', 'TwoFactorController::disable', ['filter' => 'auth']);

// Theme
$routes->get('/theme', 'ThemeController::index', ['filter' => 'auth']);

// White Label
$routes->get('/whitelabel', 'WhitelabelController::index', ['filter' => ['auth', 'role:Admin']]);

// Kalender
$routes->get('/kalender', 'KalenderController::index', ['filter' => ['auth', 'role:Admin,Petugas']]);
$routes->get('/kalender/events', 'KalenderController::events', ['filter' => ['auth', 'role:Admin,Petugas']]);

// OAuth
$routes->get('/oauth/google', 'OAuthController::google');
$routes->get('/oauth/google/callback', 'OAuthController::googleCallback');

// Plugin
$routes->get('/plugin', 'PluginController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/plugin/(:segment)/toggle', 'PluginController::toggle/$1', ['filter' => ['auth', 'role:Admin']]);

// Update
$routes->get('/update', 'UpdateController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/update/check', 'UpdateController::check', ['filter' => ['auth', 'role:Admin']]);
$routes->post('/update/apply', 'UpdateController::apply', ['filter' => ['auth', 'role:Admin']]);

// GraphQL API
$routes->post('/graphql', 'Api\GraphQLController::index');

// API Documentation
$routes->get('/api/docs', 'PageController::apiDocs', ['filter' => ['auth', 'role:Admin']]);

// REST API
$routes->group('/api', function($routes) {
    $routes->get('buku', 'Api\BukuApiController::index');
    $routes->get('buku/(:num)', 'Api\BukuApiController::show/$1');
    $routes->get('peminjaman', 'Api\PeminjamanApiController::index');
    $routes->get('peminjaman/(:num)', 'Api\PeminjamanApiController::show/$1');
});

// ========== ADMIN only ==========
$routes->get('/user', 'UserController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/pending', 'UserController::pending', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/create', 'UserController::create', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/new', 'UserController::create', ['filter' => ['auth', 'role:Admin']]);
$routes->post('/user', 'UserController::store', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/(:num)/edit', 'UserController::edit/$1', ['filter' => ['auth', 'role:Admin']]);
$routes->match(['post', 'put'], '/user/(:num)', 'UserController::update/$1', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/(:num)/restore', 'UserController::restore/$1', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/(:num)/toggle-active', 'UserController::toggleActive/$1', ['filter' => ['auth', 'role:Admin']]);
$routes->get('/user/(:num)/activate', 'UserController::activate/$1', ['filter' => ['auth', 'role:Admin']]);
$routes->match(['get', 'post', 'delete'], '/user/delete/(:num)', 'UserController::delete/$1', ['filter' => ['auth', 'role:Admin']]);

$routes->get('/pengaturan', 'SettingController::index', ['filter' => ['auth', 'role:Admin']]);
$routes->post('/pengaturan', 'SettingController::update', ['filter' => ['auth', 'role:Admin']]);
