<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFavoritBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_anggota'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_buku'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['id_anggota', 'id_buku']);
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_buku', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favorit_buku');
    }

    public function down()
    {
        $this->forge->dropTable('favorit_buku');
    }
}
