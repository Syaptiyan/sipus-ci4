<?php

namespace App\Controllers;

class AuditController extends BaseController
{
    public function loginHistory()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('login_history')
            ->select('login_history.*, users.nama, users.username, users.role')
            ->join('users', 'users.id = login_history.id_user')
            ->orderBy('login_history.created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                ->like('users.nama', $search)
                ->orLike('users.username', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('login_history.status', $status);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Riwayat Login',
            'history' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search' => $search,
            'status' => $status,
        ];

        return $this->view('audit/login_history', $data);
    }

    public function statistikUser()
    {
        $data = [
            'title' => 'Statistik Aktivitas Pengguna',
            'top_users' => $this->db->table('log_aktivitas')
                ->select('users.nama, users.role, COUNT(*) as total')
                ->join('users', 'users.id = log_aktivitas.id_user')
                ->groupBy('log_aktivitas.id_user')
                ->orderBy('total', 'DESC')
                ->limit(10)
                ->get()
                ->getResultArray(),
            'total_aktivitas' => $this->db->table('log_aktivitas')->countAllResults(),
            'total_login_hari_ini' => $this->db->table('login_history')
                ->where('DATE(created_at)', date('Y-m-d'))
                ->where('status', 'success')
                ->countAllResults(),
            'total_login_gagal_hari_ini' => $this->db->table('login_history')
                ->where('DATE(created_at)', date('Y-m-d'))
                ->where('status', 'failed')
                ->countAllResults(),
        ];

        return $this->view('audit/statistik', $data);
    }
}
