<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Schema;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tabel mahasiswa dan hapus user dengan role mahasiswa agar tidak duplikat saat dijalankan berkali-kali
        Schema::disableForeignKeyConstraints();
        Mahasiswa::truncate();
        User::where('role', 'mahasiswa')->delete();
        Schema::enableForeignKeyConstraints();

        // Ambil ID Prodi yang tersedia
        $prodiIds = Prodi::pluck('id')->toArray();

        // Jika prodi belum di-seed, jalankan ProdiSeeder terlebih dahulu
        if (empty($prodiIds)) {
            $this->call(ProdiSeeder::class);
            $prodiIds = Prodi::pluck('id')->toArray();
        }

        $dummyStudents = [
            [
                'name' => 'Ahmad Hidayat Pratama',
                'nim' => '2205101001',
                'email' => 'ahmad.hidayat@student.sipesan.com',
                'angkatan' => '2022',
                'no_hp' => '081234567890',
                'status' => 'aktif',
            ],
            [
                'name' => 'Budi Santoso Putra',
                'nim' => '2205101002',
                'email' => 'budi.santoso@student.sipesan.com',
                'angkatan' => '2022',
                'no_hp' => '081234567891',
                'status' => 'aktif',
            ],
            [
                'name' => 'Citra Lestari Dewi',
                'nim' => '2205101003',
                'email' => 'citra.lestari@student.sipesan.com',
                'angkatan' => '2023',
                'no_hp' => '081234567892',
                'status' => 'aktif',
            ],
            [
                'name' => 'Dewi Sartika Putri',
                'nim' => '2205101004',
                'email' => 'dewi.sartika@student.sipesan.com',
                'angkatan' => '2023',
                'no_hp' => '081234567893',
                'status' => 'nonaktif',
            ],
            [
                'name' => 'Eko Prasetyo Utomo',
                'nim' => '2205101005',
                'email' => 'eko.prasetyo@student.sipesan.com',
                'angkatan' => '2024',
                'no_hp' => '081234567894',
                'status' => 'aktif',
            ],
            [
                'name' => 'Farhan Maulana Yusuf',
                'nim' => '2205101006',
                'email' => 'farhan.maulana@student.sipesan.com',
                'angkatan' => '2024',
                'no_hp' => '081234567895',
                'status' => 'aktif',
            ],
            [
                'name' => 'Gita Permata Sari',
                'nim' => '2205101007',
                'email' => 'gita.permata@student.sipesan.com',
                'angkatan' => '2022',
                'no_hp' => '081234567896',
                'status' => 'aktif',
            ],
            [
                'name' => 'Hendra Wijaya Kusuma',
                'nim' => '2205101008',
                'email' => 'hendra.wijaya@student.sipesan.com',
                'angkatan' => '2023',
                'no_hp' => '081234567897',
                'status' => 'nonaktif',
            ],
            [
                'name' => 'Indah Cahyani Putri',
                'nim' => '2205101009',
                'email' => 'indah.cahyani@student.sipesan.com',
                'angkatan' => '2024',
                'no_hp' => '081234567898',
                'status' => 'aktif',
            ],
            [
                'name' => 'Joko Susilo Wibowo',
                'nim' => '2205101010',
                'email' => 'joko.susilo@student.sipesan.com',
                'angkatan' => '2022',
                'no_hp' => '081234567899',
                'status' => 'aktif',
            ],
        ];

        foreach ($dummyStudents as $index => $data) {
            // Tentukan prodi_id secara bergantian dari prodi yang tersedia
            $prodiId = $prodiIds[$index % count($prodiIds)];

            // Create User
            $user = User::create([
                'name' => $data['name'],
                'nim' => $data['nim'],
                'email' => $data['email'],
                'password' => Hash::make($data['nim']),
                'role' => 'mahasiswa',
                'status' => $data['status'],
            ]);

            // Create Mahasiswa linked to User
            Mahasiswa::create([
                'user_id' => $user->id,
                'prodi_id' => $prodiId,
                'angkatan' => $data['angkatan'],
                'no_hp' => $data['no_hp'],
            ]);
        }
    }
}
