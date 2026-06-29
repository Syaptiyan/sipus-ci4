<?php

namespace App\Controllers;

class KalenderController extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Kalender Peminjaman'];
        return $this->view('kalender/index', $data);
    }

    public function events()
    {
        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as nama_anggota, buku.judul as judul_buku')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->where('peminjaman.deleted_at', null)
            ->get()
            ->getResultArray();

        $events = [];
        foreach ($peminjaman as $p) {
            $color = match($p['status']) {
                'pending' => '#f59e0b',
                'approved' => '#3b82f6',
                'borrowed' => '#063a76',
                'returned' => '#10b981',
                'late' => '#ef4444',
                'rejected' => '#6b7280',
                default => '#6b7280',
            };

            $events[] = [
                'id' => $p['id'],
                'title' => $p['judul_buku'] . ' - ' . $p['nama_anggota'],
                'start' => $p['tanggal_pinjam'] ?? $p['tanggal_pengajuan'],
                'end' => $p['tanggal_jatuh_tempo'],
                'color' => $color,
                'url' => base_url('peminjaman/' . $p['id']),
            ];
        }

        return $this->response->setJSON($events);
    }
}
