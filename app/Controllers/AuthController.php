<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function login()
    {
        if ($this->session->get('is_login')) {
            return redirect()->to('/dashboard');
        }

        $ip = $this->request->getIPAddress();
        $data['remaining_attempts'] = $this->getRemainingAttempts($ip);
        $data['is_blocked'] = $this->isRateLimited($ip);
        $data['captcha'] = $this->generateCaptcha();

        return $this->view('auth/login', $data);
    }

    public function authenticate()
    {
        $ip = $this->request->getIPAddress();

        if ($this->isRateLimited($ip)) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.');
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $captcha_answer = (int) $this->request->getPost('captcha_answer');
        $captcha_expected = (int) $this->session->get('captcha_answer');

        if (!$login || !$password) {
            return redirect()->back()->with('error', 'Username/email dan password harus diisi.');
        }

        if ($captcha_answer !== $captcha_expected) {
            return redirect()->back()->with('error', 'Jawaban CAPTCHA salah.')->with('captcha', $this->generateCaptcha());
        }

        $user = $this->db->table('users')
            ->groupStart()
                ->where('username', $login)
                ->orWhere('email', $login)
            ->groupEnd()
            ->where('active', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->logActivity('Login gagal', 'auth', "Login: $login");
            $this->db->table('login_history')->insert([
                'id_user'    => $user['id'] ?? 0,
                'ip_address' => $ip,
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'status'     => 'failed',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $remaining = $this->getRemainingAttempts($ip) - 1;
            $msg = 'Username/email atau password salah.';
            if ($remaining <= 2 && $remaining > 0) {
                $msg .= " Sisa $remaining percobaan.";
            } elseif ($remaining <= 0) {
                $msg = 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.';
            }

            return redirect()->back()->with('error', $msg)->with('captcha', $this->generateCaptcha());
        }

        if (!$user['active']) {
            return redirect()->back()->with('error', 'Akun belum diaktifkan. Hubungi admin.')->with('captcha', $this->generateCaptcha());
        }

        $this->db->table('users')->update(['last_login' => date('Y-m-d H:i:s')], ['id' => $user['id']]);

        $this->db->table('login_history')->insert([
            'id_user'    => $user['id'],
            'ip_address' => $ip,
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'status'     => 'success',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $sessionData = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'nama'     => $user['nama'],
            'email'    => $user['email'],
            'role'     => $user['role'],
            'nip'      => $user['nip'],
            'foto'     => $user['foto'],
        ];

        $this->session->set('is_login', true);
        $this->session->set('user', $sessionData);
        $this->session->set('last_activity_time', time());

        $this->logActivity('Login berhasil', 'auth', "User: {$user['username']}");
        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $this->logActivity('Logout', 'auth');
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }

    public function register()
    {
        if ($this->session->get('is_login')) {
            return redirect()->to('/dashboard');
        }

        $data['captcha'] = $this->generateCaptcha();
        return $this->view('auth/register', $data);
    }

    public function registerStore()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('password_confirm');
        $nama = $this->request->getPost('nama');
        $captcha_answer = (int) $this->request->getPost('captcha_answer');
        $captcha_expected = (int) $this->session->get('captcha_answer');

        if (!$username || !$email || !$password || !$nama) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if ($captcha_answer !== $captcha_expected) {
            return redirect()->back()->with('error', 'Jawaban CAPTCHA salah.')->with('captcha', $this->generateCaptcha());
        }

        if ($password !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.')->with('captcha', $this->generateCaptcha());
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.')->with('captcha', $this->generateCaptcha());
        }

        $exists = $this->db->table('users')
            ->groupStart()
                ->where('username', $username)
                ->orWhere('email', $email)
            ->groupEnd()
            ->where('deleted_at', null)
            ->countAllResults();

        if ($exists > 0) {
            return redirect()->back()->with('error', 'Username atau email sudah terdaftar.')->with('captcha', $this->generateCaptcha());
        }

        $this->db->table('users')->insert([
            'username'  => $username,
            'email'     => $email,
            'password'  => password_hash($password, PASSWORD_BCRYPT),
            'nama'      => $nama,
            'role'      => 'Anggota',
            'active'    => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Registrasi anggota', 'auth', "Username: $username");
        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Akun Anda akan diaktifkan oleh admin.');
    }

    public function forgotPassword()
    {
        if ($this->session->get('is_login')) {
            return redirect()->to('/dashboard');
        }
        return $this->view('auth/forgot_password');
    }

    public function sendResetLink()
    {
        $email = $this->request->getPost('email');
        if (!$email) {
            return redirect()->back()->with('error', 'Email wajib diisi.');
        }

        $user = $this->db->table('users')->where('email', $email)->where('deleted_at', null)->get()->getRow();
        if (!$user) {
            return redirect()->back()->with('success', 'Jika email terdaftar, link reset akan dikirim.');
        }

        $token = bin2hex(random_bytes(32));
        $this->db->table('users')->where('id', $user->id)->update([
            'reset_token' => $token,
            'reset_token_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ]);

        $this->logActivity('Request reset password', 'auth', "Email: $email");
        return redirect()->to('/reset-password?token=' . $token)->with('success', 'Masukkan password baru Anda.');
    }

    public function resetPassword()
    {
        $token = $this->request->getGet('token');
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Token tidak valid.');
        }

        $user = $this->db->table('users')
            ->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah expired.');
        }

        $data = ['title' => 'Reset Password', 'token' => $token];
        return $this->view('auth/reset_password', $data);
    }

    public function resetPasswordStore()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('password_confirm');

        if (!$token || !$password) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if ($password !== $konfirmasi) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.');
        }

        $user = $this->db->table('users')
            ->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah expired.');
        }

        $this->db->table('users')->where('id', $user->id)->update([
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'reset_token' => null,
            'reset_token_expires' => null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logActivity('Reset password berhasil', 'auth', "User: {$user->username}");
        return redirect()->to('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }

    private function generateCaptcha()
    {
        $a = rand(1, 10);
        $b = rand(1, 10);
        $operators = ['+', '-'];
        $op = $operators[array_rand($operators)];

        if ($op === '-' && $a < $b) {
            [$a, $b] = [$b, $a];
        }

        $answer = $op === '+' ? $a + $b : $a - $b;
        $this->session->set('captcha_answer', $answer);

        return "$a $op $b = ?";
    }
}
