<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['kode_anggota' => 'AGT0001', 'nama' => 'Budi Santoso', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '2000-05-15', 'alamat' => 'Jl. Merdeka No. 1, Jakarta', 'telp' => '081234567890', 'email' => 'budi@email.com'],
            ['kode_anggota' => 'AGT0002', 'nama' => 'Siti Nurhaliza', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1999-08-20', 'alamat' => 'Jl. Diponegoro No. 23, Bandung', 'telp' => '081234567891', 'email' => 'siti@email.com'],
            ['kode_anggota' => 'AGT0003', 'nama' => 'Ahmad Rizki', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Surabaya', 'tanggal_lahir' => '2001-03-10', 'alamat' => 'Jl. Pahlawan No. 45, Surabaya', 'telp' => '081234567892', 'email' => 'ahmad@email.com'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('anggota')->insert($d);
        }
    }
}
