<?php

namespace App\Controllers;

class KategoriController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getVar('search');
        $builder = $this->db->table('kategori');
        $builder->where('deleted_at', null);

        if ($search) {
            $builder->like('nama', $search);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title'    => 'Kategori',
            'kategori' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search'   => $search,
        ];

        return $this->view('kategori/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Kategori'];
        return $this->view('kategori/create', $data);
    }

    public function store()
    {
        $rules = ['nama' => 'required|is_unique[kategori.nama]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Nama kategori sudah ada atau tidak valid.');
        }

        try {
            $this->db->table('kategori')->insert([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'deskripsi'  => $this->request->getVar('deskripsi'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Kategori berhasil ditambahkan.');
        return redirect()->to('/kategori');
    }

    public function show($id)
    {
        $kategori = $this->db->table('kategori')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }
        $data = ['title' => 'Detail Kategori', 'kategori' => $kategori];
        return $this->view('kategori/show', $data);
    }

    public function edit($id)
    {
        $kategori = $this->db->table('kategori')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Kategori',
            'kategori' => $kategori,
        ];

        return $this->view('kategori/edit', $data);
    }

    public function update($id)
    {
        $kategori = $this->db->table('kategori')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        try {
            $this->db->table('kategori')->where('id', $id)->update([
                'nama'       => $this->request->getVar('nama'),
                'slug'       => url_title($this->request->getVar('nama'), '-', true),
                'deskripsi'  => $this->request->getVar('deskripsi'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Kategori berhasil diubah.');
        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $this->db->table('kategori')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Kategori berhasil dihapus.');
        return redirect()->to('/kategori');
    }

    public function restore($id)
    {
        $this->db->table('kategori')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        $this->session->setFlashdata('success', 'Kategori berhasil dipulihkan.');
        return redirect()->to('/kategori');
    }
}
