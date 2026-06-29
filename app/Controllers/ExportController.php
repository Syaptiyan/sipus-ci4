<?php

namespace App\Controllers;

class ExportController extends BaseController
{
    public function buku()
    {
        $buku = $this->db->table('buku')
            ->select('buku.isbn, buku.judul, kategori.nama as kategori, penulis.nama as penulis, penerbit.nama as penerbit, rak.nama as rak, buku.tahun_terbit, buku.jumlah_halaman, buku.stok, buku.stok_tersedia')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
            ->join('rak', 'rak.id = buku.id_rak', 'left')
            ->where('buku.deleted_at', null)
            ->orderBy('buku.judul', 'ASC')
            ->get()
            ->getResultArray();

        $filename = 'data_buku_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['ISBN', 'Judul', 'Kategori', 'Penulis', 'Penerbit', 'Rak', 'Tahun', 'Halaman', 'Stok', 'Tersedia']);
        foreach ($buku as $b) {
            fputcsv($output, array_values($b));
        }
        fclose($output);
        exit;
    }

    public function anggota()
    {
        $anggota = $this->db->table('anggota')
            ->select('kode_anggota, nama, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat, telp, email')
            ->where('deleted_at', null)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        $filename = 'data_anggota_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Kode', 'Nama', 'L/P', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Telepon', 'Email']);
        foreach ($anggota as $a) {
            fputcsv($output, array_values($a));
        }
        fclose($output);
        exit;
    }

    public function peminjaman()
    {
        $peminjaman = $this->db->table('peminjaman')
            ->select('peminjaman.kode_peminjaman, anggota.nama as anggota, peminjaman.tanggal_pengajuan, peminjaman.tanggal_pinjam, peminjaman.tanggal_jatuh_tempo, peminjaman.tanggal_dikembalikan, peminjaman.status')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('peminjaman.deleted_at', null)
            ->orderBy('peminjaman.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'data_peminjaman_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Kode', 'Anggota', 'Tgl Pengajuan', 'Tgl Pinjam', 'Jatuh Tempo', 'Tgl Kembali', 'Status']);
        foreach ($peminjaman as $p) {
            fputcsv($output, array_values($p));
        }
        fclose($output);
        exit;
    }

    public function denda()
    {
        $denda = $this->db->table('denda')
            ->select('peminjaman.kode_peminjaman, anggota.nama as anggota, denda.jumlah, denda.status, denda.tanggal_bayar')
            ->join('peminjaman', 'peminjaman.id = denda.id_peminjaman')
            ->join('anggota', 'anggota.id = peminjaman.id_anggota')
            ->where('denda.deleted_at', null)
            ->orderBy('denda.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'data_denda_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Kode Peminjaman', 'Anggota', 'Jumlah', 'Status', 'Tgl Bayar']);
        foreach ($denda as $d) {
            fputcsv($output, array_values($d));
        }
        fclose($output);
        exit;
    }
}
