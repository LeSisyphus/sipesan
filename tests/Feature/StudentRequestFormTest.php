<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\CreatesSiPesanTestData;
use Tests\TestCase;

class StudentRequestFormTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSiPesanTestData;

    public function test_mahasiswa_tidak_bisa_submit_tanpa_dokumen_syarat(): void
    {
        Storage::fake('public');

        [$mahasiswaUser] = $this->createStudentUser();
        [$jenisSurat, $dokumens] = $this->createJenisSuratWithDokumen(1);

        $dokumen = $dokumens->first();

        $response = $this->actingAs($mahasiswaUser)
            ->from(route('mahasiswa.pengajuan'))
            ->post(route('mahasiswa.pengajuan.store'), [
                'alamat_lengkap' => 'Jl. Test Validasi No. 1',
                'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
                'semester' => 'Ganjil',
                'jenis_surat_id' => $jenisSurat->id,
                'keperluan' => 'Testing validasi dokumen wajib.',
                'berkas' => [],
            ]);

        $response->assertRedirect(route('mahasiswa.pengajuan'));
        $response->assertSessionHasErrors([
            'berkas.' . $dokumen->id,
        ]);

        $this->assertEquals(0, Pengajuan::count());
    }

    public function test_mahasiswa_tidak_bisa_upload_format_yang_tidak_diizinkan(): void
    {
        Storage::fake('public');

        [$mahasiswaUser] = $this->createStudentUser();

        $jenisSurat = \App\Models\JenisSurat::create([
            'nama_surat' => 'Surat Format Test',
            'deskripsi' => 'Testing format file.',
            'template_isi' => null,
        ]);

        $dokumen = $this->createDokumenSyarat([
            'nama_dokumen' => 'Dokumen PDF Only',
            'allowed_formats' => 'pdf',
            'max_size' => 5,
        ]);

        $jenisSurat->dokumenSyarat()->sync([$dokumen->id]);

        $response = $this->actingAs($mahasiswaUser)
            ->from(route('mahasiswa.pengajuan'))
            ->post(route('mahasiswa.pengajuan.store'), [
                'alamat_lengkap' => 'Jl. Test Format No. 1',
                'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
                'semester' => 'Ganjil',
                'jenis_surat_id' => $jenisSurat->id,
                'keperluan' => 'Testing upload format salah.',
                'berkas' => [
                    $dokumen->id => UploadedFile::fake()->create('dokumen.txt', 10, 'text/plain'),
                ],
            ]);

        $response->assertRedirect(route('mahasiswa.pengajuan'));
        $response->assertSessionHasErrors([
            'berkas.' . $dokumen->id,
        ]);

        $this->assertEquals(0, Pengajuan::count());
    }

    public function test_mahasiswa_tidak_bisa_upload_file_melebihi_max_size(): void
    {
        Storage::fake('public');

        [$mahasiswaUser] = $this->createStudentUser();

        $jenisSurat = \App\Models\JenisSurat::create([
            'nama_surat' => 'Surat Max Size Test',
            'deskripsi' => 'Testing max size.',
            'template_isi' => null,
        ]);

        $dokumen = $this->createDokumenSyarat([
            'nama_dokumen' => 'Dokumen Maksimal 1 MB',
            'allowed_formats' => 'pdf',
            'max_size' => 1,
        ]);

        $jenisSurat->dokumenSyarat()->sync([$dokumen->id]);

        $response = $this->actingAs($mahasiswaUser)
            ->from(route('mahasiswa.pengajuan'))
            ->post(route('mahasiswa.pengajuan.store'), [
                'alamat_lengkap' => 'Jl. Test Size No. 1',
                'tahun_ajaran' => now()->year . '/' . (now()->year + 1),
                'semester' => 'Ganjil',
                'jenis_surat_id' => $jenisSurat->id,
                'keperluan' => 'Testing upload file terlalu besar.',
                'berkas' => [
                    $dokumen->id => UploadedFile::fake()->create('dokumen.pdf', 2048, 'application/pdf'),
                ],
            ]);

        $response->assertRedirect(route('mahasiswa.pengajuan'));
        $response->assertSessionHasErrors([
            'berkas.' . $dokumen->id,
        ]);

        $this->assertEquals(0, Pengajuan::count());
    }
}