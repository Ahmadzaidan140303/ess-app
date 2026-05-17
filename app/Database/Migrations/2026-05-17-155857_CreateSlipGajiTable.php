<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSlipGajiTable extends Migration
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
            'bulan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'tahun' => [
                'type'       => 'YEAR',
            ],
            'gaji_pokok' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tunjangan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'potongan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'total_diterima' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'file_pdf' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('slip_gaji');
    }

    public function down()
    {
        $this->forge->dropTable('slip_gaji');
    }
}
