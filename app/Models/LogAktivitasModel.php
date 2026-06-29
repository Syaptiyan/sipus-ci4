<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table          = 'log_aktivitas';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps  = false;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = ['id_user', 'aktivitas', 'tipe', 'keterangan', 'ip_address', 'user_agent', 'created_at'];
}
