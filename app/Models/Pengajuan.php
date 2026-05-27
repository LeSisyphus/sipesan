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
        'data_tambahan',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'tgl_ajuan' => 'date',
        'tgl_proses' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function dokumen()
    {
        return $this->hasMany(PengajuanDokumen::class);
    }
}