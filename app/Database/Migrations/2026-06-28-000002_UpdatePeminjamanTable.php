<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePeminjamanTable extends Migration
{
    public function up()
    {
        // 1. Ubah status ENUM ke VARCHAR
        $this->db->query("ALTER TABLE peminjaman MODIFY status VARCHAR(20) DEFAULT 'pending'");

        // 2. Tambah kolom baru
        $fields = [
            'tanggal_pengajuan'   => ['type' => 'DATE', 'null' => true],
            'tanggal_disetujui'   => ['type' => 'DATE', 'null' => true],
            'tanggal_dikembalikan' => ['type' => 'DATE', 'null' => true],
            'alasan_tolak'        => ['type' => 'TEXT', 'null' => true],
            'tanggal_perpanjangan' => ['type' => 'DATE', 'null' => true],
            'id_user_approve'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ];

        foreach ($fields as $name => $def) {
            if (!$this->db->fieldExists($name, 'peminjaman')) {
                $this->forge->addColumn('peminjaman', [$name => $def]);
            }
        }

        // 3. Update existing data
        $this->db->query("UPDATE peminjaman SET status = 'borrowed' WHERE status = 'Dipinjam'");
        $this->db->query("UPDATE peminjaman SET status = 'returned' WHERE status = 'Dikembalikan'");
        $this->db->query("UPDATE peminjaman SET status = 'late' WHERE status = 'Terlambat'");
        $this->db->query("UPDATE peminjaman SET tanggal_pengajuan = DATE(created_at) WHERE tanggal_pengajuan IS NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE peminjaman MODIFY status ENUM('Dipinjam','Dikembalikan','Terlambat') DEFAULT 'Dipinjam'");
    }
}
