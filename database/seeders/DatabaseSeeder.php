<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProdiSeeder::class,
            MahasiswaSeeder::class,
            DokumenSyaratSeeder::class,
            JenisSuratSeeder::class,
        ]);
    }
}