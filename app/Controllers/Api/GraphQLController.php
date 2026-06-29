<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class GraphQLController extends ResourceController
{
    protected $db;
    protected $format = 'json';

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $input = $this->request->getJSON(true);
        $query = $input['query'] ?? '';

        if (stripos($query, 'buku') !== false) {
            return $this->queryBuku($input);
        }

        if (stripos($query, 'peminjaman') !== false) {
            return $this->queryPeminjaman($input);
        }

        return $this->respond(['errors' => [['message' => 'Query tidak dikenali.']]], 400);
    }

    private function queryBuku($input)
    {
        $id = $input['variables']['id'] ?? null;

        if ($id) {
            $buku = $this->db->table('buku')
                ->select('buku.*, kategori.nama as kategori, penulis.nama as penulis')
                ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                ->where('buku.id', $id)
                ->where('buku.deleted_at', null)
                ->get()
                ->getRowArray();

            return $this->respond(['data' => ['buku' => $buku]]);
        }

        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama as kategori, penulis.nama as penulis')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->where('buku.deleted_at', null)
            ->orderBy('buku.judul', 'ASC')
            ->get()
            ->getResultArray();

        return $this->respond(['data' => ['buku' => $buku]]);
    }

    private function queryPeminjaman($input)
    {
        $status = $input['variables']['status'] ?? null;

        $builder = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as anggota')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('peminjaman.deleted_at', null);

        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        $data = $builder->orderBy('peminjaman.created_at', 'DESC')->limit(50)->get()->getResultArray();

        return $this->respond(['data' => ['peminjaman' => $data]]);
    }
}
