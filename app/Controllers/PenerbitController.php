<?php

namespace App\Controllers;

class PenerbitController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getVar('search');
        $builder = $this->db->table('penerbit');
        $builder->where('deleted_at', null);

        if ($search) {
            $builder->like('nama', $search);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title'    => 'Penerbit',
            'penerbit' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search'   => $search,
        ];

        return $this->view('penerbit/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Penerbit'];
        return $this->view('penerbit/create', $data);
    }

    public function store()
    {
        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Nama penerbit harus diisi.');
        }

        try {
            $this->db->table('penerbit')->insert([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'alamat'     => $this->request->getVar('alamat'),
                'telp'       => $this->request->getVar('telp'),
                'email'      => $this->request->getVar('email'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Penerbit berhasil ditambahkan.');
        return redirect()->to('/penerbit');
    }

    public function show($id)
    {
        $penerbit = $this->db->table('penerbit')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$penerbit) {
            return redirect()->to('/penerbit')->with('error', 'Penerbit tidak ditemukan.');
        }
        $data = ['title' => 'Detail Penerbit', 'penerbit' => $penerbit];
        return $this->view('penerbit/show', $data);
    }

    public function edit($id)
    {
        $penerbit = $this->db->table('penerbit')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$penerbit) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Penerbit',
            'penerbit' => $penerbit,
        ];

        return $this->view('penerbit/edit', $data);
    }

    public function update($id)
    {
        $penerbit = $this->db->table('penerbit')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$penerbit) {
            return redirect()->to('/penerbit')->with('error', 'Penerbit tidak ditemukan.');
        }

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        try {
            $this->db->table('penerbit')->where('id', $id)->update([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'alamat'     => $this->request->getVar('alamat'),
                'telp'       => $this->request->getVar('telp'),
                'email'      => $this->request->getVar('email'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Penerbit berhasil diubah.');
        return redirect()->to('/penerbit');
    }

    public function delete($id)
    {
        $this->db->table('penerbit')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Penerbit berhasil dihapus.');
        return redirect()->to('/penerbit');
    }

    public function restore($id)
    {
        $this->db->table('penerbit')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        $this->session->setFlashdata('success', 'Penerbit berhasil dipulihkan.');
        return redirect()->to('/penerbit');
    }
}
