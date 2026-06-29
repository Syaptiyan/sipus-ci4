<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('App\Database\Seeds\UserSeeder');
        $this->call('App\Database\Seeds\KategoriSeeder');
        $this->call('App\Database\Seeds\PenulisSeeder');
        $this->call('App\Database\Seeds\PenerbitSeeder');
        $this->call('App\Database\Seeds\RakSeeder');
        $this->call('App\Database\Seeds\BukuSeeder');
        $this->call('App\Database\Seeds\AnggotaSeeder');
        $this->call('App\Database\Seeds\PengaturanSeeder');
    }
}
