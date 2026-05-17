<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KaryawanProfilSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'       => 1, // Terhubung ke user ID 1 (Admin)
                'nama_lengkap'  => 'Admin HRD',
                'jabatan'       => 'Head of HRD',
                'tempat_lahir'  => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'telepon'       => '08123456789',
                'alamat'        => 'Jl. Sudirman No. 1, Jakarta',
                'foto'          => 'default.png',
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 2, // Terhubung ke user ID 2 (Karyawan)
                'nama_lengkap'  => 'Ahmad Zaidan',
                'jabatan'       => 'IT Web Developer',
                'tempat_lahir'  => 'Jambi',
                'tanggal_lahir' => '2002-05-15',
                'jenis_kelamin' => 'L',
                'telepon'       => '08987654321',
                'alamat'        => 'Jl. Jambi Raya No. 10, Jambi',
                'foto'          => 'default.png',
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        ];

        // Memasukkan data ke tabel 'karyawan_profil'
        $this->db->table('karyawan_profil')->insertBatch($data);
    }
}
