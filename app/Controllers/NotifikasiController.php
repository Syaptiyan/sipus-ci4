<?php

namespace App\Controllers;

class NotifikasiController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $userId = session()->get('user')['id'];
        $builder = $this->db->table('notifikasi')
            ->groupStart()
                ->where('id_user', $userId)
                ->orWhere('id_user', null)
            ->groupEnd();

        $total = $builder->countAllResults(false);

        $data['title'] = 'Notifikasi';
        $data['notifikasi'] = $builder
            ->orderBy('created_at', 'DESC')
            ->get($perPage, ($page - 1) * $perPage)
            ->getResultArray();
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total);
        $data['currentPage'] = (int)$page;
        $data['perPage'] = $perPage;
        return $this->view('notifikasi/index', $data);
    }

    public function read($id)
    {
        $this->db->table('notifikasi')->where('id', $id)->update(['read' => 1]);
        return $this->response->setJSON(['success' => true]);
    }
}
