<?php

namespace App\Controllers;

class OAuthController extends BaseController
{
    public function google()
    {
        $clientId = $this->db->table('pengaturan')->where('key', 'google_client_id')->get()->getRow();
        if (!$clientId || empty($clientId->value)) {
            return redirect()->to('/login')->with('error', 'OAuth belum dikonfigurasi.');
        }

        $redirectUri = base_url('oauth/google/callback');
        $url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $clientId->value,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'offline',
        ]);

        return redirect()->to($url);
    }

    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        if (!$code) {
            return redirect()->to('/login')->with('error', 'OAuth gagal.');
        }

        $clientId = $this->db->table('pengaturan')->where('key', 'google_client_id')->get()->getRow();
        $clientSecret = $this->db->table('pengaturan')->where('key', 'google_client_secret')->get()->getRow();

        if (!$clientId || !$clientSecret) {
            return redirect()->to('/login')->with('error', 'OAuth belum dikonfigurasi.');
        }

        // Exchange code for token
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $code,
                'client_id' => $clientId->value,
                'client_secret' => $clientSecret->value,
                'redirect_uri' => base_url('oauth/google/callback'),
                'grant_type' => 'authorization_code',
            ]),
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $token = json_decode($response, true);

        if (!isset($token['access_token'])) {
            return redirect()->to('/login')->with('error', 'Gagal mendapatkan token OAuth.');
        }

        // Get user info
        $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token['access_token']],
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $googleUser = json_decode($response, true);

        if (!isset($googleUser['email'])) {
            return redirect()->to('/login')->with('error', 'Gagal mendapatkan data user.');
        }

        // Find or create user
        $user = $this->db->table('users')->where('email', $googleUser['email'])->where('deleted_at', null)->get()->getRow();

        if (!$user) {
            $this->db->table('users')->insert([
                'username' => explode('@', $googleUser['email'])[0],
                'email' => $googleUser['email'],
                'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT),
                'nama' => $googleUser['name'] ?? $googleUser['email'],
                'role' => 'Anggota',
                'active' => 1,
                'foto' => $googleUser['picture'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user = $this->db->table('users')->where('email', $googleUser['email'])->get()->getRow();
        }

        if (!$user->active) {
            return redirect()->to('/login')->with('error', 'Akun belum diaktifkan.');
        }

        // Login
        $this->session->set('is_login', true);
        $this->session->set('user', [
            'id' => $user->id, 'username' => $user->username, 'nama' => $user->nama,
            'email' => $user->email, 'role' => $user->role, 'nip' => $user->nip, 'foto' => $user->foto,
        ]);
        $this->session->set('last_activity_time', time());

        $this->db->table('users')->where('id', $user->id)->update(['last_login' => date('Y-m-d H:i:s')]);
        $this->logActivity('Login OAuth Google', 'auth', "User: {$user->username}");

        return redirect()->to('/dashboard');
    }
}
