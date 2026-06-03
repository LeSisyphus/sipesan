<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\DokumenSyarat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurats = [
            [
                'nama_surat' => 'Surat Keterangan Aktif Kuliah',
                'deskripsi' => 'Surat keterangan bahwa mahasiswa masih terdaftar dan aktif mengikuti perkuliahan pada semester berjalan.',
                'template_isi' => 'Dengan ini menerangkan bahwa mahasiswa yang bersangkutan benar terdaftar sebagai mahasiswa aktif pada Universitas Lambung Mangkurat dan masih mengikuti kegiatan akademik pada semester berjalan.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Rencana Studi (KRS)',
                    'Bukti Pembayaran UKT',
                ],
            ],
            [
                'nama_surat' => 'Surat Keterangan Mahasiswa',
                'deskripsi' => 'Surat keterangan umum yang menyatakan bahwa pemohon merupakan mahasiswa pada program studi terkait.',
                'template_isi' => 'Dengan ini menerangkan bahwa mahasiswa yang bersangkutan benar merupakan mahasiswa pada program studi terkait di Universitas Lambung Mangkurat.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Kartu Rencana Studi (KRS)',
                ],
            ],
            [
                'nama_surat' => 'Surat Pengantar Penelitian',
                'deskripsi' => 'Surat pengantar untuk mahasiswa yang akan melakukan penelitian, observasi, atau pengambilan data.',
                'template_isi' => 'Surat ini dibuat sebagai pengantar bagi mahasiswa yang bersangkutan untuk melaksanakan penelitian atau pengambilan data sesuai dengan kebutuhan akademik.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Rencana Studi (KRS)',
                    'Proposal Kegiatan atau Penelitian',
                    'Surat Pengantar dari Program Studi',
                ],
            ],
            [
                'nama_surat' => 'Surat Pengantar Magang',
                'deskripsi' => 'Surat pengantar untuk mahasiswa yang akan melaksanakan magang, praktik kerja lapangan, atau kegiatan sejenis.',
                'template_isi' => 'Surat ini dibuat sebagai pengantar bagi mahasiswa yang bersangkutan untuk melaksanakan magang atau praktik kerja lapangan pada instansi tujuan.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Rencana Studi (KRS)',
                    'Transkrip Nilai Sementara',
                    'Proposal Kegiatan atau Penelitian',
                ],
            ],
            [
                'nama_surat' => 'Surat Rekomendasi Beasiswa',
                'deskripsi' => 'Surat rekomendasi untuk keperluan pendaftaran atau kelengkapan administrasi beasiswa.',
                'template_isi' => 'Dengan ini memberikan rekomendasi kepada mahasiswa yang bersangkutan untuk keperluan pengajuan beasiswa sesuai ketentuan yang berlaku.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Kartu Keluarga (KK)',
                    'Transkrip Nilai Sementara',
                    'Bukti Pembayaran UKT',
                ],
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Menerima Beasiswa',
                'deskripsi' => 'Surat keterangan bahwa mahasiswa tidak sedang menerima beasiswa dari pihak tertentu.',
                'template_isi' => 'Dengan ini menerangkan bahwa mahasiswa yang bersangkutan tidak sedang tercatat sebagai penerima beasiswa berdasarkan data yang tersedia.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Kartu Keluarga (KK)',
                    'Surat Pernyataan Mahasiswa',
                ],
            ],
            [
                'nama_surat' => 'Surat Izin Kegiatan Mahasiswa',
                'deskripsi' => 'Surat izin untuk kegiatan mahasiswa yang berkaitan dengan akademik, organisasi, atau kegiatan kampus lainnya.',
                'template_isi' => 'Surat ini dibuat sebagai bentuk izin dan pengantar pelaksanaan kegiatan mahasiswa sesuai data kegiatan yang diajukan.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Proposal Kegiatan atau Penelitian',
                    'Surat Pernyataan Mahasiswa',
                ],
            ],
            [
                'nama_surat' => 'Surat Keterangan Lulus',
                'deskripsi' => 'Surat keterangan sementara bagi mahasiswa yang telah dinyatakan lulus sebelum ijazah resmi diterbitkan.',
                'template_isi' => 'Dengan ini menerangkan bahwa mahasiswa yang bersangkutan telah dinyatakan lulus berdasarkan ketentuan akademik yang berlaku.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Transkrip Nilai Sementara',
                    'Pas Foto',
                ],
            ],
            [
                'nama_surat' => 'Surat Cuti Akademik',
                'deskripsi' => 'Surat izin resmi untuk menghentikan studi sementara untuk jangka waktu tertentu.',
                'template_isi' => 'Memberikan izin cuti akademik kepada mahasiswa berikut...',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Bukti Pembayaran UKT',
                ],
            ],
            [
                'nama_surat' => 'Surat Pengunduran Diri',
                'deskripsi' => 'Surat pernyataan resmi pengunduran diri secara hormat sebagai mahasiswa.',
                'template_isi' => 'Menerangkan pengunduran diri mahasiswa...',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Bukti Pembayaran UKT',
                ],
            ],
        ];

        foreach ($jenisSurats as $data) {
            $dokumenSyaratNames = $data['dokumen_syarat'];
            unset($data['dokumen_syarat']);

            $jenisSurat = JenisSurat::updateOrCreate(
                ['nama_surat' => $data['nama_surat']],
                [
                    'deskripsi' => $data['deskripsi'],
                    'template_isi' => $data['template_isi'],
                ]
            );

            $dokumenSyaratIds = DokumenSyarat::whereIn('nama_dokumen', $dokumenSyaratNames)
                ->pluck('id')
                ->toArray();

            $jenisSurat->dokumenSyarat()->sync($dokumenSyaratIds);
        }
    }
}
