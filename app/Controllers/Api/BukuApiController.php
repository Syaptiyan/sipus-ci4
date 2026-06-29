<?php

namespace App\Controllers\Api;

class BukuApiController extends ApiBaseController
{
    public function index()
    {
        $unauthorized = $this->validateToken();
        if ($unauthorized) return $unauthorized;

        $search = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->db->table('buku')
            ->select('buku.*, kategori.nama as kategori, penulis.nama as penulis, penerbit.nama as penerbit')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
            ->where('buku.deleted_at', null);

        if ($search) {
            $builder->groupStart()->like('buku.judul', $search)->orLike('buku.isbn', $search)->groupEnd();
        }
        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        $builder->orderBy('buku.created_at', 'DESC');
        $result = $this->paginate($builder);
        return $this->respond($result);
    }

    public function show($id)
    {
        $unauthorized = $this->validateToken();
        if ($unauthorized) return $unauthorized;

        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama as kategori, penulis.nama as penulis, penerbit.nama as penerbit, rak.nama as rak')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
            ->join('rak', 'rak.id = buku.id_rak', 'left')
            ->where('buku.id', $id)
            ->where('buku.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$buku) {
            return $this->respond(['error' => 'Buku tidak ditemukan.'], 404);
        }

        return $this->respond(['data' => $buku]);
    }
}
