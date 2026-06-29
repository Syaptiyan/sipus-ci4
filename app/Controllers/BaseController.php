<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $helpers = ['sipus', 'form', 'url', 'text'];
    protected $session;
    protected $db;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = service('session');
        $this->db = \Config\Database::connect();

        $userId = $this->session->get('user')['id'] ?? null;
        if ($userId) {
            // Session timeout check (30 menit default)
            $lastActivity = $this->session->get('last_activity_time');
            $timeout = 1800; // 30 menit dalam detik

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                $this->session->destroy();
                return redirect()->to('/login')->with('error', 'Session expired. Silakan login kembali.');
            }

            $this->session->set('last_activity_time', time());

            $this->db->table('users')
                ->where('id', $userId)
                ->update(['last_activity' => date('Y-m-d H:i:s')]);
        }
    }

    protected function view($name, $data = [])
    {
        $data['session'] = $this->session;
        $data['user']    = $this->session->get('user');

        $settings = $this->db->table('pengaturan')->get()->getResultArray();
        $data['app_settings'] = [];
        foreach ($settings as $s) {
            $data['app_settings'][$s['key']] = $s['value'];
        }

        return view($name, $data);
    }

    protected function logActivity($aktivitas, $tipe = null, $keterangan = null)
    {
        $this->db->table('log_aktivitas')->insert([
            'id_user'    => $this->session->get('user')['id'] ?? null,
            'aktivitas'  => $aktivitas,
            'tipe'       => $tipe,
            'keterangan' => $keterangan,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    protected function getPerPage()
    {
        $setting = $this->db->table('pengaturan')->where('key', 'per_page')->get()->getRow();
        return $setting ? (int)$setting->value : 10;
    }

    protected function createNotifikasi($idUser, $judul, $pesan, $type = 'info')
    {
        $this->db->table('notifikasi')->insert([
            'id_user'    => $idUser,
            'judul'      => $judul,
            'pesan'      => $pesan,
            'type'       => $type,
            'read'       => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    protected function isRateLimited($ip, $maxAttempts = 5, $windowMinutes = 15)
    {
        $window = date('Y-m-d H:i:s', strtotime("-$windowMinutes minutes"));
        $attempts = $this->db->table('login_history')
            ->where('ip_address', $ip)
            ->where('status', 'failed')
            ->where('created_at >=', $window)
            ->countAllResults();
        return $attempts >= $maxAttempts;
    }

    protected function getRemainingAttempts($ip, $maxAttempts = 5, $windowMinutes = 15)
    {
        $window = date('Y-m-d H:i:s', strtotime("-$windowMinutes minutes"));
        $attempts = $this->db->table('login_history')
            ->where('ip_address', $ip)
            ->where('status', 'failed')
            ->where('created_at >=', $window)
            ->countAllResults();
        return max(0, $maxAttempts - $attempts);
    }
}
