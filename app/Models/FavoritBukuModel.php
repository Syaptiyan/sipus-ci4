<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritBukuModel extends Model
{
    protected $table            = 'favorit_buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = false;
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = ['id_anggota', 'id_buku', 'created_at'];
}
