<?php

namespace Database\Seeders;

use App\Models\DokumenSyarat;
use Illuminate\Database\Seeder;

class DokumenSyaratSeeder extends Seeder
{
    public function run(): void
    {
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
                'keterangan' => 'Transkrip nilai sementara atau KHS terakhir yang diperlukan untuk keperluan akademik.',
                'allowed_formats' => 'pdf',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Bukti Pembayaran UKT',
                'keterangan' => 'Bukti pembayaran UKT semester berjalan.',
                'allowed_formats' => 'pdf',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Surat Pernyataan Mahasiswa',
                'keterangan' => 'Surat pernyataan yang ditandatangani oleh mahasiswa sesuai kebutuhan pengajuan.',
                'allowed_formats' => 'pdf',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Proposal Kegiatan atau Penelitian',
                'keterangan' => 'Proposal kegiatan, magang, penelitian, atau observasi sesuai jenis surat yang diajukan.',
                'allowed_formats' => 'pdf',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Surat Pengantar dari Program Studi',
                'keterangan' => 'Surat pengantar atau persetujuan dari program studi jika diperlukan.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Pas Foto',
                'keterangan' => 'Pas foto terbaru dengan latar formal.',
                'allowed_formats' => 'jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Kartu Keluarga (KK)',
                'keterangan' => 'Scan atau foto Kartu Keluarga yang terlihat jelas.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
            [
                'nama_dokumen' => 'Slip Gaji / Keterangan Penghasilan Orang Tua',
                'keterangan' => 'Slip gaji resmi atau surat keterangan penghasilan dari kelurahan/desa setempat.',
                'allowed_formats' => 'pdf,jpg,png',
                'max_size' => 2,
            ],
        ];

        foreach ($data as $item) {
            DokumenSyarat::updateOrCreate(
                ['nama_dokumen' => $item['nama_dokumen']],
                [
                    'keterangan' => $item['keterangan'],
                    'allowed_formats' => $item['allowed_formats'],
                    'max_size' => $item['max_size'],
                ]
            );
        }
    }
}
