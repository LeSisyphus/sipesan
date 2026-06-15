<?php

namespace Database\Seeders;

use App\Models\DokumenSyarat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DokumenSyaratSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('jenis_surat_syarat')->truncate();
        DB::table('pengajuan_dokumen')->truncate();
        DokumenSyarat::truncate();

        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'nama_dokumen' => 'Kartu Tanda Mahasiswa (KTM)',
                'keterangan' => 'Scan atau foto KTM yang masih berlaku dan terlihat jelas.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Kartu Rencana Studi (KRS)',
                'keterangan' => 'KRS semester berjalan sebagai bukti mahasiswa aktif.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Kartu Tanda Penduduk (KTP)',
                'keterangan' => 'Scan atau foto KTP mahasiswa yang masih berlaku.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Transkrip Nilai Sementara',
                'keterangan' => 'Transkrip nilai sementara atau KHS terakhir untuk kebutuhan akademik.',
                'allowed_formats' => 'pdf',
                'max_size' => 5,
            ],
            [
                'nama_dokumen' => 'Proposal Kegiatan atau Penelitian',
                'keterangan' => 'Proposal kegiatan, magang, penelitian, atau observasi sesuai jenis surat yang diajukan.',
                'allowed_formats' => 'pdf',
                'max_size' => 5,
            ],
        ];

        foreach ($data as $item) {
            DokumenSyarat::create($item);
        }
    }
}
