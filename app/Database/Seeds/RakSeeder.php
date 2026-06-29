<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama' => 'Rak A - Fiksi', 'lokasi' => 'Lantai 1, Barat'],
            ['nama' => 'Rak B - Non-Fiksi', 'lokasi' => 'Lantai 1, Timur'],
            ['nama' => 'Rak C - Sains & Teknologi', 'lokasi' => 'Lantai 2, Barat'],
            ['nama' => 'Rak D - Sejarah & Agama', 'lokasi' => 'Lantai 2, Timur'],
            ['nama' => 'Rak E - Pendidikan', 'lokasi' => 'Lantai 3, Barat'],
            ['nama' => 'Rak F - Referensi', 'lokasi' => 'Lantai 3, Timur'],
        ];
        foreach ($data as $d) {
            $d['created_at'] = $now;
            $this->db->table('rak')->insert($d);
        }
    }
}
