<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWishlistBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_anggota'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'judul_buku'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'pengarang'     => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'penerbit'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'alasan'        => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'catatan_admin' => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wishlist_buku');
    }

    public function down()
    {
        $this->forge->dropTable('wishlist_buku');
    }
}
