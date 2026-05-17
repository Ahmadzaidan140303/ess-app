<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratDokumenTable extends Migration
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
            'nama_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_dokumen');
    }

    public function down()
    {
        $this->forge->dropTable('surat_dokumen');
    }
}
