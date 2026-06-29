<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDatabaseIndexes extends Migration
{
    public function up()
    {
        $indexes = [
            ['table' => 'peminjaman', 'column' => 'status', 'name' => 'idx_peminjaman_status'],
            ['table' => 'peminjaman', 'column' => 'id_anggota', 'name' => 'idx_peminjaman_anggota'],
            ['table' => 'peminjaman', 'column' => 'deleted_at', 'name' => 'idx_peminjaman_deleted'],
            ['table' => 'peminjaman', 'column' => 'tanggal_pengajuan', 'name' => 'idx_peminjaman_tgl'],
            ['table' => 'detail_peminjaman', 'column' => 'id_peminjaman', 'name' => 'idx_detail_pjm'],
            ['table' => 'detail_peminjaman', 'column' => 'id_buku', 'name' => 'idx_detail_buku'],
            ['table' => 'buku', 'column' => 'deleted_at', 'name' => 'idx_buku_deleted'],
            ['table' => 'buku', 'column' => 'id_kategori', 'name' => 'idx_buku_kategori'],
            ['table' => 'buku', 'column' => 'stok_tersedia', 'name' => 'idx_buku_stok'],
            ['table' => 'buku', 'column' => 'judul', 'name' => 'idx_buku_judul'],
            ['table' => 'anggota', 'column' => 'id_user', 'name' => 'idx_anggota_user'],
            ['table' => 'anggota', 'column' => 'deleted_at', 'name' => 'idx_anggota_deleted'],
            ['table' => 'review_buku', 'column' => 'id_buku', 'name' => 'idx_review_buku'],
            ['table' => 'review_buku', 'column' => 'id_anggota', 'name' => 'idx_review_anggota'],
            ['table' => 'favorit_buku', 'column' => 'id_anggota', 'name' => 'idx_favorit_anggota'],
            ['table' => 'favorit_buku', 'column' => 'id_buku', 'name' => 'idx_favorit_buku'],
            ['table' => 'wishlist_buku', 'column' => 'id_anggota', 'name' => 'idx_wishlist_anggota'],
            ['table' => 'wishlist_buku', 'column' => 'status', 'name' => 'idx_wishlist_status'],
            ['table' => 'antrian_buku', 'column' => 'id_buku', 'name' => 'idx_antrian_buku'],
            ['table' => 'antrian_buku', 'column' => 'status', 'name' => 'idx_antrian_status'],
            ['table' => 'denda', 'column' => 'id_peminjaman', 'name' => 'idx_denda_peminjaman'],
            ['table' => 'denda', 'column' => 'status', 'name' => 'idx_denda_status'],
            ['table' => 'pengembalian', 'column' => 'id_peminjaman', 'name' => 'idx_pengembalian_pjm'],
            ['table' => 'log_aktivitas', 'column' => 'id_user', 'name' => 'idx_log_user'],
            ['table' => 'log_aktivitas', 'column' => 'created_at', 'name' => 'idx_log_created'],
            ['table' => 'login_history', 'column' => 'id_user', 'name' => 'idx_login_user'],
            ['table' => 'login_history', 'column' => 'status', 'name' => 'idx_login_status'],
            ['table' => 'notifikasi', 'column' => 'id_user', 'name' => 'idx_notif_user'],
            ['table' => 'notifikasi', 'column' => 'read', 'name' => 'idx_notif_read'],
            ['table' => 'users', 'column' => 'email', 'name' => 'idx_users_email'],
            ['table' => 'users', 'column' => 'active', 'name' => 'idx_users_active'],
        ];

        foreach ($indexes as $idx) {
            $existing = $this->db->query("SHOW INDEX FROM `{$idx['table']}` WHERE Key_name = '{$idx['name']}'")->getNumRows();
            if ($existing === 0) {
                try {
                    $this->db->query("ALTER TABLE `{$idx['table']}` ADD INDEX `{$idx['name']}` (`{$idx['column']}`)");
                } catch (\Exception $e) {
                    // Index mungkin sudah ada atau kolom tidak ditemukan
                }
            }
        }
    }

    public function down()
    {
        $indexes = [
            ['table' => 'peminjaman', 'name' => 'idx_peminjaman_status'],
            ['table' => 'peminjaman', 'name' => 'idx_peminjaman_anggota'],
            ['table' => 'peminjaman', 'name' => 'idx_peminjaman_deleted'],
            ['table' => 'peminjaman', 'name' => 'idx_peminjaman_tgl'],
            ['table' => 'detail_peminjaman', 'name' => 'idx_detail_pjm'],
            ['table' => 'detail_peminjaman', 'name' => 'idx_detail_buku'],
            ['table' => 'buku', 'name' => 'idx_buku_deleted'],
            ['table' => 'buku', 'name' => 'idx_buku_kategori'],
            ['table' => 'buku', 'name' => 'idx_buku_stok'],
            ['table' => 'buku', 'name' => 'idx_buku_judul'],
            ['table' => 'anggota', 'name' => 'idx_anggota_user'],
            ['table' => 'anggota', 'name' => 'idx_anggota_deleted'],
            ['table' => 'review_buku', 'name' => 'idx_review_buku'],
            ['table' => 'review_buku', 'name' => 'idx_review_anggota'],
            ['table' => 'favorit_buku', 'name' => 'idx_favorit_anggota'],
            ['table' => 'favorit_buku', 'name' => 'idx_favorit_buku'],
            ['table' => 'wishlist_buku', 'name' => 'idx_wishlist_anggota'],
            ['table' => 'wishlist_buku', 'name' => 'idx_wishlist_status'],
            ['table' => 'antrian_buku', 'name' => 'idx_antrian_buku'],
            ['table' => 'antrian_buku', 'name' => 'idx_antrian_status'],
            ['table' => 'denda', 'name' => 'idx_denda_peminjaman'],
            ['table' => 'denda', 'name' => 'idx_denda_status'],
            ['table' => 'pengembalian', 'name' => 'idx_pengembalian_pjm'],
            ['table' => 'log_aktivitas', 'name' => 'idx_log_user'],
            ['table' => 'log_aktivitas', 'name' => 'idx_log_created'],
            ['table' => 'login_history', 'name' => 'idx_login_user'],
            ['table' => 'login_history', 'name' => 'idx_login_status'],
            ['table' => 'notifikasi', 'name' => 'idx_notif_user'],
            ['table' => 'notifikasi', 'name' => 'idx_notif_read'],
            ['table' => 'users', 'name' => 'idx_users_email'],
            ['table' => 'users', 'name' => 'idx_users_active'],
        ];

        foreach ($indexes as $idx) {
            try {
                $this->db->query("ALTER TABLE `{$idx['table']}` DROP INDEX `{$idx['name']}`");
            } catch (\Exception $e) {
                // Index mungkin tidak ada
            }
        }
    }
}
