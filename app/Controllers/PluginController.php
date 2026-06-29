<?php

namespace App\Controllers;

class PluginController extends BaseController
{
    public function index()
    {
        $pluginDir = APPPATH . 'Plugins';
        $plugins = [];

        if (is_dir($pluginDir)) {
            $dirs = glob($pluginDir . '/*', GLOB_ONLYDIR);
            foreach ($dirs as $dir) {
                $name = basename($dir);
                $configFile = $dir . '/config.json';
                $config = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : [];

                $plugins[] = [
                    'name' => $name,
                    'version' => $config['version'] ?? '1.0.0',
                    'description' => $config['description'] ?? '-',
                    'enabled' => file_exists($dir . '/.enabled'),
                    'path' => $dir,
                ];
            }
        }

        $data = ['title' => 'Plugin Manager', 'plugins' => $plugins];
        return $this->view('plugin/index', $data);
    }

    public function toggle($name)
    {
        $pluginDir = APPPATH . 'Plugins/' . $name;
        if (!is_dir($pluginDir)) {
            return redirect()->to('/plugin')->with('error', 'Plugin tidak ditemukan.');
        }

        $enabledFile = $pluginDir . '/.enabled';
        if (file_exists($enabledFile)) {
            unlink($enabledFile);
            $msg = "Plugin $name dinonaktifkan.";
        } else {
            file_put_contents($enabledFile, date('Y-m-d H:i:s'));
            $msg = "Plugin $name diaktifkan.";
        }

        $this->logActivity('Toggle plugin', 'plugin', $msg);
        return redirect()->to('/plugin')->with('success', $msg);
    }
}
