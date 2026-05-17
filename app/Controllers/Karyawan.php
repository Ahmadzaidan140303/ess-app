<?php

namespace App\Controllers;

class Karyawan extends BaseController
{
    public function index()
    {
        // Pengaman: Jika user belum login atau bkn karyawan, tendang kembali ke halaman login
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Siapkan data dari session untuk dilempar ke View Dashboard
        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => session()->get('foto'),
        ];

        return view('karyawan/dashboard', $data);
    }
}
