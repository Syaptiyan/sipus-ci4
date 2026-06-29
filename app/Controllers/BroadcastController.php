<?php

namespace App\Controllers;

class BroadcastController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Broadcast Pengumuman',
            'broadcasts' => $this->db->table('notifikasi')
                ->where('id_user', null)
                ->orderBy('created_at', 'DESC')
                ->limit(20)
                ->get()
                ->getResultArray(),
        ];
        return $this->view('broadcast/index', $data);
    }

    public function send()
    {
        $judul = $this->request->getPost('judul');
        $pesan = $this->request->getPost('pesan');
        $target = $this->request->getPost('target');

        if (!$judul || !$pesan) {
            return redirect()->back()->with('error', 'Judul dan pesan wajib diisi.');
        }

        if ($target === 'all') {
            $users = $this->db->table('users')->where('active', 1)->where('deleted_at', null)->get()->getResultArray();
        } else {
            $users = $this->db->table('users')->where('role', $target)->where('active', 1)->where('deleted_at', null)->get()->getResultArray();
        }

        $count = 0;
        foreach ($users as $u) {
            $this->db->table('notifikasi')->insert([
                'id_user'    => $u['id'],
                'judul'      => $judul,
                'pesan'      => $pesan,
                'type'       => 'info',
                'read'       => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $count++;
        }

        $this->logActivity('Broadcast pengumuman', 'broadcast', "Target: $target, Jumlah: $count");
        return redirect()->to('/broadcast')->with('success', "Pengumuman berhasil dikirim ke $count pengguna.");
    }
}
