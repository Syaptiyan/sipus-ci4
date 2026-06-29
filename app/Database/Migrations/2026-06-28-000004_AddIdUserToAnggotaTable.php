<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdUserToAnggotaTable extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('id_user', 'anggota')) {
            $this->forge->addColumn('anggota', [
                'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('id_user', 'anggota')) {
            $this->forge->dropColumn('anggota', 'id_user');
        }
    }
}
