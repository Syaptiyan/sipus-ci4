<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMasaAktifToAnggota extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('tanggal_aktif', 'anggota')) {
            $this->forge->addColumn('anggota', [
                'tanggal_aktif' => ['type' => 'DATE', 'null' => true],
            ]);
        }

        if (!$this->db->fieldExists('tanggal_expired', 'anggota')) {
            $this->forge->addColumn('anggota', [
                'tanggal_expired' => ['type' => 'DATE', 'null' => true],
            ]);
        }

        // Set default untuk anggota yang sudah ada
        $this->db->query("UPDATE anggota SET tanggal_aktif = CURDATE(), tanggal_expired = DATE_ADD(CURDATE(), INTERVAL 6 MONTH) WHERE tanggal_aktif IS NULL");
    }

    public function down()
    {
        if ($this->db->fieldExists('tanggal_aktif', 'anggota')) {
            $this->forge->dropColumn('anggota', 'tanggal_aktif');
        }
        if ($this->db->fieldExists('tanggal_expired', 'anggota')) {
            $this->forge->dropColumn('anggota', 'tanggal_expired');
        }
    }
}
