<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'angkatan',
        'no_hp',
    ];

    // Relasi ke User (pemilik akun)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    // Relasi One-to-Many: satu mahasiswa punya banyak pengajuan
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}