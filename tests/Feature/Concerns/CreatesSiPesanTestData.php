<?php

namespace Tests\Feature\Concerns;

use App\Models\DokumenSyarat;
use App\Models\JenisSurat;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\PengajuanDokumen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait CreatesSiPesanTestData
{
    protected function createAdminUser(array $overrides = []): User
    {
        return $this->createUser('admin', array_merge([
            'name' => 'Admin Testing',
            'email' => 'admin.testing.' . uniqid() . '@sipesan.test',
            'nim' => null,
        ], $overrides));
    }

    protected function createStudentUser(array $overrides = []): array
    {
        $prodi = $this->createProdi();

        $user = $this->createUser('mahasiswa', array_merge([
            'name' => 'Mahasiswa Testing',
            'email' => 'mahasiswa.testing.' . uniqid() . '@sipesan.test',
            'nim' => '2310817' . random_int(100, 999),
        ], $overrides));

        $mahasiswa = Mahasiswa::create([
            'user_id' => $user->id,
            'prodi_id' => $prodi->id,
            'angkatan' => 2023,
            'no_hp' => '081234567890',
        ]);

        return [$user, $mahasiswa];
    }

    protected function createUser(string $role, array $overrides = []): User
    {
        $data = array_merge([
            'name' => ucfirst($role) . ' Testing',
            'email' => $role . '.testing.' . uniqid() . '@sipesan.test',
            'nim' => $role === 'mahasiswa' ? '2310817' . random_int(100, 999) : null,
            'password' => Hash::make('password'),
            'role' => $role,
        ], $overrides);

        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = $data['status'] ?? 'aktif';
        }

        return User::create($data);
    }

    protected function createProdi(array $overrides = []): Prodi
{
    $data = array_merge([
        'nama_prodi' => 'Teknologi Informasi',
    ], $overrides);

    if (Schema::hasColumn('prodi', 'kode_prodi')) {
        $data['kode_prodi'] = $data['kode_prodi'] ?? 'TI';
    }

    if (Schema::hasColumn('prodi', 'jenjang')) {
        $data['jenjang'] = $data['jenjang'] ?? 'S1';
    }

    if (Schema::hasColumn('prodi', 'fakultas')) {
        $data['fakultas'] = $data['fakultas'] ?? 'Fakultas Teknik';
    }

    if (Schema::hasColumn('prodi', 'kode_prodi')) {
        return Prodi::firstOrCreate(
            ['kode_prodi' => $data['kode_prodi']],
            $data
        );
    }

    return Prodi::firstOrCreate(
        ['nama_prodi' => $data['nama_prodi']],
        $data
    );
}

    protected function createJenisSuratWithDokumen(int $jumlahDokumen = 2): array
    {
        $jenisSurat = JenisSurat::create([
            'nama_surat' => 'Surat Keterangan Testing ' . uniqid(),
            'deskripsi' => 'Jenis surat untuk kebutuhan automated test.',
            'template_isi' => 'Template isi surat untuk kebutuhan automated test.',
        ]);

        $dokumens = collect();

        for ($i = 1; $i <= $jumlahDokumen; $i++) {
            $dokumen = $this->createDokumenSyarat([
                'nama_dokumen' => 'Dokumen Testing ' . $i . ' ' . uniqid(),
            ]);

            $dokumens->push($dokumen);
        }

        $jenisSurat->dokumenSyarat()->sync($dokumens->pluck('id')->toArray());

        return [$jenisSurat->fresh('dokumenSyarat'), $dokumens];
    }

    protected function createDokumenSyarat(array $overrides = []): DokumenSyarat
    {
        $data = array_merge([
            'nama_dokumen' => 'Kartu Tanda Mahasiswa ' . uniqid(),
            'keterangan' => 'Dokumen syarat untuk kebutuhan automated test.',
            'allowed_formats' => 'pdf,jpg,png',
            'max_size' => 5,
        ], $overrides);

        if (Schema::hasColumn('dokumen_syarat', 'is_wajib')) {
            $data['is_wajib'] = $data['is_wajib'] ?? true;
        }

        if (Schema::hasColumn('dokumen_syarat', 'berlaku_untuk')) {
            $data['berlaku_untuk'] = $data['berlaku_untuk'] ?? 'Semua Mahasiswa';
        }

        if (Schema::hasColumn('dokumen_syarat', 'urutan')) {
            $data['urutan'] = $data['urutan'] ?? 1;
        }

        return DokumenSyarat::create($data);
    }

    protected function validPengajuanPayload(JenisSurat $jenisSurat): array
    {
        $payload = [
            'alamat_lengkap' => 'Jl. Automated Test No. 1, Banjarmasin',
            'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
            'semester' => 'Ganjil',
            'jenis_surat_id' => $jenisSurat->id,
            'keperluan' => 'Digunakan untuk menguji flow utama SiPesan secara otomatis.',
            'berkas' => [],
        ];

        foreach ($jenisSurat->dokumenSyarat as $dokumen) {
            $payload['berkas'][$dokumen->id] = UploadedFile::fake()
                ->create('dokumen-' . $dokumen->id . '.pdf', 200, 'application/pdf');
        }

        return $payload;
    }

    protected function createPengajuanFor(
        Mahasiswa $mahasiswa,
        JenisSurat $jenisSurat,
        string $status = 'menunggu',
        bool $withFinalLetter = false
    ): Pengajuan {
        $data = [
            'mahasiswa_id' => $mahasiswa->id,
            'jenis_surat_id' => $jenisSurat->id,
            'keperluan' => 'Pengajuan otomatis untuk automated test.',
            'status' => $status,
            'tgl_ajuan' => now()->toDateString(),
        ];

        if (Schema::hasColumn('pengajuan', 'tgl_proses')) {
            $data['tgl_proses'] = $status === 'menunggu' ? null : now()->toDateString();
        }

        if (Schema::hasColumn('pengajuan', 'catatan_admin')) {
            $data['catatan_admin'] = $status === 'ditolak'
                ? 'Pengajuan ditolak untuk kebutuhan automated test.'
                : null;
        }

        if (Schema::hasColumn('pengajuan', 'file_surat')) {
            $data['file_surat'] = null;
        }

        if (Schema::hasColumn('pengajuan', 'data_tambahan')) {
            $data['data_tambahan'] = [
                'alamat_lengkap' => 'Jl. Automated Test No. 1',
                'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
                'semester' => 'Ganjil',
            ];
        }

        $pengajuan = Pengajuan::create($data);

        foreach ($jenisSurat->dokumenSyarat as $dokumen) {
            $path = 'berkas-pengajuan/' . $pengajuan->id . '/dokumen-' . $dokumen->id . '.pdf';

            Storage::disk('public')->put($path, "%PDF-1.4\nDummy dokumen pemohon\n");

            PengajuanDokumen::create([
                'pengajuan_id' => $pengajuan->id,
                'dokumen_syarat_id' => $dokumen->id,
                'file_path' => $path,
                'original_name' => 'dokumen-' . $dokumen->id . '.pdf',
                'mime_type' => 'application/pdf',
                'file_size' => Storage::disk('public')->size($path),
            ]);
        }

        if ($withFinalLetter && Schema::hasColumn('pengajuan', 'file_surat')) {
            $finalPath = 'surat-final/surat-final-' . $pengajuan->id . '.pdf';

            Storage::disk('public')->put($finalPath, "%PDF-1.4\nDummy surat final\n");

            $pengajuan->update([
                'status' => 'selesai',
                'file_surat' => $finalPath,
                'catatan_admin' => 'Surat sudah selesai.',
            ]);
        }

        return $pengajuan->fresh(['dokumen', 'jenisSurat', 'mahasiswa.user']);
    }
}