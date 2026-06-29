<?php

namespace App\Controllers;

class RakController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getVar('search');
        $builder = $this->db->table('rak');
        $builder->where('deleted_at', null);

        if ($search) {
            $builder->like('nama', $search);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title'  => 'Rak',
            'rak'    => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search' => $search,
        ];

        return $this->view('rak/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Rak'];
        return $this->view('rak/create', $data);
    }

    public function store()
    {
        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Nama rak harus diisi.');
        }

        try {
            $this->db->table('rak')->insert([
                'nama'       => $this->request->getVar('nama'),
                'lokasi'     => $this->request->getVar('lokasi'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Rak berhasil ditambahkan.');
        return redirect()->to('/rak');
    }

    public function show($id)
    {
        $rak = $this->db->table('rak')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$rak) {
            return redirect()->to('/rak')->with('error', 'Rak tidak ditemukan.');
        }
        $data = ['title' => 'Detail Rak', 'rak' => $rak];
        return $this->view('rak/show', $data);
    }

    public function edit($id)
    {
        $rak = $this->db->table('rak')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$rak) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Rak',
            'rak'   => $rak,
        ];

        return $this->view('rak/edit', $data);
    }

    public function update($id)
    {
        $rak = $this->db->table('rak')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$rak) {
            return redirect()->to('/rak')->with('error', 'Rak tidak ditemukan.');
        }

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        try {
            $this->db->table('rak')->where('id', $id)->update([
                'nama'       => $this->request->getVar('nama'),
                'lokasi'     => $this->request->getVar('lokasi'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Rak berhasil diubah.');
        return redirect()->to('/rak');
    }

    public function delete($id)
    {
        $this->db->table('rak')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Rak berhasil dihapus.');
        return redirect()->to('/rak');
    }

    public function restore($id)
    {
        $this->db->table('rak')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        $this->session->setFlashdata('success', 'Rak berhasil dipulihkan.');
        return redirect()->to('/rak');
    }
}
