<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'isbn'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'id_kategori'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_penulis'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_penerbit'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_rak'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tahun_terbit'    => ['type' => 'YEAR', 'constraint' => 4, 'null' => true],
            'jumlah_halaman'  => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'deskripsi'       => ['type' => 'TEXT', 'null' => true],
            'cover'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'stok'            => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'stok_tersedia'   => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_penulis', 'penulis', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_penerbit', 'penerbit', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_rak', 'rak', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}
