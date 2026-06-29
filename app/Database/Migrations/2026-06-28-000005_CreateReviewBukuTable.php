<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_buku'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_anggota'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rating'        => ['type' => 'TINYINT', 'constraint' => 1],
            'review'        => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_buku', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('review_buku');
    }

    public function down()
    {
        $this->forge->dropTable('review_buku');
    }
}
