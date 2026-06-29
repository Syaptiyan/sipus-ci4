<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastActivityToUsers extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('last_activity', 'users')) {
            $this->forge->addColumn('users', [
                'last_activity' => ['type' => 'DATETIME', 'null' => true],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('last_activity', 'users')) {
            $this->forge->dropColumn('users', 'last_activity');
        }
    }
}
