<?php

namespace App\Controllers;

class LabelController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Label Rak Buku',
            'rak' => $this->db->table('rak')
                ->select('rak.*, COUNT(buku.id) as jumlah_buku')
                ->join('buku', 'buku.id_rak = rak.id AND buku.deleted_at IS NULL', 'left')
                ->where('rak.deleted_at', null)
                ->groupBy('rak.id')
                ->orderBy('rak.nama', 'ASC')
                ->get()
                ->getResultArray(),
        ];
        return $this->view('label/index', $data);
    }

    public function cetak()
    {
        $ids = $this->request->getPost('ids');
        if (empty($ids)) {
            return redirect()->to('/label')->with('error', 'Pilih rak yang ingin dicetak labelnya.');
        }

        $rak = $this->db->table('rak')
            ->select('rak.*, COUNT(buku.id) as jumlah_buku')
            ->join('buku', 'buku.id_rak = rak.id AND buku.deleted_at IS NULL', 'left')
            ->whereIn('rak.id', $ids)
            ->where('rak.deleted_at', null)
            ->groupBy('rak.id')
            ->orderBy('rak.nama', 'ASC')
            ->get()
            ->getResultArray();

        $data = ['title' => 'Cetak Label Rak', 'rak' => $rak];
        return $this->view('label/cetak', $data);
    }
}
