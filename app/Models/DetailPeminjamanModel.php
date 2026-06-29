<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table          = 'detail_peminjaman';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps  = false;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = ['id_peminjaman', 'id_buku', 'created_at'];
}
