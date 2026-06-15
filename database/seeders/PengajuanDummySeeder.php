<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PengajuanDummySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('pengajuan_dokumen')->truncate();
        DB::table('pengajuan')->truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::where('email', 'maulana@sipesan.com')->first();
        $mahasiswa = $user?->mahasiswa;

        if (! $mahasiswa) {
            $this->command->warn('Seeder pengajuan dibatalkan: akun Maulana atau profil mahasiswa belum tersedia.');
            return;
        }

        $jenisSurat = JenisSurat::pluck('id', 'nama_surat');

        if ($jenisSurat->count() < 3) {
            $this->command->warn('Seeder pengajuan dibatalkan: jenis surat demo belum lengkap.');
            return;
        }

        Storage::disk('public')->makeDirectory('surat-final/demo');

        $rows = [
            [
                'jenis_surat' => 'Surat Keterangan Aktif Kuliah',
                'keperluan' => 'Keperluan administrasi beasiswa internal kampus.',
                'status' => 'selesai',
                'tgl_ajuan' => now()->subDays(14),
                'tgl_proses' => now()->subDays(12),
                'catatan_admin' => 'Pengajuan telah diverifikasi. Surat sudah selesai dan dapat diunduh.',
                'file_surat' => 'surat-final/demo/surat-aktif-kuliah-maulana.pdf',
                'data_tambahan' => [
                    'alamat_lengkap' => 'Samarinda, Kalimantan Timur',
                    'tahun_ajaran' => '2025/2026',
                    'semester' => 'Genap',
                ],
            ],
            [
                'jenis_surat' => 'Surat Rekomendasi Beasiswa',
                'keperluan' => 'Kelengkapan administrasi pendaftaran beasiswa prestasi.',
                'status' => 'selesai',
                'tgl_ajuan' => now()->subDays(10),
                'tgl_proses' => now()->subDays(8),
                'catatan_admin' => 'Berkas lengkap. Surat rekomendasi telah selesai diproses.',
                'file_surat' => 'surat-final/demo/surat-rekomendasi-beasiswa-maulana.pdf',
                'data_tambahan' => [
                    'alamat_lengkap' => 'Samarinda, Kalimantan Timur',
                    'tahun_ajaran' => '2025/2026',
                    'semester' => 'Genap',
                ],
            ],
            [
                'jenis_surat' => 'Surat Pengantar Penelitian',
                'keperluan' => 'Pengantar observasi awal untuk penyusunan tugas akhir.',
                'status' => 'ditolak',
                'tgl_ajuan' => now()->subDays(7),
                'tgl_proses' => now()->subDays(6),
                'catatan_admin' => 'Pengajuan ditolak karena proposal penelitian belum sesuai format yang diminta.',
                'file_surat' => null,
                'data_tambahan' => [
                    'alamat_lengkap' => 'Samarinda, Kalimantan Timur',
                    'tahun_ajaran' => '2025/2026',
                    'semester' => 'Genap',
                ],
            ],
            [
                'jenis_surat' => 'Surat Keterangan Aktif Kuliah',
                'keperluan' => 'Kelengkapan administrasi pengajuan magang mandiri.',
                'status' => 'diproses',
                'tgl_ajuan' => now()->subDays(3),
                'tgl_proses' => now()->subDays(2),
                'catatan_admin' => 'Berkas sedang diverifikasi oleh admin.',
                'file_surat' => null,
                'data_tambahan' => [
                    'alamat_lengkap' => 'Samarinda, Kalimantan Timur',
                    'tahun_ajaran' => '2025/2026',
                    'semester' => 'Genap',
                ],
            ],
            [
                'jenis_surat' => 'Surat Rekomendasi Beasiswa',
                'keperluan' => 'Kelengkapan administrasi program bantuan pendidikan.',
                'status' => 'diproses',
                'tgl_ajuan' => now()->subDay(),
                'tgl_proses' => now(),
                'catatan_admin' => 'Pengajuan masuk antrean proses administrasi.',
                'file_surat' => null,
                'data_tambahan' => [
                    'alamat_lengkap' => 'Samarinda, Kalimantan Timur',
                    'tahun_ajaran' => '2025/2026',
                    'semester' => 'Genap',
                ],
            ],
        ];

        foreach ($rows as $row) {
            $fileSurat = $row['file_surat'];

            if ($fileSurat) {
                Storage::disk('public')->put($fileSurat, $this->demoPdfContent($row['jenis_surat']));
            }

            Pengajuan::create([
                'mahasiswa_id' => $mahasiswa->id,
                'jenis_surat_id' => $jenisSurat[$row['jenis_surat']],
                'keperluan' => $row['keperluan'],
                'status' => $row['status'],
                'tgl_ajuan' => $row['tgl_ajuan']->toDateString(),
                'tgl_proses' => $row['tgl_proses']?->toDateString(),
                'catatan_admin' => $row['catatan_admin'],
                'file_surat' => $fileSurat,
                'data_tambahan' => $row['data_tambahan'],
            ]);
        }

        $this->command->info('5 data demo pengajuan Maulana berhasil dibuat: 2 selesai, 1 ditolak, 2 diproses.');
    }

    private function demoPdfContent(string $judul): string
    {
        $text = 'Demo SiPesan - ' . $judul;

        return "%PDF-1.4\n"
            . "1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj\n"
            . "2 0 obj<< /Type /Pages /Kids [3 0 R] /Count 1 >>endobj\n"
            . "3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>endobj\n"
            . "4 0 obj<< /Length 86 >>stream\nBT /F1 18 Tf 72 760 Td (" . $this->escapePdfText($text) . ") Tj 0 -32 Td (File surat final demo.) Tj ET\nendstream\nendobj\n"
            . "5 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj\n"
            . "xref\n0 6\n0000000000 65535 f \ntrailer<< /Root 1 0 R /Size 6 >>\nstartxref\n0\n%%EOF";
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
