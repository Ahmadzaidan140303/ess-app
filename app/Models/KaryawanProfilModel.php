<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanProfilModel extends Model
{
    protected $table            = 'karyawan_profil';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'foto'
    ];

    protected $useTimestamps = true;
    protected $createdField  = ''; // Kita set kosong karena tabel profil hanya punya updated_at
    protected $updatedField  = 'updated_at';
}
