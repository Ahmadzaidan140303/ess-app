<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nip'        => '123456',
                'email'      => 'admin@company.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nip'        => '654321',
                'email'      => 'ahmad@company.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Memasukkan data ke tabel 'users'
        $this->db->table('users')->insertBatch($data);
    }
}
