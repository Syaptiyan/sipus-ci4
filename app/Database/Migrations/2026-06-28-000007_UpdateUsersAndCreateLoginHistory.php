<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersAndCreateLoginHistory extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('reset_token', 'users')) {
            $this->forge->addColumn('users', [
                'reset_token' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            ]);
        }

        if (!$this->db->fieldExists('reset_token_expires', 'users')) {
            $this->forge->addColumn('users', [
                'reset_token_expires' => ['type' => 'DATETIME', 'null' => true],
            ]);
        }

        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ip_address'    => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'success'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('login_history');
    }

    public function down()
    {
        $this->forge->dropTable('login_history');
    }
}
