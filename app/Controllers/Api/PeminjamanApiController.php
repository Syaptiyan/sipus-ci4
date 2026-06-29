<?php

namespace App\Controllers\Api;

class PeminjamanApiController extends ApiBaseController
{
    public function index()
    {
        $unauthorized = $this->validateToken();
        if ($unauthorized) return $unauthorized;

        $status = $this->request->getGet('status');

        $builder = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as anggota')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('peminjaman.deleted_at', null);

        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        $builder->orderBy('peminjaman.created_at', 'DESC');
        $result = $this->paginate($builder);
        return $this->respond($result);
    }

    public function show($id)
    {
        $unauthorized = $this->validateToken();
        if ($unauthorized) return $unauthorized;

        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as anggota')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('peminjaman.id', $id)
            ->where('peminjaman.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$peminjaman) {
            return $this->respond(['error' => 'Peminjaman tidak ditemukan.'], 404);
        }

        $detail = $this->db->table('detail_peminjaman')
            ->select('buku.judul, buku.isbn')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $id)
            ->get()
            ->getResultArray();

        $peminjaman['buku'] = $detail;
        return $this->respond(['data' => $peminjaman]);
    }
}
