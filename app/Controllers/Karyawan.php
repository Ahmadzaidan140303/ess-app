<?php

namespace App\Controllers;

use App\Models\CutiModel;

class Karyawan extends BaseController
{
    protected $cutiModel;

    public function __construct()
    {
        $this->cutiModel = new CutiModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => session()->get('foto') ? session()->get('foto') : 'default.png',
        ];

        return view('karyawan/dashboard', $data);
    }

    // 1. Menampilkan Halaman Cuti dan Riwayatnya
    public function cuti()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('user_id');

        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => session()->get('foto'),
            // Mengambil semua riwayat cuti milik karyawan yang sedang login (diurutkan dari yang terbaru)
            'riwayat_cuti' => $this->cutiModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('karyawan/cuti', $data);
    }

    // 2. Memproses Inputan Formulir Cuti
    public function cuti_store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        // Validasi Input
        if (!$this->validate([
            'jenis_cuti'      => 'required',
            'tanggal_mulai'   => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'alasan'          => 'required|min_length[5]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom wajib diisi dengan benar.');
        }

        // Simpan ke Database
        $this->cutiModel->save([
            'user_id'         => session()->get('user_id'),
            'jenis_cuti'      => $this->request->getPost('jenis_cuti'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'alasan'          => $this->request->getPost('alasan'),
            'status'          => 'pending' // Status awal otomatis pending
        ]);

        return redirect()->to('/karyawan/cuti')->with('success', 'Pengajuan cuti berhasil dikirim! Menunggu persetujuan admin.');
    }

    // Pastikan letakkan di bagian atas class jika belum ada: use App\Models\SlipGajiModel;

    public function slip_gaji()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $slipModel = new \App\Models\SlipGajiModel();
        $userId = session()->get('user_id');

        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => session()->get('foto'),
            // Mengambil semua data slip gaji karyawan ini
            'riwayat_gaji' => $slipModel->where('user_id', $userId)->orderBy('tahun', 'DESC')->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('karyawan/slip_gaji', $data);
    }

    public function download_surat()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $suratModel = new \App\Models\SuratDokumenModel();

        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => session()->get('foto'),
            // Mengambil semua daftar surat dokumen resmi
            'daftar_surat' => $suratModel->orderBy('uploaded_at', 'DESC')->findAll()
        ];

        return view('karyawan/download_surat', $data);
    }

    public function proses_download($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $suratModel = new \App\Models\SuratDokumenModel();
        $surat = $suratModel->find($id);

        if ($surat) {
            $path = ROOTPATH . 'public/uploads/dokumen/' . $surat['nama_file'];

            // Memastikan file fisik benar-benar ada di server folder public/uploads/dokumen/
            if (file_exists($path)) {
                return $this->response->download($path, null);
            } else {
                return redirect()->back()->with('error', 'File fisik dokumen tidak ditemukan di server.');
            }
        }

        return redirect()->back()->with('error', 'Dokumen tidak valid.');
    }

    public function profil()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $profilModel = new \App\Models\KaryawanProfilModel();
        $userId = session()->get('user_id');

        // Mengambil data profil berdasarkan user_id yang sedang login
        $profilData = $profilModel->where('user_id', $userId)->first();

        $data = [
            'nama'    => session()->get('nama_lengkap'),
            'jabatan' => session()->get('jabatan'),
            'nip'     => session()->get('nip'),
            'foto'    => $profilData ? $profilData['foto'] : 'default.png',
            'profil'  => $profilData
        ];

        return view('karyawan/profil', $data);
    }

    public function profil_upload_foto()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'karyawan') {
            return redirect()->to('/login');
        }

        // 1. Validasi File (Harus gambar, maks 2MB)
        if (!$this->validate([
            'foto_profil' => [
                'rules' => 'uploaded[foto_profil]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]|max_size[foto_profil,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file foto terlebih dahulu.',
                    'is_image' => 'File yang Anda pilih bukan gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran gambar maksimal adalah 2 MB.'
                ]
            ]
        ])) {
            return redirect()->back()->with('error', $this->validator->getError('foto_profil'));
        }

        $profilModel = new \App\Models\KaryawanProfilModel();
        $userId = session()->get('user_id');
        $profil = $profilModel->where('user_id', $userId)->first();

        // 2. Ambil file gambar yang diunggah
        $fileFoto = $this->request->getFile('foto_profil');

        // 3. Generate nama file acak agar tidak bentrok di server
        $namaFotoBaru = $fileFoto->getRandomName();

        // 4. Pindahkan file fisik ke folder public/uploads/profil/
        $fileFoto->move(ROOTPATH . 'public/uploads/profil', $namaFotoBaru);

        // 5. Hapus file foto fisik lama dari server (kecuali jika masih default.png)
        if ($profil && $profil['foto'] !== 'default.png') {
            $pathFotoLama = ROOTPATH . 'public/uploads/profil/' . $profil['foto'];
            if (file_exists($pathFotoLama)) {
                unlink($pathFotoLama);
            }
        }

        // 6. Update nama file foto di Database
        $profilModel->update($profil['id'], [
            'foto' => $namaFotoBaru
        ]);

        // 7. Update data foto di Session agar foto di Navbar langsung berubah otomatis
        session()->set('foto', $namaFotoBaru);

        return redirect()->to('/karyawan/profil')->with('success', 'Foto profil Anda berhasil diperbarui!');
    }
}
