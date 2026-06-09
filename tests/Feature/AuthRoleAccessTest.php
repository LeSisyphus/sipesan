<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\CreatesSiPesanTestData;
use Tests\TestCase;

class AuthRoleAccessTest extends TestCase
{
    use RefreshDatabase;
    use CreatesSiPesanTestData;

    public function test_admin_login_diarahkan_ke_dashboard_admin(): void
    {
        $admin = $this->createAdminUser([
            'email' => 'admin@sipesan.test',
        ]);

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_mahasiswa_login_diarahkan_ke_dashboard_mahasiswa(): void
    {
        [$mahasiswaUser] = $this->createStudentUser([
            'email' => 'mahasiswa@sipesan.test',
        ]);

        $response = $this->post(route('login'), [
            'email' => $mahasiswaUser->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('mahasiswa.dashboard'));
    }

    public function test_mahasiswa_tidak_bisa_mengakses_dashboard_admin(): void
    {
        [$mahasiswaUser] = $this->createStudentUser();

        $response = $this->actingAs($mahasiswaUser)
            ->get(route('admin.dashboard'));

        $this->assertContains($response->getStatusCode(), [302, 403]);
    }

    public function test_register_publik_selalu_membuat_akun_mahasiswa(): void
    {
        $prodi = $this->createProdi();

        $response = $this->post(route('register'), [
            'name' => 'User Register Test',
            'nim' => '2310817999',
            'email' => 'register.test@sipesan.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'prodi_id' => $prodi->id,
            'angkatan' => 2023,
            'no_hp' => '081234567890',

            // Ini sengaja dikirim untuk memastikan backend mengabaikan role dari request.
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('mahasiswa.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'register.test@sipesan.test',
            'role' => 'mahasiswa',
        ]);
    }
}