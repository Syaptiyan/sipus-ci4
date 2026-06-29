<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToTables extends Migration
{
    public function up()
    {
        $tables = ['notifikasi', 'log_aktivitas', 'detail_peminjaman'];
        foreach ($tables as $table) {
            if (!$this->db->fieldExists('deleted_at', $table)) {
                $this->forge->addColumn($table, [
                    'deleted_at' => ['type' => 'DATETIME', 'null' => true],
                ]);
            }
        }
    }

    public function down()
    {
        $tables = ['notifikasi', 'log_aktivitas', 'detail_peminjaman'];
        foreach ($tables as $table) {
            if ($this->db->fieldExists('deleted_at', $table)) {
                $this->forge->dropColumn($table, 'deleted_at');
            }
        }
    }
}
