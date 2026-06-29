<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistBukuModel extends Model
{
    protected $table            = 'wishlist_buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = ['id_anggota', 'judul_buku', 'pengarang', 'penerbit', 'alasan', 'status', 'catatan_admin'];
}
