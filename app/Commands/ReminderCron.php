<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ReminderCron extends BaseCommand
{
    protected $group       = 'SIPUS';
    protected $name        = 'reminder:check';
    protected $description = 'Cek pengingat peminjaman (H-3, terlambat, wishlist tersedia)';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        CLI::write('=== SIPUS Reminder Check ===', 'yellow');
        CLI::write('Tanggal: ' . $today, 'white');

        // 1. H-3 sebelum jatuh tempo
        $h3 = date('Y-m-d', strtotime('+3 days'));
        $upcoming = $db->table('peminjaman')
            ->select('peminjaman.*, anggota.id_user as id_user_anggota, buku.judul as judul_buku')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->where('peminjaman.status', 'borrowed')
            ->where('peminjaman.tanggal_jatuh_tempo', $h3)
            ->where('peminjaman.deleted_at', null)
            ->get()
            ->getResultArray();

        $count = 0;
        foreach ($upcoming as $p) {
            $exists = $db->table('notifikasi')
                ->where('id_user', $p['id_user_anggota'])
                ->like('judul', 'Jatuh Tempo')
                ->like('pesan', $p['kode_peminjaman'])
                ->where('DATE(created_at)', $today)
                ->countAllResults();

            if ($exists === 0) {
                $db->table('notifikasi')->insert([
                    'id_user'    => $p['id_user_anggota'],
                    'judul'      => 'Pengingat Jatuh Tempo',
                    'pesan'      => "Peminjaman {$p['kode_peminjaman']} ({$p['judul_buku']}) akan jatuh tempo pada {$p['tanggal_jatuh_tempo']}. Segera kembalikan atau perpanjang.",
                    'type'       => 'warning',
                    'read'       => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $count++;
            }
        }
        CLI::write("H-3 Jatuh Tempo: $count notifikasi", 'green');

        // 2. Terlambat
        $late = $db->table('peminjaman')
            ->select('peminjaman.*, anggota.id_user as id_user_anggota')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('peminjaman.status', 'borrowed')
            ->where('peminjaman.tanggal_jatuh_tempo <', $today)
            ->where('peminjaman.deleted_at', null)
            ->get()
            ->getResultArray();

        $lateCount = 0;
        foreach ($late as $p) {
            $db->table('peminjaman')->where('id', $p['id'])->update([
                'status' => 'late',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $exists = $db->table('notifikasi')
                ->where('id_user', $p['id_user_anggota'])
                ->like('judul', 'Terlambat')
                ->like('pesan', $p['kode_peminjaman'])
                ->where('DATE(created_at)', $today)
                ->countAllResults();

            if ($exists === 0) {
                $db->table('notifikasi')->insert([
                    'id_user'    => $p['id_user_anggota'],
                    'judul'      => 'Peminjaman Terlambat',
                    'pesan'      => "Peminjaman {$p['kode_peminjaman']} sudah melewati jatuh tempo ({$p['tanggal_jatuh_tempo']}). Segera kembalikan untuk menghindari denda.",
                    'type'       => 'error',
                    'read'       => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $lateCount++;
            }
        }
        CLI::write("Terlambat: $lateCount notifikasi", 'red');

        // 3. Wishlist tersedia
        $wishlists = $db->table('wishlist_buku')
            ->select('wishlist_buku.*, anggota.id_user as id_user_anggota')
            ->join('anggota', 'anggota.id = wishlist_buku.id_anggota')
            ->where('wishlist_buku.status', 'approved')
            ->where('wishlist_buku.deleted_at', null)
            ->get()
            ->getResultArray();

        $wishCount = 0;
        foreach ($wishlists as $w) {
            $buku = $db->table('buku')
                ->where('judul', $w['judul_buku'])
                ->where('stok_tersedia >', 0)
                ->where('deleted_at', null)
                ->get()
                ->getRow();

            if ($buku) {
                $exists = $db->table('notifikasi')
                    ->where('id_user', $w['id_user_anggota'])
                    ->like('judul', 'Wishlist')
                    ->like('pesan', $w['judul_buku'])
                    ->where('DATE(created_at)', $today)
                    ->countAllResults();

                if ($exists === 0) {
                    $db->table('notifikasi')->insert([
                        'id_user'    => $w['id_user_anggota'],
                        'judul'      => 'Buku Wishlist Tersedia',
                        'pesan'      => "Buku \"{$w['judul_buku']}\" yang Anda request sudah tersedia di perpustakaan!",
                        'type'       => 'success',
                        'read'       => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $wishCount++;
                }
            }
        }
        CLI::write("Wishlist Tersedia: $wishCount notifikasi", 'green');

        // 4. Denda belum dibayar
        $denda = $db->table('denda')
            ->select('denda.*, peminjaman.kode_peminjaman, peminjaman.id_user as id_user_peminjaman')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->where('denda.status', 'Belum Dibayar')
            ->where('denda.deleted_at', null)
            ->get()
            ->getResultArray();

        $dendaCount = 0;
        foreach ($denda as $d) {
            $anggota = $db->table('anggota')
                ->select('anggota.id_user')
                ->join('peminjaman', 'peminjaman.id_anggota = anggota.id')
                ->where('peminjaman.id', $d['id_peminjaman'])
                ->get()
                ->getRow();

            if ($anggota && $anggota->id_user) {
                $exists = $db->table('notifikasi')
                    ->where('id_user', $anggota->id_user)
                    ->like('judul', 'Denda')
                    ->like('pesan', $d['kode_peminjaman'])
                    ->where('DATE(created_at)', $today)
                    ->countAllResults();

                if ($exists === 0) {
                    $db->table('notifikasi')->insert([
                        'id_user'    => $anggota->id_user,
                        'judul'      => 'Denda Belum Dibayar',
                        'pesan'      => "Anda memiliki denda sebesar Rp " . number_format($d['jumlah'], 0, ',', '.') . " untuk peminjaman {$d['kode_peminjaman']}. Segera lakukan pembayaran.",
                        'type'       => 'warning',
                        'read'       => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $dendaCount++;
                }
            }
        }
        CLI::write("Denda Belum Dibayar: $dendaCount notifikasi", 'yellow');

        CLI::write('=== Selesai ===', 'yellow');
    }
}
