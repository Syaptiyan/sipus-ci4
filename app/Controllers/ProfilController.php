<?php

namespace App\Controllers;

class ProfilController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $data = [
            'title' => 'Profil Saya',
            'profil' => $this->db->table('users')->where('id', $user['id'])->get()->getRowArray(),
        ];
        return $this->view('profil/index', $data);
    }

    public function update()
    {
        $user = session()->get('user');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $nip = $this->request->getPost('nip');

        if (!$nama || !$email) {
            return redirect()->back()->with('error', 'Nama dan email wajib diisi.');
        }

        $emailExists = $this->db->table('users')
            ->where('email', $email)
            ->where('id !=', $user['id'])
            ->where('deleted_at', null)
            ->countAllResults();

        if ($emailExists > 0) {
            return redirect()->back()->with('error', 'Email sudah digunakan oleh akun lain.');
        }

        $update = [
            'nama' => $nama,
            'email' => $email,
            'nip' => $nip,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($_FILES['foto']['name']) {
            $file = $this->request->getFile('foto');
            if ($file->isValid() && !$file->hasMoved()) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = $file->getExtension();
                if (!in_array(strtolower($ext), $allowed)) {
                    return redirect()->back()->with('error', 'Format foto harus JPG, JPEG, PNG, atau WEBP.');
                }
                if ($file->getSizeByUnit('mb') > 2) {
                    return redirect()->back()->with('error', 'Ukuran foto maksimal 2MB.');
                }
                $newName = 'user_' . $user['id'] . '_' . time() . '.' . $ext;
                $file->move(FCPATH . 'uploads/profil', $newName);
                $update['foto'] = 'uploads/profil/' . $newName;
            }
        }

        $this->db->table('users')->where('id', $user['id'])->update($update);

        $userData = $this->db->table('users')->where('id', $user['id'])->get()->getRowArray();
        $this->session->set('user', [
            'id'       => $userData['id'],
            'username' => $userData['username'],
            'nama'     => $userData['nama'],
            'email'    => $userData['email'],
            'role'     => $userData['role'],
            'nip'      => $userData['nip'],
            'foto'     => $userData['foto'],
        ]);

        $this->logActivity('Update profil', 'profil');
        return redirect()->to('/profil')->with('success', 'Profil berhasil diupdate.');
    }

    public function ubahPassword()
    {
        $data = ['title' => 'Ubah Password'];
        return $this->view('profil/ubah_password', $data);
    }

    public function ubahPasswordStore()
    {
        $user = session()->get('user');
        $lama = $this->request->getPost('password_lama');
        $baru = $this->request->getPost('password_baru');
        $konfirmasi = $this->request->getPost('password_confirm');

        if (!$lama || !$baru || !$konfirmasi) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        $userData = $this->db->table('users')->where('id', $user['id'])->get()->getRow();
        if (!password_verify($lama, $userData->password)) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        if ($baru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        if (strlen($baru) < 6) {
            return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
        }

        $this->db->table('users')->where('id', $user['id'])->update([
            'password' => password_hash($baru, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Ubah password', 'profil');
        return redirect()->to('/profil/ubah-password')->with('success', 'Password berhasil diubah.');
    }

    public function loginHistory()
    {
        $user = session()->get('user');
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $builder = $this->db->table('login_history')
            ->where('id_user', $user['id'])
            ->orderBy('created_at', 'DESC');

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Riwayat Login',
            'history' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
        ];

        return $this->view('profil/login_history', $data);
    }
}
