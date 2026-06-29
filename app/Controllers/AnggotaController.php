<?php

namespace App\Controllers;

class AnggotaController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getVar('search');
        $builder = $this->db->table('anggota');
        $builder->where('deleted_at', null);

        if ($search) {
            $builder->like('nama', $search);
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title'   => 'Anggota',
            'anggota' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search'  => $search,
        ];

        return $this->view('anggota/index', $data);
    }

    public function create()
    {
        $last = $this->db->table('anggota')->select('id')->orderBy('id', 'DESC')->limit(1)->get()->getRowArray();
        $lastId = $last ? (int)$last['id'] + 1 : 1;
        $kodeAnggota = 'AGT' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $data = [
            'title'        => 'Tambah Anggota',
            'kode_anggota' => $kodeAnggota,
        ];

        return $this->view('anggota/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama'  => 'required',
            'email' => 'permit_empty|valid_email',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        }

        try {
            $this->db->table('anggota')->insert([
                'kode_anggota'  => $this->request->getVar('kode_anggota'),
                'nama'          => $this->request->getVar('nama'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                'alamat'        => $this->request->getVar('alamat'),
                'telp'          => $this->request->getVar('telp'),
                'email'         => $this->request->getVar('email'),
                'foto'          => $this->request->getVar('foto'),
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Anggota berhasil ditambahkan.');
        return redirect()->to('/anggota');
    }

    public function show($id)
    {
        $anggota = $this->db->table('anggota')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$anggota) {
            return redirect()->to('/anggota')->with('error', 'Anggota tidak ditemukan.');
        }
        $data = ['title' => 'Detail Anggota', 'anggota' => $anggota];
        return $this->view('anggota/show', $data);
    }

    public function kartu($id)
    {
        $anggota = $this->db->table('anggota')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$anggota) {
            return redirect()->to('/anggota')->with('error', 'Anggota tidak ditemukan.');
        }
        $data = ['title' => 'Kartu Anggota', 'anggota' => $anggota];
        return $this->view('anggota/kartu', $data);
    }

    public function kartuSaya()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRowArray();
        if (!$anggota) {
            return redirect()->to('/dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }
        $data = ['title' => 'Kartu Anggota Saya', 'anggota' => $anggota];
        return $this->view('anggota/kartu', $data);
    }

    public function edit($id)
    {
        $anggota = $this->db->table('anggota')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => 'Edit Anggota',
            'anggota' => $anggota,
        ];

        return $this->view('anggota/edit', $data);
    }

    public function update($id)
    {
        $anggota = $this->db->table('anggota')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();
        if (!$anggota) {
            return redirect()->to('/anggota')->with('error', 'Anggota tidak ditemukan.');
        }

        $rules = [
            'nama'  => 'required',
            'email' => 'permit_empty|valid_email',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.');
        }

        try {
            $this->db->table('anggota')->where('id', $id)->update([
                'kode_anggota'  => $this->request->getVar('kode_anggota'),
                'nama'          => $this->request->getVar('nama'),
                'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
                'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
                'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
                'alamat'        => $this->request->getVar('alamat'),
                'telp'          => $this->request->getVar('telp'),
                'email'         => $this->request->getVar('email'),
                'foto'          => $this->request->getVar('foto'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $this->session->setFlashdata('success', 'Anggota berhasil diubah.');
        return redirect()->to('/anggota');
    }

    public function delete($id)
    {
        $this->db->table('anggota')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->setFlashdata('success', 'Anggota berhasil dihapus.');
        return redirect()->to('/anggota');
    }

    public function restore($id)
    {
        $this->db->table('anggota')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        $this->session->setFlashdata('success', 'Anggota berhasil dipulihkan.');
        return redirect()->to('/anggota');
    }

    public function statistik()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        if (!$anggota) {
            return redirect()->to('/dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        $data = ['title' => 'Statistik Saya'];

        $data['total_pinjam'] = $this->db->table('peminjaman')
            ->where('id_anggota', $anggota->id)
            ->where('deleted_at', null)
            ->countAllResults();

        $data['sedang_pinjam'] = $this->db->table('peminjaman')
            ->where('id_anggota', $anggota->id)
            ->whereIn('status', ['borrowed', 'late'])
            ->where('deleted_at', null)
            ->countAllResults();

        $data['total_denda'] = $this->db->table('denda')
            ->select('COALESCE(SUM(denda.jumlah), 0) as total')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->where('peminjaman.id_anggota', $anggota->id)
            ->where('denda.deleted_at', null)
            ->get()->getRow()->total ?? 0;

        $data['rating_rata'] = $this->db->table('review_buku')
            ->selectAvg('rating')
            ->where('id_anggota', $anggota->id)
            ->where('deleted_at', null)
            ->get()->getRow()->rating ?? 0;

        $kategori_fav = $this->db->table('detail_peminjaman')
            ->select('kategori.nama, COUNT(*) as total')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->join('kategori', 'kategori.id = buku.id_kategori')
            ->join('peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman')
            ->where('peminjaman.id_anggota', $anggota->id)
            ->where('peminjaman.deleted_at', null)
            ->groupBy('kategori.id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()->getResultArray();
        $data['kategori_fav'] = $kategori_fav;

        $penulis_fav = $this->db->table('detail_peminjaman')
            ->select('penulis.nama, COUNT(*) as total')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->join('penulis', 'penulis.id = buku.id_penulis')
            ->join('peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman')
            ->where('peminjaman.id_anggota', $anggota->id)
            ->where('peminjaman.deleted_at', null)
            ->groupBy('penulis.id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()->getResultArray();
        $data['penulis_fav'] = $penulis_fav;

        $chart_labels = [];
        $chart_data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chart_labels[] = date('M Y', strtotime("-$i months"));
            $count = $this->db->table('peminjaman')
                ->where('id_anggota', $anggota->id)
                ->where('deleted_at', null)
                ->where("DATE_FORMAT(tanggal_pengajuan, '%Y-%m')", $month)
                ->countAllResults();
            $chart_data[] = $count;
        }
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;

        return $this->view('anggota/statistik', $data);
    }
}
