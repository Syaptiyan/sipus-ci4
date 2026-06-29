<?php

namespace App\Controllers;

class PageController extends BaseController
{
    public function tentang()
    {
        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['pengaturan'] = [];
        foreach ($settings as $s) {
            $data['pengaturan'][$s['key']] = $s['value'];
        }
        $data['title'] = 'Tentang Aplikasi';
        return $this->view('page/tentang', $data);
    }

    public function changelog()
    {
        $data['title'] = 'Changelog';
        $data['changelog'] = file_exists(FCPATH . '../CHANGELOG.md') ? file_get_contents(FCPATH . '../CHANGELOG.md') : 'Changelog tidak ditemukan.';
        return $this->view('page/changelog', $data);
    }

    public function bantuan()
    {
        $data['title'] = 'Bantuan & FAQ';
        return $this->view('page/bantuan', $data);
    }

    public function apiDocs()
    {
        $settings = $this->db->table('pengaturan')->where('key', 'api_token')->get()->getRow();
        $data['title'] = 'API Documentation';
        $data['api_token'] = $settings->value ?? '-';
        return $this->view('page/api-docs', $data);
    }
}
