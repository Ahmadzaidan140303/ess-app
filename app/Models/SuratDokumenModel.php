<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratDokumenModel extends Model
{
    protected $table            = 'surat_dokumen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_surat', 'deskripsi', 'nama_file', 'kategori'];

    protected $useTimestamps = true;
    protected $createdField  = 'uploaded_at'; // Menggunakan nama kolom yang disesuaikan saat migrasi
    protected $updatedField  = '';
}
