<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenSyarat extends Model
{
    protected $table = 'dokumen_syarat';

    protected $fillable = [
        'nama_dokumen',
        'keterangan',
        'allowed_formats',
        'max_size',
    ];

    public function jenisSurat()
    {
        return $this->belongsToMany(
            JenisSurat::class,
            'jenis_surat_syarat',
            'dokumen_syarat_id',
            'jenis_surat_id'
        );
    }

    public function pengajuanDokumen()
    {
        return $this->hasMany(PengajuanDokumen::class);
    }
}
