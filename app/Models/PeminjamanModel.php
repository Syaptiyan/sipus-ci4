<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjaman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected $allowedFields    = [
        'kode_peminjaman', 'id_anggota', 'id_user', 'id_user_approve',
        'tanggal_pengajuan', 'tanggal_pinjam', 'tanggal_jatuh_tempo',
        'tanggal_disetujui', 'tanggal_dikembalikan', 'tanggal_perpanjangan',
        'status', 'alasan_tolak', 'catatan'
    ];

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_BORROWED = 'borrowed';
    public const STATUS_RETURNED = 'returned';
    public const STATUS_LATE     = 'late';
    public const STATUS_LOST     = 'lost';
    public const STATUS_DAMAGED  = 'damaged';
}
