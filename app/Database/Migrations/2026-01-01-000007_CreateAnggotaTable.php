<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggotaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_anggota'   => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 150],
            'jenis_kelamin'  => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'default' => 'L'],
            'tempat_lahir'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tanggal_lahir'  => ['type' => 'DATE', 'null' => true],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'telp'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('anggota');
    }

    public function down()
    {
        $this->forge->dropTable('anggota');
    }
}
