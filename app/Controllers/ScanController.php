<?php

namespace App\Controllers;

class ScanController extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Scan QR Code'];
        return $this->view('scan/index', $data);
    }

    public function lookup()
    {
        $isbn = $this->request->getGet('isbn');
        if (!$isbn) {
            return $this->response->setJSON(['success' => false, 'message' => 'ISBN tidak ditemukan.']);
        }

        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama as nama_kategori')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->where('buku.isbn', $isbn)
            ->where('buku.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$buku) {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku dengan ISBN ' . esc($isbn) . ' tidak ditemukan.']);
        }

        return $this->response->setJSON([
            'success' => true,
            'buku' => [
                'id' => $buku['id'],
                'isbn' => $buku['isbn'],
                'judul' => $buku['judul'],
                'kategori' => $buku['nama_kategori'] ?? '-',
                'stok' => $buku['stok'],
                'stok_tersedia' => $buku['stok_tersedia'],
                'url' => base_url('buku/' . $buku['id']),
                'url_pinjam' => base_url('peminjaman/new?buku_id=' . $buku['id']),
            ],
        ]);
    }
}
