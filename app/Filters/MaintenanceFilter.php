<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MaintenanceFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $db = \Config\Database::connect();
        $setting = $db->table('pengaturan')->where('key', 'maintenance_mode')->get()->getRow();

        if ($setting && $setting->value === '1') {
            $user = session()->get('user');

            if (!$user || $user['role'] !== 'Admin') {
                $message = $db->table('pengaturan')->where('key', 'maintenance_message')->get()->getRow();
                $msg = $message->value ?? 'Sistem sedang dalam pemeliharaan. Silakan coba lagi nanti.';

                if ($request->isAJAX()) {
                    return service('response')->setJSON(['error' => $msg], 503);
                }

                return redirect()->to('/maintenance?msg=' . urlencode($msg));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
