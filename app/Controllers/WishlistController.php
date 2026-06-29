<?php

namespace App\Controllers;

class WishlistController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $builder = $this->db->table('wishlist_buku')
            ->select('wishlist_buku.*, anggota.nama as nama_anggota')
            ->join('anggota', 'anggota.id = wishlist_buku.id_anggota')
            ->where('wishlist_buku.deleted_at', null);

        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            $builder->where('wishlist_buku.id_anggota', $anggota->id ?? 0);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Wishlist Buku',
            'wishlist' => $builder
                ->orderBy('wishlist_buku.created_at', 'DESC')
                ->get($perPage, ($page - 1) * $perPage)
                ->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
        ];

        return $this->view('wishlist/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Request Buku Baru'];
        return $this->view('wishlist/create', $data);
    }

    public function store()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        if (!$anggota) {
            return redirect()->to('/wishlist')->with('error', 'Data anggota tidak ditemukan.');
        }

        $judul = $this->request->getPost('judul_buku');
        if (!$judul) {
            return redirect()->back()->with('error', 'Judul buku wajib diisi.');
        }

        $this->db->table('wishlist_buku')->insert([
            'id_anggota'  => $anggota->id,
            'judul_buku'  => $judul,
            'pengarang'   => $this->request->getPost('pengarang'),
            'penerbit'    => $this->request->getPost('penerbit'),
            'alasan'      => $this->request->getPost('alasan'),
            'status'      => 'pending',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Request buku', 'wishlist', "Judul: $judul");
        return redirect()->to('/wishlist')->with('success', 'Request buku berhasil dikirim.');
    }

    public function proses($id)
    {
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan_admin');

        $wishlist = $this->db->table('wishlist_buku')->where('id', $id)->where('deleted_at', null)->get()->getRow();
        if (!$wishlist) {
            return redirect()->to('/wishlist')->with('error', 'Data tidak ditemukan.');
        }

        $this->db->table('wishlist_buku')->where('id', $id)->update([
            'status'        => $status,
            'catatan_admin' => $catatan,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Proses wishlist', 'wishlist', "ID: $id, Status: $status");
        $this->createNotifikasi($wishlist->id_anggota, 'Update Wishlist Buku',
            "Request buku \"{$wishlist->judul_buku}\" telah " . ($status === 'approved' ? 'disetujui' : 'ditolak') . ".",
            $status === 'approved' ? 'success' : 'error');

        return redirect()->to('/wishlist')->with('success', 'Wishlist berhasil diproses.');
    }
}
