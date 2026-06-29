<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDendaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pengembalian' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_peminjaman'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah'         => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['Belum Dibayar', 'Lunas'], 'default' => 'Belum Dibayar'],
            'tanggal_bayar'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pengembalian', 'pengembalian', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('denda');
    }

    public function down()
    {
        $this->forge->dropTable('denda');
    }
}
