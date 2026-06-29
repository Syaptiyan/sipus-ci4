<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewBukuModel extends Model
{
    protected $table            = 'review_buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = ['id_buku', 'id_anggota', 'rating', 'review'];
}
