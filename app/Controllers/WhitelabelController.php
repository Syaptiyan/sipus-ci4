<?php

namespace App\Controllers;

class WhitelabelController extends BaseController
{
    public function index()
    {
        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['pengaturan'] = [];
        foreach ($settings as $s) {
            $data['pengaturan'][$s['key']] = $s['value'];
        }
        $data['title'] = 'White Label Preview';
        return $this->view('whitelabel/index', $data);
    }
}
