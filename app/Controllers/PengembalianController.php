<?php

namespace App\Controllers;

class PengembalianController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $data['title'] = 'Data Pengembalian';
        $search = $this->request->getGet('search');

        $builder = $this->db->table('pengembalian')
            ->select('pengembalian.*, peminjaman.kode_peminjaman, anggota.nama as nama_anggota, users.nama as nama_petugas')
            ->join('peminjaman', 'peminjaman.id = pengembalian.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users', 'users.id = pengembalian.id_user')
            ->where('pengembalian.deleted_at', null);

        if ($search) {
            $builder->groupStart()
                ->like('pengembalian.kode_pengembalian', $search)
                ->orLike('anggota.nama', $search)
                ->orLike('peminjaman.kode_peminjaman', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $data['pengembalian'] = $builder
            ->orderBy('pengembalian.created_at', 'DESC')
            ->get($perPage, ($page - 1) * $perPage)
            ->getResultArray();
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total);
        $data['currentPage'] = (int)$page;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        return $this->view('pengembalian/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Pengembalian Buku';
        $data['peminjaman'] = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as nama_anggota')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->whereIn('peminjaman.status', ['borrowed', 'late'])
            ->where('peminjaman.deleted_at', null)
            ->orderBy('peminjaman.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['denda_per_hari'] = 1000;
        foreach ($settings as $s) {
            if ($s['key'] === 'denda_per_hari') $data['denda_per_hari'] = $s['value'];
        }
        return $this->view('pengembalian/create', $data);
    }

    public function create()
    {
        return $this->new();
    }

    public function store()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $tanggal_kembali = $this->request->getPost('tanggal_kembali') ?: date('Y-m-d');

        if (!$id_peminjaman) {
            return redirect()->back()->with('error', 'Pilih data peminjaman.');
        }

        $pinjam = $this->db->table('peminjaman')->where('id', $id_peminjaman)->where('deleted_at', null)->get()->getRow();
        if (!$pinjam || in_array($pinjam->status, ['returned'])) {
            return redirect()->back()->with('error', 'Peminjaman sudah dikembalikan.');
        }

        $jatuh_tempo = strtotime($pinjam->tanggal_jatuh_tempo);
        $kembali = strtotime($tanggal_kembali);
        $hari_terlambat = max(0, floor(($kembali - $jatuh_tempo) / 86400));
        $denda_per_hari = $this->db->table('pengaturan')->where('key', 'denda_per_hari')->get()->getRow()->value ?? 1000;
        $total_denda = $hari_terlambat * $denda_per_hari;

        $detail = $this->db->table('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->getResultArray();

        $last = $this->db->table('pengembalian')->select('id')->orderBy('id', 'DESC')->get()->getRow();
        $kode = 'PGM' . str_pad(($last->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $this->db->transStart();

        $this->db->table('pengembalian')->insert([
            'kode_pengembalian' => $kode,
            'id_peminjaman'     => $id_peminjaman,
            'id_user'           => session()->get('user')['id'],
            'tanggal_kembali'   => $tanggal_kembali,
            'denda'             => $total_denda,
            'created_at'        => date('Y-m-d H:i:s'),
        ]);

        $pengembalian_id = $this->db->insertID();

        $this->db->table('peminjaman')->where('id', $id_peminjaman)->update([
            'status' => $hari_terlambat > 0 ? 'late' : 'returned',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        foreach ($detail as $d) {
            $this->db->table('buku')->where('id', $d['id_buku'])->set('stok_tersedia', 'stok_tersedia + 1', false)->update();
        }

        if ($total_denda > 0) {
            $this->db->table('denda')->insert([
                'id_pengembalian' => $pengembalian_id,
                'id_peminjaman'   => $id_peminjaman,
                'jumlah'          => $total_denda,
                'status'          => 'Belum Dibayar',
                'created_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->transComplete();

        $this->logActivity('Pengembalian buku', 'pengembalian', "Kode: $kode, Denda: $total_denda");
        $this->createNotifikasi(null, 'Pengembalian Buku', "Pengembalian kode {$kode} telah diproses.", 'success');
        $msg = 'Pengembalian berhasil.';
        if ($total_denda > 0) {
            $msg .= " Denda: Rp " . number_format($total_denda, 0, ',', '.');
        }
        return redirect()->to('/pengembalian')->with('success', $msg);
    }

    public function show($id)
    {
        $pengembalian = $this->db->table('pengembalian')
            ->select('pengembalian.*, peminjaman.kode_peminjaman, anggota.nama as nama_anggota, users.nama as nama_petugas')
            ->join('peminjaman', 'peminjaman.id = pengembalian.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users', 'users.id = pengembalian.id_user')
            ->where('pengembalian.id', $id)
            ->where('pengembalian.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$pengembalian) {
            return redirect()->to('/pengembalian')->with('error', 'Pengembalian tidak ditemukan.');
        }

        $data = ['title' => 'Detail Pengembalian', 'pengembalian' => $pengembalian];
        return $this->view('pengembalian/show', $data);
    }

    public function delete($id)
    {
        $this->db->table('pengembalian')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/pengembalian')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
