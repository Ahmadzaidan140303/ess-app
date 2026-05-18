<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNipToKaryawanProfil extends Migration
{
    public function up()
    {
        // Mendefinisikan struktur kolom nip baru
        $fields = [
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true, // Di-set true dulu agar data lama yang sudah ada tidak error
                'after'      => 'user_id' // Meletakkan kolom NIP persis setelah kolom user_id
            ],
        ];

        // Eksekusi penambahan kolom ke tabel karyawan_profil
        $this->forge->addColumn('karyawan_profil', $fields);
    }

    public function down()
    {
        // Fungsi rollback untuk menghapus kembali kolom nip jika diperlukan
        $this->forge->dropColumn('karyawan_profil', 'nip');
    }
}
