<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table          = 'denda';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = ['id_pengembalian', 'id_peminjaman', 'jumlah', 'status', 'tanggal_bayar'];
}
