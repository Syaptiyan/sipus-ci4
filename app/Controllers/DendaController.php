<?php

namespace App\Controllers;

class DendaController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();
        $user = session()->get('user');

        $data['title'] = 'Data Denda';
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('denda')
            ->select('denda.*, peminjaman.kode_peminjaman, anggota.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('denda.deleted_at', null);

        // Anggota hanya lihat denda sendiri
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            $builder->where('peminjaman.id_anggota', $anggota->id ?? 0);
        }

        if ($search) {
            $builder->groupStart()
                ->like('peminjaman.kode_peminjaman', $search)
                ->orLike('anggota.nama', $search)
                ->groupEnd();
        }
        if ($status) {
            $builder->where('denda.status', $status);
        }

        $total = $builder->countAllResults(false);

        $data['denda'] = $builder
            ->orderBy('denda.created_at', 'DESC')
            ->get($perPage, ($page - 1) * $perPage)
            ->getResultArray();
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total);
        $data['currentPage'] = (int)$page;
        $data['perPage'] = $perPage;
        $data['status'] = $status;
        $data['search'] = $search;
        return $this->view('denda/index', $data);
    }

    public function show($id)
    {
        $user = session()->get('user');

        $denda = $this->db->table('denda')
            ->select('denda.*, peminjaman.kode_peminjaman, anggota.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('denda.id', $id)
            ->where('denda.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$denda) {
            return redirect()->to('/denda')->with('error', 'Denda tidak ditemukan.');
        }

        // Anggota hanya bisa lihat denda sendiri
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            if (!$anggota || $denda['id_anggota'] != $anggota->id) {
                return redirect()->to('/denda')->with('error', 'Anda tidak memiliki akses.');
            }
        }

        $data = ['title' => 'Detail Denda', 'denda' => $denda];
        return $this->view('denda/show', $data);
    }

    public function bayar($id)
    {
        $this->db->table('denda')->where('id', $id)->update([
            'status'       => 'Lunas',
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Pembayaran denda', 'denda', "ID: $id");
        $this->createNotifikasi(null, 'Pembayaran Denda', "Pembayaran denda ID {$id} telah dikonfirmasi.", 'success');
        return redirect()->to('/denda/' . $id . '/kwitansi')->with('success', 'Pembayaran denda berhasil.');
    }

    public function kwitansi($id)
    {
        $denda = $this->db->table('denda')
            ->select('denda.*, peminjaman.kode_peminjaman, peminjaman.tanggal_pinjam, peminjaman.tanggal_jatuh_tempo, anggota.nama as nama_anggota, anggota.kode_anggota, anggota.telp as telp_anggota, anggota.email as email_anggota')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('denda.id', $id)
            ->where('denda.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$denda) {
            return redirect()->to('/denda')->with('error', 'Data denda tidak ditemukan.');
        }

        if ($denda['status'] !== 'Lunas') {
            return redirect()->to('/denda/' . $id)->with('error', 'Kwitansi hanya bisa dicetak untuk pembayaran yang sudah lunas.');
        }

        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $pengaturan = [];
        foreach ($settings as $s) {
            $pengaturan[$s['key']] = $s['value'];
        }

        $data = [
            'title' => 'Kwitansi Pembayaran Denda',
            'denda' => $denda,
            'pengaturan' => $pengaturan,
            'user' => session()->get('user'),
        ];

        return $this->view('denda/kwitansi', $data);
    }

    public function delete($id)
    {
        $this->db->table('denda')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/denda')->with('success', 'Data denda berhasil dihapus.');
    }
}
