<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendPengaturanTable extends Migration
{
    public function up()
    {
        $newSettings = [
            ['key' => 'jam_buka', 'value' => '08:00', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'jam_tutup', 'value' => '16:00', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'hari_operasional', 'value' => 'Senin - Sabtu', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'nama_aplikasi', 'value' => 'SIPUS', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'tagline', 'value' => 'Sistem Informasi Perpustakaan', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'kontak_email', 'value' => 'info@perpus.go.id', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'kontak_telepon', 'value' => '(021) 1234-5678', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'kontak_alamat', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'maintenance_mode', 'value' => '0', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'maintenance_message', 'value' => 'Sistem sedang dalam pemeliharaan. Silakan coba lagi nanti.', 'created_at' => date('Y-m-d H:i:s')],
        ];

        foreach ($newSettings as $setting) {
            $exists = $this->db->table('pengaturan')->where('key', $setting['key'])->countAllResults();
            if ($exists === 0) {
                $this->db->table('pengaturan')->insert($setting);
            }
        }
    }

    public function down()
    {
        $keys = ['jam_buka', 'jam_tutup', 'hari_operasional', 'nama_aplikasi', 'tagline', 'kontak_email', 'kontak_telepon', 'kontak_alamat', 'maintenance_mode', 'maintenance_message'];
        $this->db->table('pengaturan')->whereIn('key', $keys)->delete();
    }
}
