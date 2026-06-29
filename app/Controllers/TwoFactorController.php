<?php

namespace App\Controllers;

class TwoFactorController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $userData = $this->db->table('users')->where('id', $user['id'])->get()->getRow();

        $data = [
            'title' => 'Two-Factor Authentication',
            'enabled' => !empty($userData->two_factor_secret),
        ];
        return $this->view('twofactor/index', $data);
    }

    public function enable()
    {
        $user = session()->get('user');
        $secret = $this->generateSecret();
        $this->db->table('users')->where('id', $user['id'])->update([
            'two_factor_secret' => $secret,
        ]);

        $data = [
            'title' => 'Setup 2FA',
            'secret' => $secret,
            'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode('otpauth://totp/SIPUS:' . $user['email'] . '?secret=' . $secret . '&issuer=SIPUS'),
        ];
        return $this->view('twofactor/setup', $data);
    }

    public function verify()
    {
        $code = $this->request->getPost('code');
        $user = session()->get('user');
        $userData = $this->db->table('users')->where('id', $user['id'])->get()->getRow();

        if ($this->verifyCode($userData->two_factor_secret, $code)) {
            $this->session->set('2fa_verified', true);
            return redirect()->to('/dashboard')->with('success', '2FA berhasil diverifikasi.');
        }

        return redirect()->back()->with('error', 'Kode 2FA salah.');
    }

    public function disable()
    {
        $user = session()->get('user');
        $this->db->table('users')->where('id', $user['id'])->update([
            'two_factor_secret' => null,
        ]);
        $this->session->remove('2fa_verified');
        return redirect()->to('/profil')->with('success', '2FA berhasil dinonaktifkan.');
    }

    private function generateSecret()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < 16; $i++) {
            $secret .= $chars[random_int(0, 31)];
        }
        return $secret;
    }

    private function verifyCode($secret, $code)
    {
        $time = floor(time() / 30);
        for ($i = -1; $i <= 1; $i++) {
            if ($this->generateCode($secret, $time + $i) === $code) {
                return true;
            }
        }
        return false;
    }

    private function generateCode($secret, $time)
    {
        $base32 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper($secret);
        $binary = '';
        for ($i = 0; $i < strlen($secret); $i++) {
            $val = strpos($base32, $secret[$i]);
            $binary .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
        }
        $bytes = [];
        for ($i = 0; $i < strlen($binary); $i += 8) {
            $bytes[] = bindec(substr($binary, $i, 8));
        }
        $time = pack('N*', 0, $time);
        $hmac = hash_hmac('sha1', $time, implode(array_map('chr', $bytes)), true);
        $offset = ord(substr($hmac, -1)) & 0x0F;
        $code = (unpack('N', substr($hmac, $offset, 4))[1] & 0x7FFFFFFF) % 1000000;
        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }
}
