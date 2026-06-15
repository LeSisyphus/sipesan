<?php

namespace Database\Seeders;

use App\Models\DokumenSyarat;
use App\Models\JenisSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('pengajuan_dokumen')->truncate();
        DB::table('pengajuan')->truncate();
        DB::table('jenis_surat_syarat')->truncate();
        JenisSurat::truncate();

        Schema::enableForeignKeyConstraints();

        $jenisSurats = [
            [
                'nama_surat' => 'Surat Keterangan Aktif Kuliah',
                'deskripsi' => 'Surat keterangan bahwa mahasiswa masih terdaftar dan aktif mengikuti perkuliahan pada semester berjalan.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Rencana Studi (KRS)',
                ],
            ],
            [
                'nama_surat' => 'Surat Pengantar Penelitian',
                'deskripsi' => 'Surat pengantar untuk mahasiswa yang akan melakukan penelitian, observasi, atau pengambilan data.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Rencana Studi (KRS)',
                    'Proposal Kegiatan atau Penelitian',
                ],
            ],
            [
                'nama_surat' => 'Surat Rekomendasi Beasiswa',
                'deskripsi' => 'Surat rekomendasi untuk keperluan pendaftaran atau kelengkapan administrasi beasiswa.',
                'dokumen_syarat' => [
                    'Kartu Tanda Mahasiswa (KTM)',
                    'Kartu Tanda Penduduk (KTP)',
                    'Transkrip Nilai Sementara',
                ],
            ],
        ];

        foreach ($jenisSurats as $data) {
            $dokumenSyaratNames = $data['dokumen_syarat'];
            unset($data['dokumen_syarat']);

            $jenisSurat = JenisSurat::create([
                'nama_surat' => $data['nama_surat'],
                'deskripsi' => $data['deskripsi'],
            ]);

            $dokumenSyaratIds = DokumenSyarat::whereIn('nama_dokumen', $dokumenSyaratNames)
                ->pluck('id')
                ->toArray();

            $jenisSurat->dokumenSyarat()->sync($dokumenSyaratIds);
        }
    }
}
