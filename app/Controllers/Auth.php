<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KaryawanProfilModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $profilModel;

    public function __construct()
    {
        // Load model dan session agar siap digunakan
        $this->userModel = new UserModel();
        $this->profilModel = new KaryawanProfilModel();
    }

    public function index()
    {
        // Jika user sudah login, langsung lempar ke halaman dashboard masing-masing
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('role') == 'admin' ? '/admin/dashboard' : '/karyawan/dashboard');
        }

        return view('auth/login');
    }

    public function login_process()
    {
        $nip = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

        // 1. Cari user berdasarkan NIP
        $user = $this->userModel->where('nip', $nip)->first();

        if ($user) {
            // 2. Jika user ditemukan, cek kecocokan password dengan bcrypt hash
            if (password_verify($password, $user['password'])) {

                // 3. Ambil data profil lengkap karyawan
                $profil = $this->profilModel->where('user_id', $user['id'])->first();

                // 4. Set data ke dalam Session aplikasi
                $sessionData = [
                    'user_id'      => $user['id'],
                    'nip'          => $user['nip'],
                    'email'        => $user['email'],
                    'role'         => $user['role'],
                    'nama_lengkap' => $profil ? $profil['nama_lengkap'] : 'User',
                    'jabatan'      => $profil ? $profil['jabatan'] : '',
                    'foto'         => $profil ? $profil['foto'] : 'default.png',
                    'isLoggedIn'   => true
                ];
                session()->set($sessionData);

                // 5. Redirect sesuai dengan role pengguna
                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang Admin!');
                } else {
                    return redirect()->to('/karyawan/dashboard')->with('success', 'Selamat datang kembali!');
                }
            } else {
                // Password salah
                return redirect()->back()->with('error', 'Password yang Anda masukkan salah.');
            }
        } else {
            // NIP tidak ditemukan
            return redirect()->back()->with('error', 'Nomor Induk Pegawai (NIP) tidak terdaftar.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
