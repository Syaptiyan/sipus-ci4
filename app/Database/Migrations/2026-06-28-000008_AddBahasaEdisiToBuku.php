<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBahasaEdisiToBuku extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('bahasa', 'buku')) {
            $this->forge->addColumn('buku', [
                'bahasa' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true, 'default' => 'Indonesia'],
            ]);
        }

        if (!$this->db->fieldExists('edisi', 'buku')) {
            $this->forge->addColumn('buku', [
                'edisi' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('bahasa', 'buku')) {
            $this->forge->dropColumn('buku', 'bahasa');
        }
        if ($this->db->fieldExists('edisi', 'buku')) {
            $this->forge->dropColumn('buku', 'edisi');
        }
    }
}
