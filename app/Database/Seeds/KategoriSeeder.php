<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama' => 'Fiksi', 'slug' => 'fiksi', 'deskripsi' => 'Karya sastra fiksi'],
            ['nama' => 'Non-Fiksi', 'slug' => 'non-fiksi', 'deskripsi' => 'Karya sastra non-fiksi'],
            ['nama' => 'Sains', 'slug' => 'sains', 'deskripsi' => 'Buku ilmiah dan sains'],
            ['nama' => 'Teknologi', 'slug' => 'teknologi', 'deskripsi' => 'Buku tentang teknologi'],
            ['nama' => 'Sejarah', 'slug' => 'sejarah', 'deskripsi' => 'Buku sejarah'],
            ['nama' => 'Agama', 'slug' => 'agama', 'deskripsi' => 'Buku keagamaan'],
            ['nama' => 'Pendidikan', 'slug' => 'pendidikan', 'deskripsi' => 'Buku pendidikan'],
            ['nama' => 'Ekonomi', 'slug' => 'ekonomi', 'deskripsi' => 'Buku ekonomi dan bisnis'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('kategori')->insert($d);
        }
    }
}
