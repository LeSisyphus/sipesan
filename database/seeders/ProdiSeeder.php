<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;
use Illuminate\Support\Facades\Schema;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tabel prodi agar tidak duplikat saat dijalankan berkali-kali
        Schema::disableForeignKeyConstraints();
        Prodi::truncate();
        Schema::enableForeignKeyConstraints();

        $prodis = [
            ['nama_prodi' => 'Teknologi Informasi', 'fakultas' => 'Teknik'],
            ['nama_prodi' => 'Manajemen',          'fakultas' => 'Ekonomi dan Bisnis'],
            ['nama_prodi' => 'Hukum',              'fakultas' => 'Hukum'],
            ['nama_prodi' => 'Kehutanan',          'fakultas' => 'Kehutanan'],
            ['nama_prodi' => 'Pendidikan IPA',     'fakultas' => 'Keguruan dan Ilmu Pendidikan'],
        ];

        foreach ($prodis as $prodi) {
            Prodi::create($prodi);
        }
    }
}
