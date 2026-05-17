<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        // Proteksi Halaman: Pastikan sudah login dan perannya adalah admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Anda bukan Admin.');
        }

        $profilModel = new \App\Models\KaryawanProfilModel();
        $cutiModel   = new \App\Models\CutiModel();
        $suratModel  = new \App\Models\SuratDokumenModel();

        $data = [
            'nama_admin'     => session()->get('nama_lengkap'),
            'total_karyawan' => $profilModel->countAllResults(),
            // Memastikan pencarian status menggunakan 'pending' huruf kecil sesuai default store
            'cuti_pending'   => $cutiModel->where('status', 'pending')->countAllResults(),
            'total_dokumen'  => $suratModel->countAllResults(),

            // PERBAIKAN: Menggunakan nama tabel 'pengajuan_cuti' yang benar
            'cuti_terbaru'   => $cutiModel->select('pengajuan_cuti.*, karyawan_profil.nama_lengkap')
                ->join('karyawan_profil', 'karyawan_profil.user_id = pengajuan_cuti.user_id')
                ->orderBy('pengajuan_cuti.created_at', 'DESC')
                ->findAll(5)
        ];

        return view('admin/dashboard', $data);
    }

    public function cuti_index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $cutiModel = new \App\Models\CutiModel();

        $data = [
            'nama_admin'   => session()->get('nama_lengkap'),
            // Mengambil semua data pengajuan cuti dari semua karyawan
            'daftar_cuti'  => $cutiModel->select('pengajuan_cuti.*, karyawan_profil.nama_lengkap, karyawan_profil.jabatan')
                ->join('karyawan_profil', 'karyawan_profil.user_id = pengajuan_cuti.user_id')
                ->orderBy('pengajuan_cuti.status', 'ASC') // Biar yang 'pending' naik ke atas
                ->orderBy('pengajuan_cuti.created_at', 'DESC')
                ->findAll()
        ];

        return view('admin/cuti_manage', $data);
    }

    public function cuti_approve($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $cutiModel = new \App\Models\CutiModel();

        $cutiModel->update($id, [
            'status'           => 'disetujui',
            'keterangan_admin' => 'Disetujui oleh Administrator pada ' . date('d M Y')
        ]);

        return redirect()->to('/admin/cuti')->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    public function cuti_reject($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $cutiModel = new \App\Models\CutiModel();
        $alasanTolak = $this->request->getPost('keterangan_admin');

        $cutiModel->update($id, [
            'status'           => 'ditolak',
            'keterangan_admin' => $alasanTolak ? $alasanTolak : 'Ditolak oleh Administrator.'
        ]);

        return redirect()->to('/admin/cuti')->with('success', 'Pengajuan cuti telah ditolak.');
    }
}
