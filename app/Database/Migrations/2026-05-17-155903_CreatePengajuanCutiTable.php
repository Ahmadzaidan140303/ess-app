<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengajuanCutiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jenis_cuti' => [
                'type'       => 'ENUM',
                'constraint' => ['tahunan', 'sakit', 'melahirkan', 'lainnya'],
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
            ],
            'alasan' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'disetujui', 'ditolak'],
                'default'    => 'pending',
            ],
            'keterangan_admin' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan_cuti');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan_cuti');
    }
}
