<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data user admin lama agar tidak duplikat saat dijalankan berkali-kali
        Schema::disableForeignKeyConstraints();
        User::where('role', 'admin')->delete();
        Schema::enableForeignKeyConstraints();

        // Buat akun Admin Tata Usaha (TU)
        User::create([
            'name'     => 'Admin TU',
            'email'    => 'admin@sipesan.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'status'   => 'aktif',
        ]);
    }
}
