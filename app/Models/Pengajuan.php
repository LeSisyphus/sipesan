<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'mahasiswa_id',
        'jenis_surat_id',
        'keperluan',
        'status',
        'tgl_ajuan',
        'tgl_proses',
        'catatan_admin',
        'file_surat',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke JenisSurat
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}