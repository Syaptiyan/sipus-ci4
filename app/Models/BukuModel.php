<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table          = 'buku';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';
    protected $allowedFields  = ['isbn', 'judul', 'slug', 'id_kategori', 'id_penulis', 'id_penerbit', 'id_rak', 'tahun_terbit', 'jumlah_halaman', 'deskripsi', 'cover', 'stok', 'stok_tersedia', 'bahasa', 'edisi'];
}
