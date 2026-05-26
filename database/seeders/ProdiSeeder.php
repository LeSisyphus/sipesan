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
            [
                'kode_prodi' => 'TIF',
                'nama_prodi' => 'Teknologi Informasi',
                'jenjang' => 'S1',
                'akreditasi' => 'A',
                'fakultas' => 'Teknik',
                'ketua_prodi' => 'Dr. Budi Santoso, M.Kom',
                'tahun_berdiri' => 2002,
                'deskripsi' => 'Pengembangan perangkat lunak dan sistem komputer.',
                'status' => 'aktif',
            ],
            [
                'kode_prodi' => 'MNJ',
                'nama_prodi' => 'Manajemen',
                'jenjang' => 'S1',
                'akreditasi' => 'B',
                'fakultas' => 'Ekonomi dan Bisnis',
                'ketua_prodi' => 'Dr. H. Ahmad Fauzi, S.E., M.M.',
                'tahun_berdiri' => 1995,
                'deskripsi' => 'Studi tentang pengelolaan bisnis, organisasi, dan kewirausahaan.',
                'status' => 'aktif',
            ],
            [
                'kode_prodi' => 'HKM',
                'nama_prodi' => 'Hukum',
                'jenjang' => 'S1',
                'akreditasi' => 'A',
                'fakultas' => 'Hukum',
                'ketua_prodi' => 'Prof. Dr. Siti Rahma, S.H., M.H.',
                'tahun_berdiri' => 2010,
                'deskripsi' => 'Kajian mendalam tentang sistem hukum, konstitusi, dan advokasi.',
                'status' => 'aktif',
            ],
            [
                'kode_prodi' => 'KHT',
                'nama_prodi' => 'Kehutanan',
                'jenjang' => 'S1',
                'akreditasi' => 'C',
                'fakultas' => 'Kehutanan',
                'ketua_prodi' => 'Dr. Ir. Bambang Herry, M.Si.',
                'tahun_berdiri' => 2015,
                'deskripsi' => 'Pengelolaan ekosistem hutan dan konservasi sumber daya alam hayati.',
                'status' => 'aktif',
            ],
            [
                'kode_prodi' => 'PIP',
                'nama_prodi' => 'Pendidikan IPA',
                'jenjang' => 'S1',
                'akreditasi' => 'B',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
                'ketua_prodi' => 'Dr. Rina Wijayanti, M.Pd.',
                'tahun_berdiri' => 2018,
                'deskripsi' => 'Mempersiapkan tenaga pendidik bidang ilmu pengetahuan alam profesional.',
                'status' => 'aktif',
            ],
        ];

        foreach ($prodis as $prodi) {
            Prodi::create($prodi);
        }
    }
}
