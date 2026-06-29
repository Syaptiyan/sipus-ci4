<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $cache = \Config\Services::cache();

        $cacheKey = 'dashboard_stats_' . $user['role'];
        $stats = $cache->get($cacheKey);

        if (!$stats) {
            $stats = [
                'total_buku'     => $this->db->table('buku')->where('deleted_at', null)->countAllResults(),
                'total_anggota'  => $this->db->table('anggota')->where('deleted_at', null)->countAllResults(),
                'total_peminjaman' => $this->db->table('peminjaman')->where('deleted_at', null)->countAllResults(),
                'total_pengembalian' => $this->db->table('pengembalian')->where('deleted_at', null)->countAllResults(),
                'total_denda'    => $this->db->table('denda')->where('deleted_at', null)->where('status', 'Belum Dibayar')->selectSum('jumlah')->get()->getRow()->jumlah ?? 0,
                'total_penulis'  => $this->db->table('penulis')->where('deleted_at', null)->countAllResults(),
                'total_penerbit' => $this->db->table('penerbit')->where('deleted_at', null)->countAllResults(),
                'total_kategori' => $this->db->table('kategori')->where('deleted_at', null)->countAllResults(),
                'peminjaman_aktif' => $this->db->table('peminjaman')->where('deleted_at', null)->where('status', 'borrowed')->countAllResults(),
                'buku_kosong'   => $this->db->table('buku')->where('deleted_at', null)->where('stok_tersedia', 0)->countAllResults(),
                'pending_approval' => $this->db->table('peminjaman')->where('deleted_at', null)->where('status', 'pending')->countAllResults(),
                'terlambat'       => $this->db->table('peminjaman')->where('deleted_at', null)->where('status', 'late')->countAllResults(),
                'dikembalikan_hari_ini' => $this->db->table('peminjaman')->where('deleted_at', null)->where('status', 'returned')->where('DATE(tanggal_dikembalikan)', date('Y-m-d'))->countAllResults(),
                'antrian_buku'    => $this->db->table('antrian_buku')->where('deleted_at', null)->where('status', 'waiting')->countAllResults(),
                'users_online'    => $this->db->table('users')->where('deleted_at', null)->where('active', 1)->where('last_activity >=', date('Y-m-d H:i:s', strtotime('-5 minutes')))->countAllResults(),
            ];

            $cache->save($cacheKey, $stats, 300);
        }

        $data = array_merge(['title' => 'Dashboard'], $stats);

        $cacheKeyRecent = 'dashboard_recent';
        $recent = $cache->get($cacheKeyRecent);

        if (!$recent) {
            $recent = [
                'peminjaman_terbaru' => $this->db->table('peminjaman')
                    ->select('peminjaman.*, anggota.nama as nama_anggota')
                    ->join('anggota', 'anggota.id = peminjaman.id_anggota')
                    ->where('peminjaman.deleted_at', null)
                    ->orderBy('peminjaman.created_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray(),
                'aktivitas' => $this->db->table('log_aktivitas')
                    ->select('log_aktivitas.*, users.nama as nama_user')
                    ->join('users', 'users.id = log_aktivitas.id_user', 'left')
                    ->orderBy('log_aktivitas.created_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray(),
            ];

            $cache->save($cacheKeyRecent, $recent, 120);
        }

        $data = array_merge($data, $recent);

        $data['peminjaman_saya'] = [];
        $data['favorit_saya'] = [];
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            if ($anggota) {
                $data['peminjaman_saya'] = $this->db->table('peminjaman')
                    ->select('peminjaman.*, buku.judul as judul_buku')
                    ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id')
                    ->join('buku', 'buku.id = detail_peminjaman.id_buku')
                    ->where('peminjaman.id_anggota', $anggota->id)
                    ->where('peminjaman.deleted_at', null)
                    ->orderBy('peminjaman.created_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray();

                $data['favorit_saya'] = $this->db->table('favorit_buku')
                    ->select('favorit_buku.*, buku.judul, buku.isbn, buku.stok_tersedia, penulis.nama as nama_penulis')
                    ->join('buku', 'buku.id = favorit_buku.id_buku')
                    ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
                    ->where('favorit_buku.id_anggota', $anggota->id)
                    ->where('favorit_buku.deleted_at', null)
                    ->where('buku.deleted_at', null)
                    ->orderBy('favorit_buku.created_at', 'DESC')
                    ->limit(5)
                    ->get()
                    ->getResultArray();
            }
        }

        $cacheKeyChart = 'dashboard_charts';
        $charts = $cache->get($cacheKeyChart);

        if (!$charts) {
            $chart_labels = [];
            $chart_data = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = date('Y-m', strtotime("-$i months"));
                $chart_labels[] = date('M Y', strtotime("-$i months"));
                $count = $this->db->table('peminjaman')
                    ->where('deleted_at', null)
                    ->where("DATE_FORMAT(tanggal_pengajuan, '%Y-%m')", $month)
                    ->countAllResults();
                $chart_data[] = $count;
            }

            $top_buku = $this->db->table('detail_peminjaman')
                ->select('buku.judul, COUNT(*) as total')
                ->join('buku', 'buku.id = detail_peminjaman.id_buku')
                ->join('peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman')
                ->where('peminjaman.deleted_at', null)
                ->groupBy('buku.id')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $top_wishlist = $this->db->table('wishlist_buku')
                ->select('judul_buku, COUNT(*) as total')
                ->where('deleted_at', null)
                ->groupBy('judul_buku')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $top_anggota = $this->db->table('peminjaman')
                ->select('anggota.nama, COUNT(*) as total')
                ->join('anggota', 'anggota.id = peminjaman.id_anggota')
                ->where('peminjaman.deleted_at', null)
                ->groupBy('peminjaman.id_anggota')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $denda_stats = $this->db->table('denda')
                ->select('status, SUM(jumlah) as total')
                ->where('deleted_at', null)
                ->groupBy('status')
                ->get()
                ->getResultArray();

            $kategori_stats = $this->db->table('buku')
                ->select('kategori.nama, COUNT(*) as total')
                ->join('kategori', 'kategori.id = buku.id_kategori')
                ->where('buku.deleted_at', null)
                ->groupBy('buku.id_kategori')
                ->orderBy('total', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $anggota_baru_labels = [];
            $anggota_baru_data = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = date('Y-m', strtotime("-$i months"));
                $anggota_baru_labels[] = date('M Y', strtotime("-$i months"));
                $anggota_baru_data[] = $this->db->table('anggota')
                    ->where('deleted_at', null)
                    ->where("DATE_FORMAT(created_at, '%Y-%m')", $month)
                    ->countAllResults();
            }

            $transaksi_labels = [];
            $transaksi_data = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = date('Y-m-d', strtotime("-$i days"));
                $transaksi_labels[] = date('d M', strtotime("-$i days"));
                $transaksi_data[] = $this->db->table('peminjaman')
                    ->where('deleted_at', null)
                    ->where('DATE(tanggal_pengajuan)', $day)
                    ->countAllResults();
            }

            $charts = [
                'chart_labels' => $chart_labels,
                'chart_data' => $chart_data,
                'top_buku_labels' => array_column($top_buku, 'judul'),
                'top_buku_data' => array_column($top_buku, 'total'),
                'top_wishlist_labels' => array_column($top_wishlist, 'judul_buku'),
                'top_wishlist_data' => array_column($top_wishlist, 'total'),
                'top_anggota_labels' => array_column($top_anggota, 'nama'),
                'top_anggota_data' => array_column($top_anggota, 'total'),
                'denda_labels' => array_column($denda_stats, 'status'),
                'denda_data' => array_column($denda_stats, 'total'),
                'kategori_labels' => array_column($kategori_stats, 'nama'),
                'kategori_data' => array_column($kategori_stats, 'total'),
                'anggota_baru_labels' => $anggota_baru_labels,
                'anggota_baru_data' => $anggota_baru_data,
                'transaksi_labels' => $transaksi_labels,
                'transaksi_data' => $transaksi_data,
            ];

            $cache->save($cacheKeyChart, $charts, 600);
        }

        $data = array_merge($data, $charts);

        return $this->view('dashboard/index', $data);
    }
}
