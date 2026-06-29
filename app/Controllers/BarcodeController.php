<?php

namespace App\Controllers;

class BarcodeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Cetak Barcode',
            'buku' => $this->db->table('buku')
                ->select('buku.*, kategori.nama as nama_kategori')
                ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                ->where('buku.deleted_at', null)
                ->orderBy('buku.judul', 'ASC')
                ->get()
                ->getResultArray(),
        ];
        return $this->view('barcode/index', $data);
    }

    public function cetak()
    {
        $ids = $this->request->getPost('ids');
        if (empty($ids)) {
            return redirect()->to('/barcode')->with('error', 'Pilih buku yang ingin dicetak barcodenya.');
        }

        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama as nama_kategori')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->whereIn('buku.id', $ids)
            ->where('buku.deleted_at', null)
            ->orderBy('buku.judul', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Cetak Barcode',
            'buku' => $buku,
        ];
        return $this->view('barcode/cetak', $data);
    }
}
