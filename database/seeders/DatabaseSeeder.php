<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Prodi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name'     => 'Admin TU',
            'email'    => 'admin@sipesan.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        Prodi::create(['nama_prodi' => 'Teknologi Informasi', 'fakultas' => 'Teknik']);
        Prodi::create(['nama_prodi' => 'Manajemen',          'fakultas' => 'Ekonomi']);
    }
}