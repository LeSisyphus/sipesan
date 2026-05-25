<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDokumen extends Model
{
    protected $table = 'pengajuan_dokumen';

    protected $fillable = [
        'pengajuan_id',
        'dokumen_syarat_id',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function dokumenSyarat()
    {
        return $this->belongsTo(DokumenSyarat::class);
    }
}