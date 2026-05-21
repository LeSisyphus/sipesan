<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\Database\Seeder;

class PengajuanDummySeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswaIds = Mahasiswa::pluck('id')->toArray();
        $jenisSuratIds = JenisSurat::pluck('id')->toArray();

        if (empty($mahasiswaIds) || empty($jenisSuratIds)) {
            $this->command->warn('Seeder dibatalkan: data mahasiswa atau jenis surat masih kosong.');
            return;
        }

        $statuses = ['menunggu', 'diproses', 'selesai', 'ditolak'];

        $keperluanList = [
            'Keperluan beasiswa',
            'Syarat magang',
            'Pendaftaran lomba',
            'Administrasi kampus',
            'Keperluan penelitian',
            'Syarat seminar proposal',
            'Pengajuan MBKM',
            'Keperluan organisasi',
            'Validasi data akademik',
            'Syarat pendaftaran kerja praktik',
        ];

        for ($i = 1; $i <= 20; $i++) {
            Pengajuan::create([
                'mahasiswa_id' => fake()->randomElement($mahasiswaIds),
                'jenis_surat_id' => fake()->randomElement($jenisSuratIds),
                'keperluan' => fake()->randomElement($keperluanList),
                'status' => fake()->randomElement($statuses),
                'tgl_ajuan' => now()->subDays(rand(0, 30)),
                'tgl_proses' => rand(0, 1) ? now()->subDays(rand(0, 10)) : null,
                'catatan_admin' => '[DUMMY TEST] ' . fake()->sentence(),
                'file_surat' => null,
            ]);
        }

        $this->command->info('20 data dummy pengajuan berhasil dibuat.');
    }
}