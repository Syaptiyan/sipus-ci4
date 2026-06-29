<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFulltextIndexes extends Migration
{
    public function up()
    {
        try {
            $this->db->query("ALTER TABLE `buku` ADD FULLTEXT INDEX `ft_buku_judul` (`judul`)");
        } catch (\Exception $e) {}

        try {
            $this->db->query("ALTER TABLE `buku` ADD FULLTEXT INDEX `ft_buku_search` (`judul`, `isbn`)");
        } catch (\Exception $e) {}
    }

    public function down()
    {
        try {
            $this->db->query("ALTER TABLE `buku` DROP INDEX `ft_buku_judul`");
        } catch (\Exception $e) {}
        try {
            $this->db->query("ALTER TABLE `buku` DROP INDEX `ft_buku_search`");
        } catch (\Exception $e) {}
    }
}
