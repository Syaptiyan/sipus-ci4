<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'username'   => 'admin',
            'email'      => 'admin@sipus.com',
            'password'   => password_hash('password123', PASSWORD_DEFAULT),
            'nama'       => 'Dr. Ahmad Hidayat, S.IP',
            'nip'        => '198501012010011001',
            'role'       => 'Admin',
            'active'     => 1,
            'created_at' => $now,
        ]);

        $this->db->table('users')->insert([
            'username'   => 'petugas',
            'email'      => 'petugas@sipus.com',
            'password'   => password_hash('password123', PASSWORD_DEFAULT),
            'nama'       => 'Siti Rahmawati, A.Md',
            'nip'        => '199002152012012001',
            'role'       => 'Petugas',
            'active'     => 1,
            'created_at' => $now,
        ]);

        $this->db->table('users')->insert([
            'username'   => 'anggota',
            'email'      => 'anggota@sipus.com',
            'password'   => password_hash('password123', PASSWORD_DEFAULT),
            'nama'       => 'Budi Santoso',
            'role'       => 'Anggota',
            'active'     => 1,
            'created_at' => $now,
        ]);
    }
}
