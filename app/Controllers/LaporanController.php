<?php

namespace App\Controllers;

class LaporanController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Laporan';
        return $this->view('laporan/index', $data);
    }

    public function print()
    {
        $jenis = $this->request->getPost('jenis');
        $dari = $this->request->getPost('dari');
        $sampai = $this->request->getPost('sampai');

        $data['title'] = 'Laporan ' . ucfirst($jenis);
        $data['dari'] = $dari;
        $data['sampai'] = $sampai;

        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['pengaturan'] = [];
        foreach ($settings as $s) {
            $data['pengaturan'][$s['key']] = $s['value'];
        }
        $data['user'] = session()->get('user');

        switch ($jenis) {
            case 'buku':
                $data['buku'] = $this->db->table('buku')
                    ->select('buku.*, kategori.nama as kategori, penulis.nama as penulis, penerbit.nama as penerbit')
                    ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                    ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                    ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
                    ->where('buku.deleted_at', null)
                    ->get()->getResultArray();
                return $this->view('laporan/buku', $data);
            case 'peminjaman':
                $builder = $this->db->table('peminjaman')
                    ->select('peminjaman.*, anggota.nama as nama_anggota, users.nama as nama_petugas')
                    ->join('anggota', 'anggota.id = peminjaman.id_anggota')
                    ->join('users', 'users.id = peminjaman.id_user')
                    ->where('peminjaman.deleted_at', null);
                if ($dari) $builder->where('peminjaman.tanggal_pinjam >=', $dari);
                if ($sampai) $builder->where('peminjaman.tanggal_pinjam <=', $sampai);
                $data['peminjaman'] = $builder->orderBy('peminjaman.tanggal_pinjam', 'DESC')->get()->getResultArray();
                return $this->view('laporan/peminjaman', $data);
            case 'anggota':
                $data['anggota'] = $this->db->table('anggota')
                    ->where('deleted_at', null)->get()->getResultArray();
                return $this->view('laporan/anggota', $data);
            case 'denda':
                $builder = $this->db->table('denda')
                    ->select('denda.*, peminjaman.kode_peminjaman, anggota.nama as nama_anggota')
                    ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
                    ->join('anggota', 'anggota.id = peminjaman.id_anggota')
                    ->where('denda.deleted_at', null);
                if ($dari) $builder->where('denda.created_at >=', $dari);
                if ($sampai) $builder->where('denda.created_at <=', $sampai);
                $data['denda'] = $builder->orderBy('denda.created_at', 'DESC')->get()->getResultArray();
                return $this->view('laporan/denda', $data);
            default:
                return redirect()->to('/laporan')->with('error', 'Jenis laporan tidak valid.');
        }
    }
}
