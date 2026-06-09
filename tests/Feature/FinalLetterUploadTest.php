<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\CreatesSiPesanTestData;
use Tests\TestCase;

class FinalLetterUploadTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSiPesanTestData;

    public function test_admin_bisa_upload_surat_final_pdf_dan_mahasiswa_bisa_download(): void
    {
        Storage::fake('public');

        $admin = $this->createAdminUser();
        [$mahasiswaUser, $mahasiswa] = $this->createStudentUser();
        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $pengajuan = $this->createPengajuanFor($mahasiswa, $jenisSurat, 'diproses');

        $response = $this->actingAs($admin)
            ->patch(route('admin.pengajuan.update', $pengajuan), [
                'status' => 'selesai',
                'catatan_admin' => 'Surat final sudah selesai.',
                'file_surat' => UploadedFile::fake()->create('surat-final.pdf', 200, 'application/pdf'),
            ]);

        $response->assertRedirect();

        $pengajuan->refresh();

        $this->assertEquals('selesai', $pengajuan->status);
        $this->assertNotNull($pengajuan->file_surat);

        Storage::disk('public')->assertExists($pengajuan->file_surat);

        $this->actingAs($mahasiswaUser)
            ->get(route('mahasiswa.pengajuan.surat.download', $pengajuan))
            ->assertOk();
    }

    public function test_mahasiswa_lain_tidak_bisa_download_surat_final_milik_orang_lain(): void
    {
        Storage::fake('public');

        [, $pemilikMahasiswa] = $this->createStudentUser();
        [$mahasiswaLainUser] = $this->createStudentUser();

        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $pengajuan = $this->createPengajuanFor(
            $pemilikMahasiswa,
            $jenisSurat,
            'selesai',
            true
        );

        $this->actingAs($mahasiswaLainUser)
            ->get(route('mahasiswa.pengajuan.surat.download', $pengajuan))
            ->assertForbidden();
    }

    public function test_admin_tidak_bisa_upload_surat_final_non_pdf(): void
    {
        Storage::fake('public');

        $admin = $this->createAdminUser();
        [, $mahasiswa] = $this->createStudentUser();
        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $pengajuan = $this->createPengajuanFor($mahasiswa, $jenisSurat, 'diproses');

        $response = $this->actingAs($admin)
            ->from(route('admin.pengajuan.index'))
            ->patch(route('admin.pengajuan.update', $pengajuan), [
                'status' => 'selesai',
                'catatan_admin' => 'Testing upload file salah.',
                'file_surat' => UploadedFile::fake()->create('surat-final.txt', 10, 'text/plain'),
            ]);

        $response->assertRedirect(route('admin.pengajuan.index'));
        $response->assertSessionHasErrors('file_surat');

        $pengajuan->refresh();

        $this->assertNotEquals('selesai', $pengajuan->status);
        $this->assertNull($pengajuan->file_surat);
    }
}