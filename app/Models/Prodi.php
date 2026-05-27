<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';

    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'jenjang',
        'akreditasi',
        'fakultas',
        'ketua_prodi',
        'tahun_berdiri',
        'deskripsi',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}