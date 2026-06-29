<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTwoFactorAndApiToken extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('two_factor_secret', 'users')) {
            $this->forge->addColumn('users', [
                'two_factor_secret' => ['type' => 'VARCHAR', 'constraint' => 32, 'null' => true],
            ]);
        }

        if (!$this->db->fieldExists('api_token', 'users')) {
            $this->forge->addColumn('users', [
                'api_token' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            ]);
        }

        // Insert default API token ke pengaturan
        $exists = $this->db->table('pengaturan')->where('key', 'api_token')->countAllResults();
        if ($exists === 0) {
            $this->db->table('pengaturan')->insert([
                'key' => 'api_token',
                'value' => bin2hex(random_bytes(32)),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('two_factor_secret', 'users')) {
            $this->forge->dropColumn('users', 'two_factor_secret');
        }
        if ($this->db->fieldExists('api_token', 'users')) {
            $this->forge->dropColumn('users', 'api_token');
        }
    }
}
