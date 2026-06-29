<?php

namespace App\Controllers;

class SettingController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Pengaturan';
        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['settings'] = [];
        foreach ($settings as $s) {
            $data['settings'][$s['key']] = $s['value'];
        }
        return $this->view('pengaturan/index', $data);
    }

    public function update()
    {
        $rules = [
            'denda_per_hari' => 'permit_empty|numeric',
            'masa_pinjam' => 'permit_empty|numeric',
            'maks_pinjam' => 'permit_empty|numeric',
            'per_page' => 'permit_empty|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal. Periksa kembali input Anda.');
        }

        $fields = [
            'nama_aplikasi', 'tagline', 'kontak_email', 'kontak_telepon', 'kontak_alamat',
            'jam_buka', 'jam_tutup', 'hari_operasional',
            'denda_per_hari', 'masa_pinjam', 'maks_pinjam', 'per_page',
            'maintenance_message',
        ];

        foreach ($fields as $field) {
            $value = $this->request->getPost($field);
            if ($value !== null) {
                $existing = $this->db->table('pengaturan')->where('key', $field)->get()->getRow();
                if ($existing) {
                    $this->db->table('pengaturan')->where('key', $field)->update([
                        'value' => $value,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                } else {
                    $this->db->table('pengaturan')->insert([
                        'key' => $field,
                        'value' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        $maintenance = $this->request->getPost('maintenance_mode');
        $this->saveSetting('maintenance_mode', $maintenance ? '1' : '0');

        // Upload logo
        if ($_FILES['logo']['name']) {
            $file = $this->request->getFile('logo');
            if ($file->isValid() && !$file->hasMoved()) {
                $allowed = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
                $ext = $file->getExtension();
                if (!in_array(strtolower($ext), $allowed)) {
                    return redirect()->back()->with('error', 'Format logo harus JPG, PNG, SVG, atau WEBP.');
                }
                if ($file->getSizeByUnit('mb') > 2) {
                    return redirect()->back()->with('error', 'Ukuran logo maksimal 2MB.');
                }
                $newName = 'logo_' . time() . '.' . $ext;
                $file->move(FCPATH . 'uploads', $newName);
                $this->saveSetting('logo', 'uploads/' . $newName);
            }
        }

        // Upload favicon
        if ($_FILES['favicon']['name']) {
            $file = $this->request->getFile('favicon');
            if ($file->isValid() && !$file->hasMoved()) {
                $allowed = ['ico', 'png', 'svg'];
                $ext = $file->getExtension();
                if (!in_array(strtolower($ext), $allowed)) {
                    return redirect()->back()->with('error', 'Format favicon harus ICO, PNG, atau SVG.');
                }
                if ($file->getSizeByUnit('kb') > 500) {
                    return redirect()->back()->with('error', 'Ukuran favicon maksimal 500KB.');
                }
                $newName = 'favicon_' . time() . '.' . $ext;
                $file->move(FCPATH, $newName);
                $this->saveSetting('favicon', $newName);
            }
        }

        $this->logActivity('Mengupdate pengaturan', 'setting');
        return redirect()->to('/pengaturan')->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function saveSetting($key, $value)
    {
        $existing = $this->db->table('pengaturan')->where('key', $key)->get()->getRow();
        if ($existing) {
            $this->db->table('pengaturan')->where('key', $key)->update([
                'value' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->db->table('pengaturan')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
