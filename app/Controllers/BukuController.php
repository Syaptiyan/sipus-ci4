<?php

namespace App\Controllers;

class BukuController extends BaseController
{
    public function index()
    {
        $pager = service('pager');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->getPerPage();

        $search = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');
        $penerbit_filter = $this->request->getGet('penerbit');
        $rak_filter = $this->request->getGet('rak');
        $tahun_dari = $this->request->getGet('tahun_dari');
        $tahun_sampai = $this->request->getGet('tahun_sampai');
        $tersedia = $this->request->getGet('tersedia');
        $rating_min = $this->request->getGet('rating_min');
        $sort = $this->request->getGet('sort');

        $builder = $this->db->table('buku')
            ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis, penerbit.nama as nama_penerbit, rak.nama as nama_rak,
                      COALESCE(AVG(review_buku.rating), 0) as avg_rating, COUNT(review_buku.id) as total_review')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
            ->join('rak', 'rak.id = buku.id_rak', 'left')
            ->join('review_buku', 'review_buku.id_buku = buku.id AND review_buku.deleted_at IS NULL', 'left')
            ->where('buku.deleted_at', null)
            ->groupBy('buku.id');

        if ($search) {
            $builder->groupStart()
                ->like('buku.judul', $search)
                ->orLike('buku.isbn', $search)
                ->orLike('penulis.nama', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        if ($penerbit_filter) {
            $builder->where('buku.id_penerbit', $penerbit_filter);
        }

        if ($rak_filter) {
            $builder->where('buku.id_rak', $rak_filter);
        }

        if ($tahun_dari) {
            $builder->where('buku.tahun_terbit >=', $tahun_dari);
        }

        if ($tahun_sampai) {
            $builder->where('buku.tahun_terbit <=', $tahun_sampai);
        }

        if ($tersedia === 'tersedia') {
            $builder->where('buku.stok_tersedia >', 0);
        } elseif ($tersedia === 'habis') {
            $builder->where('buku.stok_tersedia', 0);
        }

        if ($rating_min) {
            $builder->having('avg_rating >=', (float)$rating_min);
        }

        switch ($sort) {
            case 'terlama':
                $builder->orderBy('buku.created_at', 'ASC');
                break;
            case 'judul_az':
                $builder->orderBy('buku.judul', 'ASC');
                break;
            case 'judul_za':
                $builder->orderBy('buku.judul', 'DESC');
                break;
            case 'tahun_baru':
                $builder->orderBy('buku.tahun_terbit', 'DESC');
                break;
            case 'tahun_lama':
                $builder->orderBy('buku.tahun_terbit', 'ASC');
                break;
            case 'populer':
                $builder->orderBy('(SELECT COUNT(*) FROM detail_peminjaman dp JOIN peminjaman p ON p.id = dp.id_peminjaman WHERE dp.id_buku = buku.id AND p.deleted_at IS NULL)', 'DESC');
                break;
            default:
                $builder->orderBy('buku.created_at', 'DESC');
                break;
        }

        $total = $builder->countAllResults(false);

        $data = [
            'title' => 'Data Buku',
            'buku' => $builder->get($perPage, ($page - 1) * $perPage)->getResultArray(),
            'kategori_list' => $this->db->table('kategori')->where('deleted_at', null)->get()->getResultArray(),
            'pager_links' => $pager->makeLinks($page, $perPage, $total),
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'search' => $search,
            'kategori_filter' => $kategori,
            'penerbit_filter' => $penerbit_filter,
            'rak_filter' => $rak_filter,
            'tahun_dari' => $tahun_dari,
            'tahun_sampai' => $tahun_sampai,
            'tersedia' => $tersedia,
            'rating_min' => $rating_min,
            'sort' => $sort,
            'penerbit_list' => $this->db->table('penerbit')->where('deleted_at', null)->get()->getResultArray(),
            'rak_list' => $this->db->table('rak')->where('deleted_at', null)->get()->getResultArray(),
        ];

        return $this->view('buku/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Buku',
            'kategori' => $this->db->table('kategori')->where('deleted_at', null)->get()->getResultArray(),
            'penulis' => $this->db->table('penulis')->where('deleted_at', null)->get()->getResultArray(),
            'penerbit' => $this->db->table('penerbit')->where('deleted_at', null)->get()->getResultArray(),
            'rak' => $this->db->table('rak')->where('deleted_at', null)->get()->getResultArray(),
        ];

        return $this->view('buku/create', $data);
    }

    public function store()
    {
        $rules = [
            'judul' => 'required',
            'isbn' => 'permit_empty',
            'id_kategori' => 'permit_empty|numeric',
            'id_penulis' => 'permit_empty|numeric',
            'id_penerbit' => 'permit_empty|numeric',
            'id_rak' => 'permit_empty|numeric',
            'stok' => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        }

        $slug = $this->makeUniqueSlug($this->request->getPost('judul'));

        $data = [
            'isbn' => $this->request->getPost('isbn'),
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_penulis' => $this->request->getPost('id_penulis'),
            'id_penerbit' => $this->request->getPost('id_penerbit'),
            'id_rak' => $this->request->getPost('id_rak'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah_halaman' => $this->request->getPost('jumlah_halaman'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'stok' => $this->request->getPost('stok'),
            'stok_tersedia' => $this->request->getPost('stok'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        try {
            $this->db->table('buku')->insert($data);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
        $this->logActivity('Menambah buku', 'buku', 'Judul: ' . $data['judul']);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama as nama_kategori, penulis.nama as nama_penulis, penerbit.nama as nama_penerbit, rak.nama as nama_rak')
            ->join('kategori', 'kategori.id = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id = buku.id_penerbit', 'left')
            ->join('rak', 'rak.id = buku.id_rak', 'left')
            ->where('buku.id', $id)
            ->where('buku.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $data = ['title' => 'Detail Buku', 'buku' => $buku];

        $data['reviews'] = $this->db->table('review_buku')
            ->select('review_buku.*, anggota.nama as nama_anggota')
            ->join('anggota', 'anggota.id = review_buku.id_anggota')
            ->where('review_buku.id_buku', $id)
            ->where('review_buku.deleted_at', null)
            ->orderBy('review_buku.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $avg = $this->db->table('review_buku')
            ->selectAvg('rating')
            ->where('id_buku', $id)
            ->where('deleted_at', null)
            ->get()
            ->getRow();
        $data['avg_rating'] = round($avg->rating ?? 0, 1);
        $data['total_review'] = count($data['reviews']);
        $data['sudah_review'] = 0;

        $user = session()->get('user');
        $data['is_favorited'] = false;
        if ($user['role'] === 'Anggota') {
            $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
            if ($anggota) {
                $data['sudah_review'] = $this->db->table('review_buku')
                    ->where('id_buku', $id)
                    ->where('id_anggota', $anggota->id)
                    ->where('deleted_at', null)
                    ->countAllResults();
                $data['is_favorited'] = $this->db->table('favorit_buku')
                    ->where('id_buku', $id)
                    ->where('id_anggota', $anggota->id)
                    ->where('deleted_at', null)
                    ->countAllResults() > 0;
            }
        }

        return $this->view('buku/show', $data);
    }

    public function submitReview($id)
    {
        $user = session()->get('user');
        if ($user['role'] !== 'Anggota') {
            return redirect()->back()->with('error', 'Hanya anggota yang bisa memberikan review.');
        }

        $anggota = $this->db->table('anggota')->where('id_user', $user['id'])->get()->getRow();
        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        $rating = (int) $this->request->getPost('rating');
        $review = $this->request->getPost('review');

        if ($rating < 1 || $rating > 5) {
            return redirect()->back()->with('error', 'Rating harus 1-5.');
        }

        $existing = $this->db->table('review_buku')
            ->where('id_buku', $id)
            ->where('id_anggota', $anggota->id)
            ->where('deleted_at', null)
            ->countAllResults();

        if ($existing > 0) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk buku ini.');
        }

        $this->db->table('review_buku')->insert([
            'id_buku'    => $id,
            'id_anggota' => $anggota->id,
            'rating'     => $rating,
            'review'     => $review,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/buku/' . $id)->with('success', 'Review berhasil dikirim. Terima kasih!');
    }

    public function edit($id)
    {
        $buku = $this->db->table('buku')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Buku',
            'buku' => $buku,
            'kategori' => $this->db->table('kategori')->where('deleted_at', null)->get()->getResultArray(),
            'penulis' => $this->db->table('penulis')->where('deleted_at', null)->get()->getResultArray(),
            'penerbit' => $this->db->table('penerbit')->where('deleted_at', null)->get()->getResultArray(),
            'rak' => $this->db->table('rak')->where('deleted_at', null)->get()->getResultArray(),
        ];

        return $this->view('buku/edit', $data);
    }

    public function update($id)
    {
        $buku = $this->db->table('buku')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $rules = [
            'judul' => 'required',
            'isbn' => 'permit_empty',
            'stok' => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        }

        $slug = $this->makeUniqueSlug($this->request->getPost('judul'), $id);

        $data = [
            'isbn' => $this->request->getPost('isbn'),
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'id_kategori' => $this->request->getPost('id_kategori'),
            'id_penulis' => $this->request->getPost('id_penulis'),
            'id_penerbit' => $this->request->getPost('id_penerbit'),
            'id_rak' => $this->request->getPost('id_rak'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah_halaman' => $this->request->getPost('jumlah_halaman'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'stok' => $this->request->getPost('stok'),
            'stok_tersedia' => $this->request->getPost('stok') - ($buku['stok'] - $buku['stok_tersedia']),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try {
            $this->db->table('buku')->update($data, ['id' => $id]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
        $this->logActivity('Mengubah buku', 'buku', 'Judul: ' . $data['judul']);

        return redirect()->to('/buku')->with('success', 'Buku berhasil diubah.');
    }

    public function delete($id)
    {
        $buku = $this->db->table('buku')->where('id', $id)->where('deleted_at', null)->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $this->db->table('buku')->update(['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]);
        $this->logActivity('Menghapus buku', 'buku', 'Judul: ' . $buku['judul']);

        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus.');
    }

    public function restore($id)
    {
        $buku = $this->db->table('buku')->where('id', $id)->where('deleted_at IS NOT NULL')->get()->getRowArray();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }

        $this->db->table('buku')->update(['deleted_at' => null], ['id' => $id]);
        $this->logActivity('Mengembalikan buku', 'buku', 'Judul: ' . $buku['judul']);

        return redirect()->to('/buku')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function import()
    {
        $isbn = $this->request->getPost('isbn');

        if (!$isbn) {
            $response = ['success' => false, 'message' => 'ISBN harus diisi.'];
            if ($this->request->isAJAX()) {
                return $this->response->setJSON($response);
            }
            return redirect()->back()->with('error', $response['message']);
        }

        $existing = $this->db->table('buku')->where('isbn', $isbn)->where('deleted_at', null)->get()->getRowArray();
        if ($existing) {
            $response = ['success' => false, 'message' => 'Buku dengan ISBN ini sudah ada.'];
            if ($this->request->isAJAX()) {
                return $this->response->setJSON($response);
            }
            return redirect()->back()->with('error', $response['message']);
        }

        $apiUrl = "https://openlibrary.org/isbn/{$isbn}.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SIPUS-CI4/1.0');
        $apiResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$apiResponse) {
            $response = ['success' => false, 'message' => 'Gagal mengambil data dari OpenLibrary. Periksa ISBN.'];
            if ($this->request->isAJAX()) {
                return $this->response->setJSON($response);
            }
            return redirect()->back()->with('error', $response['message']);
        }

        $bookData = json_decode($apiResponse, true);

        $title = $bookData['title'] ?? 'Unknown Title';

        $publisherName = null;
        if (!empty($bookData['publishers'])) {
            $publisherName = is_array($bookData['publishers']) ? $bookData['publishers'][0] : $bookData['publishers'];
        }

        $publishDate = $bookData['publish_date'] ?? null;
        $pages = $bookData['number_of_pages'] ?? null;
        $coverId = $bookData['covers'][0] ?? null;

        $authorNames = [];
        if (!empty($bookData['authors'])) {
            foreach ($bookData['authors'] as $authorRef) {
                $authorKey = $authorRef['key'] ?? null;
                if ($authorKey) {
                    $authorUrl = "https://openlibrary.org{$authorKey}.json";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $authorUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'SIPUS-CI4/1.0');
                    $authorResponse = curl_exec($ch);
                    curl_close($ch);

                    if ($authorResponse) {
                        $authorData = json_decode($authorResponse, true);
                        if (!empty($authorData['name'])) {
                            $authorNames[] = $authorData['name'];
                        }
                    }
                }
            }
        }

        $authorName = !empty($authorNames) ? implode(', ', $authorNames) : 'Unknown Author';

        $kategori = $this->db->table('kategori')->where('nama', 'Unmapped')->where('deleted_at', null)->get()->getRowArray();
        if (!$kategori) {
            $this->db->table('kategori')->insert([
                'nama' => 'Unmapped',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $idKategori = $this->db->insertID();
        } else {
            $idKategori = $kategori['id'];
        }

        $existingPenulis = $this->db->table('penulis')->where('nama', $authorName)->where('deleted_at', null)->get()->getRowArray();
        if ($existingPenulis) {
            $idPenulis = $existingPenulis['id'];
        } else {
            $this->db->table('penulis')->insert([
                'nama' => $authorName,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $idPenulis = $this->db->insertID();
        }

        $idPenerbit = null;
        if ($publisherName) {
            $existingPenerbit = $this->db->table('penerbit')->where('nama', $publisherName)->where('deleted_at', null)->get()->getRowArray();
            if ($existingPenerbit) {
                $idPenerbit = $existingPenerbit['id'];
            } else {
                $this->db->table('penerbit')->insert([
                    'nama' => $publisherName,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $idPenerbit = $this->db->insertID();
            }
        }

        $tahunTerbit = null;
        if ($publishDate) {
            if (preg_match('/\b(\d{4})\b/', $publishDate, $matches)) {
                $tahunTerbit = $matches[1];
            }
        }

        $coverUrl = null;
        if ($coverId) {
            $coverUrl = "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg";
        }

        $slug = $this->makeUniqueSlug($title);

        $this->db->table('buku')->insert([
            'isbn' => $isbn,
            'judul' => $title,
            'slug' => $slug,
            'id_kategori' => $idKategori,
            'id_penulis' => $idPenulis,
            'id_penerbit' => $idPenerbit,
            'tahun_terbit' => $tahunTerbit,
            'jumlah_halaman' => $pages,
            'cover' => $coverUrl,
            'stok' => 1,
            'stok_tersedia' => 1,
            'deskripsi' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Import buku dari OpenLibrary', 'buku', 'ISBN: ' . $isbn . ', Judul: ' . $title);

        $response = ['success' => true, 'message' => "Buku \"{$title}\" berhasil diimport dari OpenLibrary."];
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($response);
        }

        return redirect()->to('/buku')->with('success', $response['message']);
    }

    private function makeUniqueSlug($title, $ignoreId = null)
    {
        $slug = url_title($title, '-', true);
        $builder = $this->db->table('buku')->where('slug', $slug)->where('deleted_at', null);
        if ($ignoreId) {
            $builder->where('id !=', $ignoreId);
        }
        if ($builder->countAllResults() > 0) {
            $i = 1;
            while (true) {
                $newSlug = $slug . '-' . $i;
                $check = $this->db->table('buku')->where('slug', $newSlug)->where('deleted_at', null);
                if ($ignoreId) {
                    $check->where('id !=', $ignoreId);
                }
                if ($check->countAllResults() === 0) {
                    return $newSlug;
                }
                $i++;
            }
        }
        return $slug;
    }
}
