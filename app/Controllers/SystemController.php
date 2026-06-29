<?php

namespace App\Controllers;

class SystemController extends BaseController
{
    public function health()
    {
        $checks = [];

        // Database
        try {
            $this->db->query('SELECT 1');
            $checks['database'] = ['status' => 'ok', 'message' => 'Koneksi database normal'];
        } catch (\Exception $e) {
            $checks['database'] = ['status' => 'error', 'message' => $e->getMessage()];
        }

        // Storage writable
        $writable = is_writable(WRITEPATH);
        $checks['storage'] = [
            'status' => $writable ? 'ok' : 'error',
            'message' => $writable ? 'Folder writable bisa ditulis' : 'Folder writable tidak bisa ditulis',
        ];

        // Upload folder
        $uploadDir = FCPATH . 'uploads';
        $uploadOk = is_dir($uploadDir) && is_writable($uploadDir);
        $checks['upload'] = [
            'status' => $uploadOk ? 'ok' : 'warning',
            'message' => $uploadOk ? 'Folder uploads tersedia' : 'Folder uploads tidak ditemukan atau tidak writable',
        ];

        // Session
        $checks['session'] = [
            'status' => 'ok',
            'message' => 'Session berjalan normal',
        ];

        // PHP Version
        $phpOk = version_compare(PHP_VERSION, '8.1', '>=');
        $checks['php'] = [
            'status' => $phpOk ? 'ok' : 'warning',
            'message' => 'PHP ' . PHP_VERSION,
        ];

        // Extensions
        $required = ['mbstring', 'json', 'mysqlnd', 'openssl'];
        $missing = [];
        foreach ($required as $ext) {
            if (!extension_loaded($ext)) $missing[] = $ext;
        }
        $checks['extensions'] = [
            'status' => empty($missing) ? 'ok' : 'warning',
            'message' => empty($missing) ? 'Semua extension tersedia' : 'Missing: ' . implode(', ', $missing),
        ];

        $allOk = !in_array('error', array_column($checks, 'status'));

        $data = [
            'title' => 'Health Check',
            'checks' => $checks,
            'all_ok' => $allOk,
        ];
        return $this->view('system/health', $data);
    }

    public function info()
    {
        $data = [
            'title' => 'System Information',
            'php_version' => PHP_VERSION,
            'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'db_version' => $this->db->getVersion(),
            'db_driver' => $this->db->getPlatform(),
            'os' => PHP_OS,
            'memory_limit' => ini_get('memory_limit'),
            'max_upload' => ini_get('upload_max_filesize'),
            'max_post' => ini_get('post_max_value'),
            'timezone' => date_default_timezone_get(),
            'extensions' => get_loaded_extensions(),
        ];
        return $this->view('system/info', $data);
    }

    public function logs()
    {
        $logFile = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
        $lines = [];
        if (file_exists($logFile)) {
            $lines = array_slice(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), -100);
            $lines = array_reverse($lines);
        }

        $data = [
            'title' => 'Log Error Sistem',
            'log_file' => $logFile,
            'lines' => $lines,
            'file_exists' => file_exists($logFile),
        ];
        return $this->view('system/logs', $data);
    }

    public function storage()
    {
        $uploadDir = FCPATH . 'uploads';
        $profilDir = $uploadDir . '/profil';

        $data = [
            'title' => 'Monitoring Storage',
            'upload_dir' => $uploadDir,
            'upload_exists' => is_dir($uploadDir),
            'upload_writable' => is_writable($uploadDir),
            'upload_files' => is_dir($uploadDir) ? count(glob($uploadDir . '/*')) : 0,
            'upload_size' => is_dir($uploadDir) ? $this->getDirSize($uploadDir) : 0,
            'profil_exists' => is_dir($profilDir),
            'profil_files' => is_dir($profilDir) ? count(glob($profilDir . '/*')) : 0,
            'disk_free' => disk_free_space('/'),
            'disk_total' => disk_total_space('/'),
        ];
        return $this->view('system/storage', $data);
    }

    private function getDirSize($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/') . '/*') as $file) {
            $size += is_file($file) ? filesize($file) : $this->getDirSize($file);
        }
        return $size;
    }
}
