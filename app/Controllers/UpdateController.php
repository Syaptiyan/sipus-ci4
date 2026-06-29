<?php

namespace App\Controllers;

class UpdateController extends BaseController
{
    public function index()
    {
        $currentVersion = $this->db->table('pengaturan')->where('key', 'app_version')->get()->getRow();
        $data = [
            'title' => 'Update Sistem',
            'current_version' => $currentVersion->value ?? '3.0',
            'changelog' => file_exists(FCPATH . '../CHANGELOG.md') ? file_get_contents(FCPATH . '../CHANGELOG.md') : '',
        ];
        return $this->view('update/index', $data);
    }

    public function check()
    {
        $currentVersion = $this->db->table('pengaturan')->where('key', 'app_version')->get()->getRow();
        $current = $currentVersion->value ?? '3.0';

        // Simulasi cek update dari server
        $latestVersion = '3.1';
        $updateAvailable = version_compare($latestVersion, $current, '>');

        $data = [
            'title' => 'Cek Update',
            'current' => $current,
            'latest' => $latestVersion,
            'available' => $updateAvailable,
        ];
        return $this->view('update/check', $data);
    }

    public function apply()
    {
        $this->db->table('pengaturan')->where('key', 'app_version')->update([
            'value' => '3.1',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Update sistem', 'update', 'v3.0 → v3.1');
        return redirect()->to('/update')->with('success', 'Sistem berhasil diupdate ke v3.1');
    }
}
