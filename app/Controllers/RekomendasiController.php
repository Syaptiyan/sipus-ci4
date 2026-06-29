<?php

namespace App\Controllers;

class RekomendasiController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $data = ['title' => 'Rekomendasi Buku'];

        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            if ($anggota) {
                $topKategori = $this->db->table('detail_peminjaman')
                    ->select('buku.id_kategori, COUNT(*) as total')
                    ->join('buku', 'buku.id = detail_peminjaman.id_buku')
                    ->join('peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman')
                    ->where('peminjaman.id_anggota', $anggota->id)
                    ->where('peminjaman.deleted_at', null)
                    ->groupBy('buku.id_kategori')
                    ->orderBy('total', 'DESC')
                    ->limit(3)
                    ->get()
                    ->getResultArray();

                $kategoriIds = array_column($topKategori, 'id_kategori');
                $pinjamanBukuIds = $this->db->table('detail_peminjaman')
                    ->select('id_buku')
                    ->join('peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman')
                    ->where('peminjaman.id_anggota', $anggota->id)
                    ->where('peminjaman.deleted_at', null)
                    ->get()
                    ->getResultArray();
                $sudahDipinjam = array_column($pinjamanBukuIds, 'id_buku');

                if (!empty($kategoriIds)) {
                    $builder = $this->db->table('buku')
                        ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis')
                        ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                        ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                        ->whereIn('buku.id_kategori', $kategoriIds)
                        ->where('buku.deleted_at', null)
                        ->where('buku.stok_tersedia >', 0);

                    if (!empty($sudahDipinjam)) {
                        $builder->whereNotIn('buku.id', $sudahDipinjam);
                    }

                    $data['rekomendasi'] = $builder->orderBy('buku.created_at', 'DESC')->limit(8)->get()->getResultArray();
                } else {
                    $data['rekomendasi'] = $this->db->table('buku')
                        ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis')
                        ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                        ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                        ->where('buku.deleted_at', null)
                        ->where('buku.stok_tersedia >', 0)
                        ->orderBy('buku.created_at', 'DESC')
                        ->limit(8)
                        ->get()
                        ->getResultArray();
                }
            } else {
                $data['rekomendasi'] = [];
            }
        } else {
            $data['rekomendasi'] = $this->db->table('buku')
                ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis')
                ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                ->where('buku.deleted_at', null)
                ->where('buku.stok_tersedia >', 0)
                ->orderBy('buku.created_at', 'DESC')
                ->limit(8)
                ->get()
                ->getResultArray();
        }

        return $this->view('rekomendasi/index', $data);
    }
}
