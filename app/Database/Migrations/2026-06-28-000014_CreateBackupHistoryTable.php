<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBackupHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'ukuran'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('backup_history');
    }

    public function down()
    {
        $this->forge->dropTable('backup_history');
    }
}
