<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengembalianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_pengembalian' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'id_peminjaman'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_user'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_kembali' => ['type' => 'DATE'],
            'denda'           => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengembalian');
    }

    public function down()
    {
        $this->forge->dropTable('pengembalian');
    }
}
