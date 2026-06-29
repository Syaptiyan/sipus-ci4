<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['isbn' => '9789793062792', 'judul' => 'Laskar Pelangi', 'slug' => 'laskar-pelangi', 'id_kategori' => 1, 'id_penulis' => 1, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 2005, 'jumlah_halaman' => 534, 'deskripsi' => 'Novel tentang perjuangan anak-anak Belitung', 'stok' => 10, 'stok_tersedia' => 10],
            ['isbn' => '9789792503346', 'judul' => 'Bumi Manusia', 'slug' => 'bumi-manusia', 'id_kategori' => 1, 'id_penulis' => 2, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 1980, 'jumlah_halaman' => 487, 'deskripsi' => 'Novel sejarah Indonesia', 'stok' => 8, 'stok_tersedia' => 8],
            ['isbn' => '9786020332943', 'judul' => 'Hujan', 'slug' => 'hujan', 'id_kategori' => 1, 'id_penulis' => 3, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 2016, 'jumlah_halaman' => 320, 'deskripsi' => 'Novel romantis karya Tere Liye', 'stok' => 7, 'stok_tersedia' => 7],
            ['isbn' => '9789791227789', 'judul' => 'Perahu Kertas', 'slug' => 'perahu-kertas', 'id_kategori' => 1, 'id_penulis' => 4, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 2009, 'jumlah_halaman' => 444, 'deskripsi' => 'Novel tentang mimpi dan cinta', 'stok' => 6, 'stok_tersedia' => 6],
            ['isbn' => '9789797804422', 'judul' => 'Kambing Jantan', 'slug' => 'kambing-jantan', 'id_kategori' => 1, 'id_penulis' => 5, 'id_penerbit' => 1, 'id_rak' => 1, 'tahun_terbit' => 2005, 'jumlah_halaman' => 190, 'deskripsi' => 'Kumpulan cerita lucu', 'stok' => 5, 'stok_tersedia' => 5],
            ['isbn' => '9780747532699', 'judul' => "Harry Potter and the Philosopher's Stone", 'slug' => 'harry-potter-and-the-philosophers-stone', 'id_kategori' => 1, 'id_penulis' => 6, 'id_penerbit' => 3, 'id_rak' => 1, 'tahun_terbit' => 1997, 'jumlah_halaman' => 223, 'deskripsi' => 'Petualangan Harry Potter pertama', 'stok' => 10, 'stok_tersedia' => 10],
            ['isbn' => '9780451524935', 'judul' => '1984', 'slug' => '1984', 'id_kategori' => 1, 'id_penulis' => 7, 'id_penerbit' => 3, 'id_rak' => 1, 'tahun_terbit' => 1949, 'jumlah_halaman' => 328, 'deskripsi' => 'Novel distopia klasik', 'stok' => 7, 'stok_tersedia' => 7],
            ['isbn' => '9786020652195', 'judul' => 'Sapiens', 'slug' => 'sapiens', 'id_kategori' => 3, 'id_penulis' => 9, 'id_penerbit' => 1, 'id_rak' => 3, 'tahun_terbit' => 2011, 'jumlah_halaman' => 464, 'deskripsi' => 'Sejarah singkat umat manusia', 'stok' => 9, 'stok_tersedia' => 9],
            ['isbn' => '9781612680194', 'judul' => 'Rich Dad Poor Dad', 'slug' => 'rich-dad-poor-dad', 'id_kategori' => 8, 'id_penulis' => 10, 'id_penerbit' => 5, 'id_rak' => 2, 'tahun_terbit' => 1997, 'jumlah_halaman' => 207, 'deskripsi' => 'Buku literasi keuangan', 'stok' => 8, 'stok_tersedia' => 8],
            ['isbn' => '9786022913656', 'judul' => 'Filosofi Teras', 'slug' => 'filosofi-teras', 'id_kategori' => 2, 'id_penulis' => 10, 'id_penerbit' => 1, 'id_rak' => 2, 'tahun_terbit' => 2018, 'jumlah_halaman' => 276, 'deskripsi' => 'Pengantar filsafat Stoa', 'stok' => 6, 'stok_tersedia' => 6],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('buku')->insert($d);
        }
    }
}
