<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenerbitSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama' => 'Gramedia Pustaka Utama', 'slug' => 'gramedia-pustaka-utama', 'alamat' => 'Jakarta', 'telp' => '021-5365011'],
            ['nama' => 'Bentang Pustaka', 'slug' => 'bentang-pustaka', 'alamat' => 'Yogyakarta', 'telp' => '0274-123456'],
            ['nama' => 'Elex Media Komputindo', 'slug' => 'elex-media-komputindo', 'alamat' => 'Jakarta', 'telp' => '021-1234567'],
            ['nama' => 'Mizan Pustaka', 'slug' => 'mizan-pustaka', 'alamat' => 'Bandung', 'telp' => '022-7654321'],
            ['nama' => 'Republika Penerbit', 'slug' => 'republika-penerbit', 'alamat' => 'Jakarta', 'telp' => '021-9876543'],
            ['nama' => 'Penerbit Buku Kompas', 'slug' => 'penerbit-buku-kompas', 'alamat' => 'Jakarta', 'telp' => '021-2345678'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('penerbit')->insert($d);
        }
    }
}
