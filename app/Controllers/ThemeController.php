<?php

namespace App\Controllers;

class ThemeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pilih Tema',
            'themes' => [
                ['id' => 'jaklitera', 'name' => 'Jaklitera (Default)', 'primary' => '#063a76', 'secondary' => '#f85e38'],
                ['id' => 'jaklitera-dark', 'name' => 'Jaklitera Dark', 'primary' => '#4a8eff', 'secondary' => '#ff7b54'],
                ['id' => 'forest', 'name' => 'Hutan', 'primary' => '#166534', 'secondary' => '#16a34a'],
                ['id' => 'ocean', 'name' => 'Samudra', 'primary' => '#1e40af', 'secondary' => '#3b82f6'],
                ['id' => 'sunset', 'name' => 'Senja', 'primary' => '#9a3412', 'secondary' => '#ea580c'],
                ['id' => 'royal', 'name' => 'Royal', 'primary' => '#581c87', 'secondary' => '#a855f7'],
            ],
        ];
        return $this->view('theme/index', $data);
    }
}
