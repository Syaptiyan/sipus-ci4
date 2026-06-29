<?php

namespace App\Controllers;

class FavoritController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        $data = ['title' => 'Buku Favorit'];

        if ($anggota) {
            $data['favorit'] = $this->db->table('favorit_buku')
                ->select('favorit_buku.*, buku.judul, buku.isbn, buku.stok_tersedia, kategori.nama as nama_kategori, penulis.nama as nama_penulis')
                ->join('buku', 'buku.id = favorit_buku.id_buku')
                ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                ->where('favorit_buku.id_anggota', $anggota->id)
                ->where('favorit_buku.deleted_at', null)
                ->where('buku.deleted_at', null)
                ->orderBy('favorit_buku.created_at', 'DESC')
                ->get()
                ->getResultArray();
        } else {
            $data['favorit'] = [];
        }

        return $this->view('favorit/index', $data);
    }

    public function toggle($id_buku)
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $existing = $this->db->table('favorit_buku')
            ->where('id_anggota', $anggota->id)
            ->where('id_buku', $id_buku)
            ->get()
            ->getRow();

        if ($existing) {
            if ($existing->deleted_at) {
                $this->db->table('favorit_buku')->where('id', $existing->id)->update([
                    'deleted_at' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                return redirect()->back()->with('success', 'Buku ditambahkan ke favorit.');
            } else {
                $this->db->table('favorit_buku')->where('id', $existing->id)->update([
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
                return redirect()->back()->with('success', 'Buku dihapus dari favorit.');
            }
        }

        $this->db->table('favorit_buku')->insert([
            'id_anggota' => $anggota->id,
            'id_buku'    => $id_buku,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Buku ditambahkan ke favorit.');
    }

    public function isFavorited($id_anggota, $id_buku)
    {
        return $this->db->table('favorit_buku')
            ->where('id_anggota', $id_anggota)
            ->where('id_buku', $id_buku)
            ->where('deleted_at', null)
            ->countAllResults() > 0;
    }
}
