<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenulisSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama' => 'Andrea Hirata', 'slug' => 'andrea-hirata', 'bio' => 'Penulis novel Laskar Pelangi'],
            ['nama' => 'Pramoedya Ananta Toer', 'slug' => 'pramoedya-ananta-toer', 'bio' => 'Sastrawan Indonesia ternama'],
            ['nama' => 'Tere Liye', 'slug' => 'tere-liye', 'bio' => 'Penulis novel Indonesia'],
            ['nama' => 'Dee Lestari', 'slug' => 'dee-lestari', 'bio' => 'Penulis dan musisi Indonesia'],
            ['nama' => 'Raditya Dika', 'slug' => 'raditya-dika', 'bio' => 'Penulis dan komedian'],
            ['nama' => 'J.K. Rowling', 'slug' => 'jk-rowling', 'bio' => 'Penulis seri Harry Potter'],
            ['nama' => 'George Orwell', 'slug' => 'george-orwell', 'bio' => 'Penulis 1984 dan Animal Farm'],
            ['nama' => 'Haruki Murakami', 'slug' => 'haruki-murakami', 'bio' => 'Penulis Jepang ternama'],
            ['nama' => 'Yuval Noah Harari', 'slug' => 'yuval-noah-harari', 'bio' => 'Penulis Sapiens'],
            ['nama' => 'Robert T. Kiyosaki', 'slug' => 'robert-t-kiyosaki', 'bio' => 'Penulis Rich Dad Poor Dad'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('penulis')->insert($d);
        }
    }
}
