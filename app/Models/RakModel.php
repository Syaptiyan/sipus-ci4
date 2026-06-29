<?php

namespace App\Models;

use CodeIgniter\Model;

class RakModel extends Model
{
    protected $table          = 'rak';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = ['nama', 'lokasi'];
}
