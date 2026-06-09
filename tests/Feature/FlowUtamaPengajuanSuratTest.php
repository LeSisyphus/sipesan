<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Concerns\CreatesSiPesanTestData;
use Tests\TestCase;

class FlowUtamaPengajuanSuratTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSiPesanTestData;

    public function test_flow_utama_pengajuan_surat_berjalan_sampai_selesai(): void
    {
        Storage::fake('public');

        [$mahasiswaUser, $mahasiswa] = $this->createStudentUser();
        $adminUser = $this->createAdminUser();

        [$jenisSurat] = $this->createJenisSuratWithDokumen(2);

        $this->actingAs($mahasiswaUser);

        $response = $this->post(
            route('mahasiswa.pengajuan.store'),
            $this->validPengajuanPayload($jenisSurat)
        );

        $response->assertRedirect();

        $pengajuan = Pengajuan::with(['dokumen', 'jenisSurat', 'mahasiswa.user'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        $this->assertNotNull($pengajuan);
        $this->assertEquals('menunggu', $pengajuan->status);
        $this->assertEquals($jenisSurat->id, $pengajuan->jenis_surat_id);
        $this->assertCount(2, $pengajuan->dokumen);

        foreach ($pengajuan->dokumen as $dokumen) {
            Storage::disk('public')->assertExists($dokumen->file_path);
        }

        $this->actingAs($adminUser);

        $response = $this->patch(route('admin.pengajuan.update', $pengajuan), [
            'status' => 'selesai',
            'catatan_admin' => 'Surat sudah selesai diproses melalui automated test.',
            'file_surat' => UploadedFile::fake()->create('surat-final.pdf', 300, 'application/pdf'),
        ]);

        $response->assertRedirect();

        $pengajuan->refresh();

        $this->assertEquals('selesai', $pengajuan->status);
        $this->assertNotNull($pengajuan->file_surat);
        Storage::disk('public')->assertExists($pengajuan->file_surat);

        $this->actingAs($mahasiswaUser);

        $this->get(route('mahasiswa.riwayat'))
            ->assertOk()
            ->assertSee('Selesai', false);

        $this->get(route('mahasiswa.pengajuan.surat.download', $pengajuan))
            ->assertOk();
    }
}