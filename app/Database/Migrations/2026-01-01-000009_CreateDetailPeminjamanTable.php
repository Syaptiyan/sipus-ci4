<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailPeminjamanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_peminjaman' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_buku'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_buku', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('detail_peminjaman');
    }
}
