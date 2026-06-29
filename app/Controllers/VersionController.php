<?php

namespace App\Controllers;

class VersionController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();
        $tipe = $this->request->getGet('tipe');

        $builder = $this->db->table('log_aktivitas')
            ->select('log_aktivitas.*, users.nama as nama_user')
            ->join('users', 'users.id = log_aktivitas.id_user', 'left')
            ->whereIn('log_aktivitas.tipe', ['buku', 'anggota', 'peminjaman', 'denda', 'user', 'setting'])
            ->orderBy('log_aktivitas.created_at', 'DESC');

        if ($tipe) {
            $builder->where('log_aktivitas.tipe', $tipe);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Riwayat Perubahan Data',
            'logs' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'tipe' => $tipe,
        ];
        return $this->view('version/index', $data);
    }
}
