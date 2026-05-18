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

    public function berkas_index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $profilModel = new \App\Models\KaryawanProfilModel();
        $suratModel  = new \App\Models\SuratDokumenModel();

        $data = [
            'nama_admin'     => session()->get('nama_lengkap'),
            // Mengambil daftar karyawan untuk pilihan tujuan slip gaji (Dropdown)
            'daftar_karyawan' => $profilModel->findAll(),
            // Mengambil seluruh master dokumen yang sudah diunggah
            'daftar_surat'   => $suratModel->orderBy('uploaded_at', 'DESC')->findAll()
        ];

        return view('admin/berkas_manage', $data);
    }

    public function upload_slip()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Validasi file PDF Slip Gaji
        if (!$this->validate([
            'file_pdf' => 'uploaded[file_pdf]|ext_in[file_pdf,pdf]|max_size[file_pdf,3072]'
        ])) {
            return redirect()->back()->with('error_slip', 'File slip harus berformat PDF & maksimal 3MB.');
        }

        $slipModel = new \App\Models\SlipGajiModel();
        $filePdf   = $this->request->getFile('file_pdf');
        $namaBaru  = $filePdf->getRandomName();

        // Pindahkan file fisik ke folder public/uploads/slip/
        $filePdf->move(ROOTPATH . 'public/uploads/slip', $namaBaru);

        // Ambil input data angka keuangan
        $gaji_pokok = $this->request->getPost('gaji_pokok');
        $tunjangan  = $this->request->getPost('tunjangan');
        $potongan   = $this->request->getPost('potongan');
        $total      = $gaji_pokok + $tunjangan - $potongan;

        $slipModel->save([
            'user_id'        => $this->request->getPost('user_id'),
            'bulan'          => $this->request->getPost('bulan'),
            'tahun'          => $this->request->getPost('tahun'),
            'gaji_pokok'     => $gaji_pokok,
            'tunjangan'      => $tunjangan,
            'potongan'       => $potongan,
            'total_diterima' => $total,
            'file_pdf'       => $namaBaru
        ]);

        return redirect()->to('/admin/berkas')->with('success_slip', 'Slip gaji karyawan berhasil diterbitkan!');
    }

    public function upload_dokumen()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Validasi Dokumen Resmi (Bisa PDF/Docx)
        if (!$this->validate([
            'nama_file' => 'uploaded[nama_file]|ext_in[nama_file,pdf,docx,doc]|max_size[nama_file,5120]'
        ])) {
            return redirect()->back()->with('error_dokumen', 'File dokumen harus berformat PDF/Docx & maksimal 5MB.');
        }

        $suratModel = new \App\Models\SuratDokumenModel();
        $fileDok    = $this->request->getFile('nama_file');
        $namaBaru   = $fileDok->getRandomName();

        // Pindahkan ke folder public/uploads/dokumen/
        $fileDok->move(ROOTPATH . 'public/uploads/dokumen', $namaBaru);

        $suratModel->save([
            'nama_surat' => $this->request->getPost('nama_surat'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'kategori'   => $this->request->getPost('kategori'),
            'nama_file'  => $namaBaru
        ]);

        return redirect()->to('/admin/berkas')->with('success_dokumen', 'Template dokumen internal baru berhasil ditambahkan!');
    }

    public function karyawan_index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $profilModel = new \App\Models\KaryawanProfilModel();

        $data = [
            'nama_admin'      => session()->get('nama_lengkap'),
            // KOREKSI: Hapus users.username karena tidak ada di tabel database Anda
            'daftar_karyawan' => $profilModel->select('karyawan_profil.*, users.email')
                ->join('users', 'users.id = karyawan_profil.user_id')
                ->orderBy('karyawan_profil.updated_at', 'DESC') // Menggunakan updated_at sesuai isi model Anda
                ->findAll()
        ];

        return view('admin/karyawan_manage', $data);
    }

    public function karyawan_store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        // Ambil data input secara manual untuk memastikan nilainya ada
        $nip         = $this->request->getPost('nip');
        $email       = $this->request->getPost('email');
        $password    = $this->request->getPost('password');
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $jabatan     = $this->request->getPost('jabatan');
        $telepon     = $this->request->getPost('no_telp') ? $this->request->getPost('no_telp') : '-';
        $alamat      = $this->request->getPost('alamat') ? $this->request->getPost('alamat') : '-';

        $userModel   = new \App\Models\UserModel();
        $profilModel = new \App\Models\KaryawanProfilModel();

        // 1. Simpan ke tabel USERS terlebih dahulu
        $dataUser = [
            'nip'      => $nip,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => 'karyawan'
        ];
        $userModel->save($dataUser);

        // Ambil ID User yang barusan terbuat
        $userIdBaru = $userModel->getInsertID();

        // 2. Simpan ke tabel KARYAWAN_PROFIL
        $dataProfil = [
            'user_id'      => $userIdBaru,
            'nip'          => $nip,
            'nama_lengkap' => $nama_lengkap,
            'jabatan'      => $jabatan,
            'telepon'      => $telepon,
            'alamat'       => $alamat,
            'foto'         => 'default.png'
        ];
        $profilModel->save($dataProfil);

        return redirect()->to('/admin/karyawan')->with('success', 'Karyawan baru sukses didaftarkan!');
    }

    public function karyawan_update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $profilModel = new \App\Models\KaryawanProfilModel();
        $userModel   = new \App\Models\UserModel();

        $userId      = $this->request->getPost('user_id');
        $nip         = $this->request->getPost('nip');
        $email       = $this->request->getPost('email');
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $jabatan     = $this->request->getPost('jabatan');
        $telepon     = $this->request->getPost('telepon');
        $alamat      = $this->request->getPost('alamat');

        // 1. Update data di tabel USERS berdasarkan user_id
        $dataUser = [
            'nip'   => $nip,
            'email' => $email
        ];

        if ($this->request->getPost('password')) {
            $dataUser['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $dataUser);

        // 2. Update data di tabel KARYAWAN_PROFIL berdasarkan id profil
        $profilModel->update($id, [
            'nip'          => $nip,
            'nama_lengkap' => $nama_lengkap,
            'jabatan'      => $jabatan,
            'telepon'      => $telepon,
            'alamat'       => $alamat,
        ]);

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil diperbarui!');
    }
}
