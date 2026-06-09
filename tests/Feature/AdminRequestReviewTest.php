<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\CreatesSiPesanTestData;
use Tests\TestCase;

class AdminRequestReviewTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSiPesanTestData;

    public function test_admin_bisa_melihat_daftar_pengajuan_masuk(): void
    {
        Storage::fake('public');

        $admin = $this->createAdminUser();
        [, $mahasiswa] = $this->createStudentUser();
        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $pengajuan = $this->createPengajuanFor($mahasiswa, $jenisSurat, 'menunggu');

        $this->actingAs($admin)
            ->get(route('admin.pengajuan.index'))
            ->assertOk()
            ->assertSee('REQ-' . str_pad((string) $pengajuan->id, 4, '0', STR_PAD_LEFT), false)
            ->assertSee($jenisSurat->nama_surat, false);
    }

    public function test_admin_bisa_mengubah_status_pengajuan_menjadi_diproses(): void
    {
        Storage::fake('public');

        $admin = $this->createAdminUser();
        [, $mahasiswa] = $this->createStudentUser();
        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $pengajuan = $this->createPengajuanFor($mahasiswa, $jenisSurat, 'menunggu');

        $response = $this->actingAs($admin)
            ->patch(route('admin.pengajuan.update', $pengajuan), [
                'status' => 'diproses',
                'catatan_admin' => 'Pengajuan sedang diproses oleh admin.',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status' => 'diproses',
            'catatan_admin' => 'Pengajuan sedang diproses oleh admin.',
        ]);
    }

    public function test_admin_bisa_download_dokumen_yang_diupload_mahasiswa(): void
    {
        Storage::fake('public');

        $admin = $this->createAdminUser();
        [, $mahasiswa] = $this->createStudentUser();
        [$jenisSurat] = $this->createJenisSuratWithDokumen(1);

        $pengajuan = $this->createPengajuanFor($mahasiswa, $jenisSurat, 'menunggu');
        $dokumen = $pengajuan->dokumen->first();

        $this->actingAs($admin)
            ->get(route('admin.pengajuan.dokumen.download', $dokumen))
            ->assertOk();
    }

    public function test_mahasiswa_tidak_bisa_mengakses_halaman_pengajuan_admin(): void
    {
        [$mahasiswaUser] = $this->createStudentUser();

        $response = $this->actingAs($mahasiswaUser)
            ->get(route('admin.pengajuan.index'));

        $this->assertContains($response->getStatusCode(), [302, 403]);
    }
}