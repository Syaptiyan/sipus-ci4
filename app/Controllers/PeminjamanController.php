<?php

namespace App\Controllers;

class PeminjamanController extends BaseController
{
    // ── SEMUA ROLE ─────────────────────────────────────

    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();
        $user = session()->get('user');

        $data = ['title' => 'Data Peminjaman'];
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as nama_anggota, users.nama as nama_petugas')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users', 'users.id = peminjaman.id_user')
            ->where('peminjaman.deleted_at', null);

        // Anggota hanya lihat peminjaman sendiri
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            $builder->where('peminjaman.id_anggota', $anggota->id ?? 0);
        }

        if ($search) {
            $builder->groupStart()
                ->like('peminjaman.kode_peminjaman', $search)
                ->orLike('anggota.nama', $search)
                ->groupEnd();
        }
        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        $total = $builder->countAllResults(false);

        $data['peminjaman'] = $builder
            ->orderBy('peminjaman.created_at', 'DESC')
            ->get($perPage, ($page - 1) * $perPage)
            ->getResultArray();
        $data['pager_links'] = $pager->makeLinks($page, $perPage, $total);
        $data['currentPage'] = (int)$page;
        $data['perPage'] = $perPage;
        $data['status'] = $status;
        $data['search'] = $search;
        $data['status_list'] = ['pending', 'approved', 'rejected', 'borrowed', 'returned', 'late', 'lost', 'damaged'];

        return $this->view('peminjaman/index', $data);
    }

    public function show($id)
    {
        $user = session()->get('user');

        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as nama_anggota, anggota.kode_anggota,
                      users.nama as nama_petugas, approve.nama as nama_petugas_approve')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users', 'users.id = peminjaman.id_user')
            ->join('users as approve', 'approve.id = peminjaman.id_user_approve', 'left')
            ->where('peminjaman.id', $id)
            ->get()
            ->getRowArray();

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan.');
        }

        // Anggota hanya bisa lihat peminjaman sendiri
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            if (!$anggota || $peminjaman['id_anggota'] != $anggota->id) {
                return redirect()->to('/peminjaman')->with('error', 'Anda tidak memiliki akses.');
            }
        }

        $data['detail'] = $this->db->table('detail_peminjaman')
            ->select('detail_peminjaman.*, buku.judul, buku.isbn, buku.cover')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $id)
            ->get()
            ->getResultArray();

        $data['title'] = 'Detail Peminjaman';
        $data['peminjaman'] = $peminjaman;
        return $this->view('peminjaman/show', $data);
    }

    // ── ANGGOTA: AJUKAN PEMINJAMAN ─────────────────────

    public function ajukan()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
        if (!$anggota) {
            return redirect()->to('/buku')->with('error', 'Data anggota tidak ditemukan.');
        }

        $id_buku = $this->request->getGet('id_buku');
        $buku = null;
        if ($id_buku) {
            $buku = $this->db->table('buku')
                ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis')
                ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
                ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                ->where('buku.id', $id_buku)
                ->where('buku.deleted_at', null)
                ->get()
                ->getRowArray();
        }

        $data = [
            'title' => 'Ajukan Peminjaman',
            'buku'  => $buku,
        ];
        return $this->view('peminjaman/ajukan', $data);
    }

    public function simpanAjuan()
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
        if (!$anggota) {
            return redirect()->to('/buku')->with('error', 'Data anggota tidak ditemukan.');
        }

        $id_buku = $this->request->getPost('id_buku');
        if (!$id_buku) {
            return redirect()->back()->with('error', 'Pilih buku yang ingin dipinjam.');
        }

        $buku = $this->db->table('buku')->where('id', $id_buku)->where('deleted_at', null)->get()->getRow();
        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        // Cek maksimal peminjaman
        $maks_pinjam = $this->db->table('pengaturan')->where('key', 'maks_pinjam')->get()->getRow()->value ?? 3;
        $aktif = $this->db->table('peminjaman')
            ->where('id_anggota', $anggota->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'late'])
            ->where('deleted_at', null)
            ->countAllResults();

        if ($aktif >= $maks_pinjam) {
            return redirect()->back()->with('error', "Anda hanya bisa memiliki maksimal $maks_pinjam peminjaman aktif.");
        }

        // Cek sudah pernah mengajukan buku yang sama
        $sudah_ajukan = $this->db->table('peminjaman')
            ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id')
            ->where('peminjaman.id_anggota', $anggota->id)
            ->where('detail_peminjaman.id_buku', $id_buku)
            ->whereIn('peminjaman.status', ['pending', 'approved', 'borrowed', 'late'])
            ->where('peminjaman.deleted_at', null)
            ->countAllResults();

        if ($sudah_ajukan > 0) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan peminjaman untuk buku ini.');
        }

        $last = $this->db->table('peminjaman')->select('id')->orderBy('id', 'DESC')->get()->getRow();
        $kode = 'PJM' . str_pad(($last->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $this->db->transStart();

        $this->db->table('peminjaman')->insert([
            'kode_peminjaman'   => $kode,
            'id_anggota'        => $anggota->id,
            'id_user'           => $user['id'],
            'tanggal_pengajuan' => date('Y-m-d'),
            'status'            => 'pending',
            'created_at'        => date('Y-m-d H:i:s'),
        ]);
        $peminjaman_id = $this->db->insertID();

        $this->db->table('detail_peminjaman')->insert([
            'id_peminjaman' => $peminjaman_id,
            'id_buku'       => $id_buku,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();

        $this->logActivity('Mengajukan peminjaman', 'peminjaman', "Kode: $kode");
        $this->createNotifikasi(null, 'Pengajuan Peminjaman Baru',
            "Anggota {$anggota->nama} mengajukan peminjaman {$buku->judul}.", 'info');

        return redirect()->to('/peminjaman')->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    public function batalkan($id)
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        $pinjam = $this->db->table('peminjaman')
            ->where('id', $id)
            ->where('id_anggota', $anggota->id ?? 0)
            ->where('status', 'pending')
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$pinjam) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan atau sudah diproses.');
        }

        $this->db->table('peminjaman')->where('id', $id)->update([
            'status'     => 'rejected',
            'alasan_tolak' => 'Dibatalkan oleh anggota',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Pengajuan peminjaman dibatalkan.');
    }

    public function perpanjang($id)
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();

        $pinjam = $this->db->table('peminjaman')
            ->where('id', $id)
            ->where('id_anggota', $anggota->id ?? 0)
            ->whereIn('status', ['borrowed', 'late'])
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$pinjam) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan atau tidak bisa diperpanjang.');
        }

        // Cek sudah diperpanjang sebelumnya
        if ($pinjam->tanggal_perpanjangan) {
            return redirect()->to('/peminjaman')->with('error', 'Hanya bisa perpanjang 1 kali.');
        }

        $masa_pinjam = $this->db->table('pengaturan')->where('key', 'masa_pinjam')->get()->getRow()->value ?? 7;
        $tanggal_baru = date('Y-m-d', strtotime("+$masa_pinjam days", strtotime($pinjam->tanggal_jatuh_tempo)));

        $this->db->table('peminjaman')->where('id', $id)->update([
            'tanggal_jatuh_tempo'  => $tanggal_baru,
            'tanggal_perpanjangan' => date('Y-m-d'),
            'updated_at'           => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/peminjaman/' . $id)->with('success', 'Peminjaman berhasil diperpanjang.');
    }

    // ── PETUGAS / ADMIN ────────────────────────────────

    public function new()
    {
        $data = ['title' => 'Peminjaman Baru'];
        $data['anggota'] = $this->db->table('anggota')->where('deleted_at', null)->get()->getResultArray();
        $data['buku'] = $this->db->table('buku')
            ->where('deleted_at', null)
            ->where('stok_tersedia >', 0)
            ->get()
            ->getResultArray();
        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['settings'] = [];
        foreach ($settings as $s) {
            $data['settings'][$s['key']] = $s['value'];
        }
        return $this->view('peminjaman/create', $data);
    }

    public function create()
    {
        return $this->new();
    }

    public function store()
    {
        $id_anggota = $this->request->getPost('id_anggota');
        $id_buku = $this->request->getPost('id_buku');
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam') ?: date('Y-m-d');
        $masa_pinjam = $this->db->table('pengaturan')->where('key', 'masa_pinjam')->get()->getRow()->value ?? 7;
        $maks_pinjam = $this->db->table('pengaturan')->where('key', 'maks_pinjam')->get()->getRow()->value ?? 3;

        if (!$id_anggota || !$id_buku || !is_array($id_buku)) {
            return redirect()->back()->with('error', 'Pilih anggota dan minimal 1 buku.');
        }

        $activeLoans = $this->db->table('peminjaman')
            ->where('id_anggota', $id_anggota)
            ->whereIn('status', ['borrowed', 'late'])
            ->where('deleted_at', null)
            ->countAllResults();

        if ($activeLoans + count($id_buku) > $maks_pinjam) {
            return redirect()->back()->with('error', "Anggota hanya bisa meminjam maksimal $maks_pinjam buku.");
        }

        foreach ($id_buku as $buku_id) {
            $buku = $this->db->table('buku')->where('id', $buku_id)->where('deleted_at', null)->get()->getRow();
            if (!$buku || $buku->stok_tersedia < 1) {
                return redirect()->back()->with('error', "Buku tidak tersedia.");
            }
        }

        $last = $this->db->table('peminjaman')->select('id')->orderBy('id', 'DESC')->get()->getRow();
        $kode = 'PJM' . str_pad(($last->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);
        $tanggal_jatuh_tempo = date('Y-m-d', strtotime("+$masa_pinjam days", strtotime($tanggal_pinjam)));

        $this->db->transStart();

        $this->db->table('peminjaman')->insert([
            'kode_peminjaman'   => $kode,
            'id_anggota'        => $id_anggota,
            'id_user'           => session()->get('user')['id'],
            'tanggal_pengajuan' => $tanggal_pinjam,
            'tanggal_pinjam'    => $tanggal_pinjam,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'tanggal_disetujui' => date('Y-m-d'),
            'status'            => 'borrowed',
            'created_at'        => date('Y-m-d H:i:s'),
        ]);
        $peminjaman_id = $this->db->insertID();

        foreach ($id_buku as $buku_id) {
            $this->db->table('detail_peminjaman')->insert([
                'id_peminjaman' => $peminjaman_id,
                'id_buku'       => $buku_id,
                'created_at'    => date('Y-m-d H:i:s'),
            ]);
            $this->db->table('buku')->where('id', $buku_id)->set('stok_tersedia', 'stok_tersedia - 1', false)->update();
        }

        $this->db->transComplete();

        $this->logActivity('Menambahkan peminjaman', 'peminjaman', "Kode: $kode");
        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function setujui($id)
    {
        $pinjam = $this->db->table('peminjaman')
            ->where('id', $id)
            ->where('status', 'pending')
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$pinjam) {
            return redirect()->to('/peminjaman')->with('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
        }

        $detail = $this->db->table('detail_peminjaman')
            ->where('id_peminjaman', $id)
            ->get()
            ->getResultArray();

        if (empty($detail)) {
            return redirect()->to('/peminjaman')->with('error', 'Data peminjaman tidak valid.');
        }

        // Cek stok
        foreach ($detail as $d) {
            $buku = $this->db->table('buku')->where('id', $d['id_buku'])->get()->getRow();
            if (!$buku || $buku->stok_tersedia < 1) {
                return redirect()->back()->with('error', 'Stok buku tidak mencukupi.');
            }
        }

        $masa_pinjam = $this->db->table('pengaturan')->where('key', 'masa_pinjam')->get()->getRow()->value ?? 7;
        $user = session()->get('user');

        $this->db->transStart();

        $this->db->table('peminjaman')->where('id', $id)->update([
            'status'             => 'borrowed',
            'id_user_approve'    => $user['id'],
            'tanggal_disetujui'  => date('Y-m-d'),
            'tanggal_pinjam'     => date('Y-m-d'),
            'tanggal_jatuh_tempo' => date('Y-m-d', strtotime("+$masa_pinjam days")),
            'updated_at'         => date('Y-m-d H:i:s'),
        ]);

        foreach ($detail as $d) {
            $this->db->table('buku')->where('id', $d['id_buku'])->set('stok_tersedia', 'stok_tersedia - 1', false)->update();
        }

        $this->db->transComplete();

        $anggota = $this->db->table('anggota')->where('id', $pinjam->id_anggota)->get()->getRow();
        $this->logActivity('Menyetujui peminjaman', 'peminjaman', "Kode: {$pinjam->kode_peminjaman}");
        $this->createNotifikasi($pinjam->id_user, 'Peminjaman Disetujui',
            "Peminjaman {$pinjam->kode_peminjaman} telah disetujui. Silakan ambil buku di perpustakaan.", 'success');

        return redirect()->to('/peminjaman/' . $id)->with('success', 'Peminjaman disetujui.');
    }

    public function tolak($id)
    {
        $pinjam = $this->db->table('peminjaman')
            ->where('id', $id)
            ->where('status', 'pending')
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$pinjam) {
            return redirect()->to('/peminjaman')->with('error', 'Pengajuan tidak ditemukan atau sudah diproses.');
        }

        $alasan = $this->request->getPost('alasan') ?: 'Pengajuan ditolak oleh petugas.';
        $user = session()->get('user');

        $this->db->table('peminjaman')->where('id', $id)->update([
            'status'          => 'rejected',
            'id_user_approve' => $user['id'],
            'alasan_tolak'    => $alasan,
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Menolak peminjaman', 'peminjaman', "Kode: {$pinjam->kode_peminjaman}, Alasan: $alasan");
        $this->createNotifikasi($pinjam->id_user, 'Peminjaman Ditolak',
            "Peminjaman {$pinjam->kode_peminjaman} ditolak. Alasan: $alasan", 'error');

        return redirect()->to('/peminjaman')->with('success', 'Pengajuan peminjaman ditolak.');
    }

    public function prosesKembali($id)
    {
        $pinjam = $this->db->table('peminjaman')
            ->where('id', $id)
            ->whereIn('status', ['borrowed', 'late'])
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$pinjam) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan atau sudah dikembalikan.');
        }

        $tanggal_kembali = $this->request->getPost('tanggal_kembali') ?: date('Y-m-d');
        $kembali = strtotime($tanggal_kembali);
        $jatuh_tempo = strtotime($pinjam->tanggal_jatuh_tempo);
        $hari_terlambat = max(0, floor(($kembali - $jatuh_tempo) / 86400));
        $denda_per_hari = $this->db->table('pengaturan')->where('key', 'denda_per_hari')->get()->getRow()->value ?? 1000;
        $total_denda = $hari_terlambat * $denda_per_hari;

        $detail = $this->db->table('detail_peminjaman')->where('id_peminjaman', $id)->get()->getResultArray();
        $user = session()->get('user');

        $this->db->transStart();

        $this->db->table('peminjaman')->where('id', $id)->update([
            'status'              => 'returned',
            'tanggal_dikembalikan' => $tanggal_kembali,
            'updated_at'          => date('Y-m-d H:i:s'),
        ]);

        foreach ($detail as $d) {
            $this->db->table('buku')->where('id', $d['id_buku'])->set('stok_tersedia', 'stok_tersedia + 1', false)->update();
        }

        if ($total_denda > 0) {
            $last = $this->db->table('pengembalian')->select('id')->orderBy('id', 'DESC')->get()->getRow();
            $kode_pg = 'PGM' . str_pad(($last->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

            $this->db->table('pengembalian')->insert([
                'kode_pengembalian' => $kode_pg,
                'id_peminjaman'     => $id,
                'id_user'           => $user['id'],
                'tanggal_kembali'   => $tanggal_kembali,
                'denda'             => $total_denda,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);

            $this->db->table('denda')->insert([
                'id_peminjaman'   => $id,
                'id_pengembalian' => $this->db->insertID(),
                'jumlah'          => $total_denda,
                'status'          => 'Belum Dibayar',
                'created_at'      => date('Y-m-d H:i:s'),
            ]);
        } else {
            // Tidak ada denda, tetap catat di pengembalian
            $last = $this->db->table('pengembalian')->select('id')->orderBy('id', 'DESC')->get()->getRow();
            $kode_pg = 'PGM' . str_pad(($last->id ?? 0) + 1, 4, '0', STR_PAD_LEFT);

            $this->db->table('pengembalian')->insert([
                'kode_pengembalian' => $kode_pg,
                'id_peminjaman'     => $id,
                'id_user'           => $user['id'],
                'tanggal_kembali'   => $tanggal_kembali,
                'denda'             => 0,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->transComplete();

        // Notifikasi ke anggota
        $this->createNotifikasi($pinjam->id_user, 'Pengembalian Buku',
            "Buku telah dikembalikan." . ($total_denda > 0 ? " Denda: Rp " . number_format($total_denda, 0, ',', '.') : ""),
            $total_denda > 0 ? 'warning' : 'success');

        // Cek antrian
        $this->prosesAntrian($detail[0]['id_buku'] ?? null);

        $msg = 'Pengembalian berhasil diproses.';
        if ($total_denda > 0) {
            $msg .= " Denda: Rp " . number_format($total_denda, 0, ',', '.');
        }
        return redirect()->to('/peminjaman/' . $id)->with('success', $msg);
    }

    // ── QUEUE / ANTRIAN ────────────────────────────────

    public function masukAntrian($id_buku)
    {
        $user = session()->get('user');
        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
        if (!$anggota) {
            return redirect()->to('/buku')->with('error', 'Data anggota tidak ditemukan.');
        }

        $buku = $this->db->table('buku')->where('id', $id_buku)->where('deleted_at', null)->get()->getRow();
        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        // Cek sudah di antrian
        $sudah = $this->db->table('antrian_buku')
            ->where('id_buku', $id_buku)
            ->where('id_anggota', $anggota->id)
            ->where('status', 'waiting')
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if ($sudah) {
            return redirect()->back()->with('warning', 'Anda sudah dalam antrian buku ini.');
        }

        // Nomor antrian terakhir
        $last = $this->db->table('antrian_buku')
            ->select('nomor_antrian')
            ->where('id_buku', $id_buku)
            ->where('deleted_at', null)
            ->orderBy('nomor_antrian', 'DESC')
            ->get()
            ->getRow();

        $nomor = ($last->nomor_antrian ?? 0) + 1;

        $this->db->table('antrian_buku')->insert([
            'id_buku'    => $id_buku,
            'id_anggota' => $anggota->id,
            'nomor_antrian' => $nomor,
            'status'     => 'waiting',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', "Anda masuk antrian nomor #$nomor.");
    }

    private function prosesAntrian($id_buku)
    {
        if (!$id_buku) return;

        $next = $this->db->table('antrian_buku')
            ->select('antrian_buku.*, anggota.id_user, buku.judul')
            ->join('anggota', 'anggota.id = antrian_buku.id_anggota')
            ->join('buku', 'buku.id = antrian_buku.id_buku')
            ->where('antrian_buku.id_buku', $id_buku)
            ->where('antrian_buku.status', 'waiting')
            ->where('antrian_buku.deleted_at', null)
            ->orderBy('antrian_buku.nomor_antrian', 'ASC')
            ->limit(1)
            ->get()
            ->getRow();

        if ($next) {
            $this->createNotifikasi($next->id_user, 'Buku Tersedia',
                "Buku {$next->judul} sudah tersedia. Anda memiliki 24 jam untuk konfirmasi peminjaman.", 'info');

            $this->db->table('antrian_buku')->where('id', $next->id)->update([
                'expired_at' => date('Y-m-d H:i:s', strtotime('+24 hours')),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    // ── CRUM PETUGAS ────────────────────────────────────

    public function edit($id)
    {
        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama as nama_anggota, anggota.kode_anggota, users.nama as nama_petugas')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->join('users', 'users.id = peminjaman.id_user')
            ->where('peminjaman.id', $id)
            ->where('peminjaman.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan.');
        }

        $detail = $this->db->table('detail_peminjaman')
            ->select('detail_peminjaman.*, buku.judul, buku.isbn')
            ->join('buku', 'buku.id = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $id)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Edit Peminjaman',
            'peminjaman' => $peminjaman,
            'detail' => $detail,
        ];
        return $this->view('peminjaman/edit', $data);
    }

    public function update($id)
    {
        $peminjaman = $this->db->table('peminjaman')
            ->where('id', $id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Peminjaman tidak ditemukan.');
        }

        $tanggal_jatuh_tempo = $this->request->getPost('tanggal_jatuh_tempo');
        $data = ['updated_at' => date('Y-m-d H:i:s')];
        if ($tanggal_jatuh_tempo) {
            $data['tanggal_jatuh_tempo'] = $tanggal_jatuh_tempo;
        }

        $this->db->table('peminjaman')->update($data, ['id' => $id]);
        $this->logActivity('Mengubah peminjaman', 'peminjaman', 'Kode: ' . $peminjaman['kode_peminjaman']);
        return redirect()->to('/peminjaman/' . $id)->with('success', 'Peminjaman berhasil diubah.');
    }

    public function delete($id)
    {
        $this->db->table('peminjaman')->where('id', $id)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        $this->logActivity('Menghapus peminjaman', 'peminjaman', "ID: $id");
        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
