<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjamanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_peminjaman'   => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'id_anggota'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_user'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_pinjam'    => ['type' => 'DATE'],
            'tanggal_jatuh_tempo' => ['type' => 'DATE'],
            'status'            => ['type' => 'ENUM', 'constraint' => ['Dipinjam', 'Dikembalikan', 'Terlambat'], 'default' => 'Dipinjam'],
            'catatan'           => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}
