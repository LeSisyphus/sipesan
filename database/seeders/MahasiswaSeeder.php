<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $prodi = Prodi::where('kode_prodi', 'TIF')->first()
            ?? Prodi::where('nama_prodi', 'Teknologi Informasi')->first()
            ?? Prodi::first();

        if (! $prodi) {
            $this->call(ProdiSeeder::class);
            $prodi = Prodi::where('kode_prodi', 'TIF')->first()
                ?? Prodi::where('nama_prodi', 'Teknologi Informasi')->first()
                ?? Prodi::first();
        }

        $mahasiswaUsers = User::where('role', 'mahasiswa')
            ->orderBy('nim')
            ->get();

        foreach ($mahasiswaUsers as $index => $user) {
            Mahasiswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'prodi_id' => $prodi->id,
                    'angkatan' => '2023',
                    'no_hp' => $this->phoneNumber($index),
                    'tempat_lahir' => $this->birthPlace($index),
                    'tanggal_lahir' => $this->birthDate($index),
                    'jenis_kelamin' => $this->gender($index),
                    'alamat' => $this->address($index),
                    'email_alternatif' => $this->alternativeEmail($user->email),
                    'kontak_darurat' => $this->phoneNumber($index + 20),
                ]
            );
        }
    }

    private function phoneNumber(int $index): string
    {
        return '088242667' . str_pad((string) ($index + 100), 3, '0', STR_PAD_LEFT);
    }

    private function birthPlace(int $index): string
    {
        $places = ['Samarinda', 'Banjarmasin', 'Balikpapan', 'Banjarbaru', 'Martapura'];
        return $places[$index % count($places)];
    }

    private function birthDate(int $index): string
    {
        $day = str_pad((string) (($index % 27) + 1), 2, '0', STR_PAD_LEFT);
        $month = str_pad((string) (($index % 12) + 1), 2, '0', STR_PAD_LEFT);

        return "2004-{$month}-{$day}";
    }

    private function gender(int $index): string
    {
        return $index % 2 === 0 ? 'Laki-laki' : 'Perempuan';
    }

    private function address(int $index): string
    {
        $cities = ['Samarinda', 'Banjarmasin', 'Balikpapan', 'Banjarbaru', 'Martapura'];
        return 'Jl. Demo SiPesan No. ' . ($index + 1) . ', ' . $cities[$index % count($cities)];
    }

    private function alternativeEmail(string $email): string
    {
        [$name] = explode('@', $email);

        return $name . '.backup@example.com';
    }
}
