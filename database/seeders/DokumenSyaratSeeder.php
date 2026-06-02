<?php

namespace Database\Seeders;

use App\Models\DokumenSyarat;
use Illuminate\Database\Seeder;

class DokumenSyaratSeeder extends Seeder
{
    public function run(): void
    {
        $dokumenSyarats = [
            [
                'nama_dokumen' => 'Kartu Tanda Mahasiswa (KTM)',
                'keterangan' => 'Scan atau foto KTM yang masih berlaku dan terlihat jelas.',
            ],
            [
                'nama_dokumen' => 'Kartu Rencana Studi (KRS)',
                'keterangan' => 'KRS semester berjalan sebagai bukti mahasiswa aktif.',
            ],
            [
                'nama_dokumen' => 'Kartu Tanda Penduduk (KTP)',
                'keterangan' => 'Scan atau foto KTP mahasiswa yang masih berlaku.',
            ],
            [
                'nama_dokumen' => 'Transkrip Nilai Sementara',
                'keterangan' => 'Transkrip nilai sementara atau KHS terakhir yang diperlukan untuk keperluan akademik.',
            ],
            [
                'nama_dokumen' => 'Bukti Pembayaran UKT',
                'keterangan' => 'Bukti pembayaran UKT semester berjalan.',
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan Mahasiswa',
                'keterangan' => 'Surat pernyataan yang ditandatangani oleh mahasiswa sesuai kebutuhan pengajuan.',
            ],
            [
                'nama_dokumen' => 'Proposal Kegiatan atau Penelitian',
                'keterangan' => 'Proposal kegiatan, magang, penelitian, atau observasi sesuai jenis surat yang diajukan.',
            ],
            [
                'nama_dokumen' => 'Surat Pengantar dari Program Studi',
                'keterangan' => 'Surat pengantar atau persetujuan dari program studi jika diperlukan.',
            ],
            [
                'nama_dokumen' => 'Pas Foto',
                'keterangan' => 'Pas foto terbaru dengan latar formal.',
            ],
            [
                'nama_dokumen' => 'Kartu Keluarga (KK)',
                'keterangan' => 'Scan atau foto Kartu Keluarga yang terlihat jelas.',
            ],
        ];

        foreach ($dokumenSyarats as $dokumenSyarat) {
            DokumenSyarat::updateOrCreate(
                ['nama_dokumen' => $dokumenSyarat['nama_dokumen']],
                ['keterangan' => $dokumenSyarat['keterangan']]
            );
        }
    }
}