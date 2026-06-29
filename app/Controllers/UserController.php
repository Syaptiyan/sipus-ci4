<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $builder = $this->db->table('users')
            ->where('deleted_at', null);

        $total = $builder->countAllResults(false);

        $data['title'] = 'Data Pengguna';
        $data['users'] = $builder
            ->orderBy('created_at', 'DESC')
            ->get($perPage, ($page - 1) * $perPage)
            ->getResultArray();
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total);
        $data['currentPage'] = (int)$page;
        $data['perPage'] = $perPage;
        return $this->view('user/index', $data);
    }

    public function new() { return $this->create(); }
    public function create()
    {
        $data['title'] = 'Tambah Pengguna';
        return $this->view('user/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nama'     => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        }

        $this->db->table('users')->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama'       => $this->request->getPost('nama'),
            'nip'        => $this->request->getPost('nip'),
            'role'       => $this->request->getPost('role') ?: 'Petugas',
            'active'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Menambahkan pengguna', 'user', 'Username: ' . $this->request->getPost('username'));
        return redirect()->to('/user')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pengguna';
        $data['user'] = $this->db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$data['user']) {
            return redirect()->to('/user')->with('error', 'Pengguna tidak ditemukan.');
        }
        return $this->view('user/edit', $data);
    }

    public function update($id)
    {
        $user = $this->db->table('users')->where('id', $id)->get()->getRow();
        if (!$user) {
            return redirect()->to('/user')->with('error', 'Pengguna tidak ditemukan.');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'nama'     => $this->request->getPost('nama'),
            'nip'      => $this->request->getPost('nip'),
            'role'     => $this->request->getPost('role') ?: $user->role,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (session()->get('user')['role'] !== 'Admin') {
            unset($data['role']);
        }

        $this->db->table('users')->where('id', $id)->update($data);
        $this->logActivity('Mengupdate pengguna', 'user', "ID: $id");
        return redirect()->to('/user')->with('success', 'Pengguna berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($id == session()->get('user')['id']) {
            return redirect()->to('/user')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $this->db->table('users')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $this->logActivity('Menghapus pengguna', 'user', "ID: $id");
        return redirect()->to('/user')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function restore($id)
    {
        $this->db->table('users')->where('id', $id)->update(['deleted_at' => null]);
        return redirect()->to('/user')->with('success', 'Pengguna berhasil direstore.');
    }

    public function toggleActive($id)
    {
        $user = $this->db->table('users')->where('id', $id)->where('deleted_at', null)->get()->getRow();
        if (!$user) {
            return redirect()->to('/user')->with('error', 'Pengguna tidak ditemukan.');
        }

        if ($id == session()->get('user')['id']) {
            return redirect()->to('/user')->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $newStatus = $user->active ? 0 : 1;
        $this->db->table('users')->where('id', $id)->update([
            'active' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        $this->logActivity('Mengubah status pengguna', 'user', "ID: $id, Status: $statusText");
        return redirect()->to('/user')->with('success', "Pengguna berhasil $statusText.");
    }

    public function pending()
    {
        $data = [
            'title' => 'Menunggu Aktivasi',
            'pending_users' => $this->db->table('users')
                ->where('active', 0)
                ->where('deleted_at', null)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray(),
        ];
        return $this->view('user/pending', $data);
    }

    public function activate($id)
    {
        $user = $this->db->table('users')->where('id', $id)->where('deleted_at', null)->get()->getRow();
        if (!$user) {
            return redirect()->to('/user/pending')->with('error', 'Pengguna tidak ditemukan.');
        }

        $this->db->table('users')->where('id', $id)->update([
            'active' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Set masa aktif anggota 6 bulan
        $anggota = $this->db->table('anggota')->where('id_user', $id)->get()->getRow();
        if ($anggota) {
            $this->db->table('anggota')->where('id', $anggota->id)->update([
                'tanggal_aktif' => date('Y-m-d'),
                'tanggal_expired' => date('Y-m-d', strtotime('+6 months')),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->logActivity('Aktivasi akun', 'user', "Username: {$user->username}");
        $this->createNotifikasi($id, 'Akun Diaktifkan', 'Akun Anda telah diaktifkan oleh admin. Silakan login.', 'success');
        return redirect()->to('/user/pending')->with('success', "Akun {$user->username} berhasil diaktifkan.");
    }
}
