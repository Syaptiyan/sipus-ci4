<?php

namespace App\Controllers;

class PenulisController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getVar('search');
        $builder = $this->db->table('penulis');
        $builder->where('deleted_at', null);

        if ($search) {
            $builder->like('nama', $search);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title'   => 'Penulis',
            'penulis' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search'  => $search,
        ];

        return $this->view('penulis/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Penulis'];
        return $this->view('penulis/create', $data);
    }

    public function store()
    {
        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Nama penulis harus diisi.');
        }

        try {
            $this->db->table('penulis')->insert([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'bio'        => $this->request->getVar('bio'),
                'foto'       => $this->request->getVar('foto'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Penulis berhasil ditambahkan.');
        return redirect()->to('/penulis');
    }

    public function show($id)
    {
        $penulis = $this->db->table('penulis')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$penulis) {
            return redirect()->to('/penulis')->with('error', 'Penulis tidak ditemukan.');
        }
        $data = ['title' => 'Detail Penulis', 'penulis' => $penulis];
        return $this->view('penulis/show', $data);
    }

    public function edit($id)
    {
        $penulis = $this->db->table('penulis')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$penulis) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => 'Edit Penulis',
            'penulis' => $penulis,
        ];

        return $this->view('penulis/edit', $data);
    }

    public function update($id)
    {
        $penulis = $this->db->table('penulis')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$penulis) {
            return redirect()->to('/penulis')->with('error', 'Penulis tidak ditemukan.');
        }

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        try {
            $this->db->table('penulis')->where('id', $id)->update([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'bio'        => $this->request->getVar('bio'),
                'foto'       => $this->request->getVar('foto'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Penulis berhasil diubah.');
        return redirect()->to('/penulis');
    }

    public function delete($id)
    {
        $this->db->table('penulis')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Penulis berhasil dihapus.');
        return redirect()->to('/penulis');
    }

    public function restore($id)
    {
        $this->db->table('penulis')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        $this->session->setFlashdata('success', 'Penulis berhasil dipulihkan.');
        return redirect()->to('/penulis');
    }
}
