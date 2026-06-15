<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('pengajuan_dokumen')->truncate();
        DB::table('pengajuan')->truncate();
        DB::table('mahasiswa')->truncate();

        User::whereIn('role', ['admin', 'mahasiswa'])->delete();

        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Admin TU',
            'email' => 'admin@sipesan.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        foreach ($this->mahasiswaUsers() as $mahasiswa) {
            User::create([
                'name' => $mahasiswa['name'],
                'nim' => $mahasiswa['nim'],
                'email' => $mahasiswa['email'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'status' => $mahasiswa['status'] ?? 'aktif',
            ]);
        }
    }

    private function mahasiswaUsers(): array
    {
        return [
            ['name' => 'Muhammad Maulana Azhari', 'nim' => '231081731001', 'email' => 'maulana@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Rachel Amanda Putri', 'nim' => '231081731002', 'email' => 'rachel@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Nabilla Putri Maharani', 'nim' => '231081731003', 'email' => 'nabilla@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Adiya Pratama', 'nim' => '231081731004', 'email' => 'adiya@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Azri Ramadhan', 'nim' => '231081731005', 'email' => 'azri@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Dimas Pratama', 'nim' => '231081731006', 'email' => 'dimas@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Siti Aulia Rahmah', 'nim' => '231081731007', 'email' => 'aulia@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Muhammad Farhan', 'nim' => '231081731008', 'email' => 'farhan@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Nurul Safitri', 'nim' => '231081731009', 'email' => 'nurul@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Rizky Hidayat', 'nim' => '231081731010', 'email' => 'rizky@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Fajar Maulana', 'nim' => '231081731011', 'email' => 'fajar@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Citra Lestari', 'nim' => '231081731012', 'email' => 'citra@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Bagas Saputra', 'nim' => '231081731013', 'email' => 'bagas@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Intan Permata Sari', 'nim' => '231081731014', 'email' => 'intan@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Ahmad Fauzi', 'nim' => '231081731015', 'email' => 'fauzi@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Dewi Anggraini', 'nim' => '231081731016', 'email' => 'dewi@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Yoga Pratama', 'nim' => '231081731017', 'email' => 'yoga@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Maya Salsabila', 'nim' => '231081731018', 'email' => 'maya@sipesan.com', 'status' => 'aktif'],
            ['name' => 'Ilham Ramadhan', 'nim' => '231081731019', 'email' => 'ilham@sipesan.com', 'status' => 'nonaktif'],
            ['name' => 'Putri Nabila Azzahra', 'nim' => '231081731020', 'email' => 'putri@sipesan.com', 'status' => 'nonaktif'],
        ];
    }
}
