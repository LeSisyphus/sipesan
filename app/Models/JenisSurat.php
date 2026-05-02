<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama_surat',
        'deskripsi',
        'template_isi',
    ];

    // Relasi One-to-Many: satu jenis surat punya banyak pengajuan
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }

    // Relasi Many-to-Many ke DokumenSyarat
    public function dokumenSyarat()
    {
        return $this->belongsToMany(
            DokumenSyarat::class,
            'jenis_surat_syarat',
            'jenis_surat_id',
            'dokumen_syarat_id'
        );
    }
}