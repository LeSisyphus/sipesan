<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProdiSeeder::class,
            UserSeeder::class,
            MahasiswaSeeder::class,
            DokumenSyaratSeeder::class,
            JenisSuratSeeder::class,
            PengajuanDummySeeder::class,
        ]);
    }
}
