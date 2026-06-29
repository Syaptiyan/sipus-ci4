<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['key' => 'nama_perpustakaan', 'value' => 'SIPUS - Sistem Informasi Perpustakaan'],
            ['key' => 'alamat_perpustakaan', 'value' => 'Jl. Merdeka No. 1, Jakarta'],
            ['key' => 'telp_perpustakaan', 'value' => '021-1234567'],
            ['key' => 'email_perpustakaan', 'value' => 'info@sipus.com'],
            ['key' => 'denda_per_hari', 'value' => '1000'],
            ['key' => 'masa_pinjam', 'value' => '7'],
            ['key' => 'maks_pinjam', 'value' => '3'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('pengaturan')->insert($d);
        }
    }
}
