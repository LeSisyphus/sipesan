<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\Mahasiswa\RiwayatController as MahasiswaRiwayatController;

use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\DokumenSyaratController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\PengajuanController;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuanController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::resource('/jenis-surat', JenisSuratController::class);

        Route::post('/dokumen-syarat/hubungkan', [DokumenSyaratController::class, 'hubungkan'])
            ->name('dokumen-syarat.hubungkan');
        Route::post('/dokumen-syarat/putuskan', [DokumenSyaratController::class, 'putuskan'])
            ->name('dokumen-syarat.putuskan');

        Route::resource('/dokumen-syarat', DokumenSyaratController::class);

        Route::resource('/prodi', ProdiController::class);

        Route::get('/pengajuan', [PengajuanController::class, 'index'])
            ->name('pengajuan.index');

        Route::patch('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])
            ->name('pengajuan.update');

        Route::get('/pengajuan/dokumen/{dokumen}/lihat', [PengajuanController::class, 'lihatDokumen'])
            ->name('pengajuan.dokumen.lihat');

        Route::get('/pengajuan/dokumen/{dokumen}/download', [PengajuanController::class, 'downloadDokumen'])
            ->name('pengajuan.dokumen.download');

        Route::get('/pengajuan/{pengajuan}/surat/lihat', [PengajuanController::class, 'lihatSurat'])
            ->name('pengajuan.surat.lihat');

        Route::get('/pengajuan/{pengajuan}/surat/download', [PengajuanController::class, 'downloadSurat'])
            ->name('pengajuan.surat.download');
        
        Route::delete('/pengajuan/{pengajuan}/surat', [PengajuanController::class, 'hapusSurat'])
            ->name('pengajuan.surat.hapus');

        Route::view('/mahasiswa', 'admin.dashboard')
            ->name('mahasiswa.index');
        
        Route::get('/akun-mahasiswa', [\App\Http\Controllers\Admin\MahasiswaController::class, 'index'])
            ->name('akun-mahasiswa.index');

        Route::patch('/akun-mahasiswa/{id}/reset-password', [\App\Http\Controllers\Admin\MahasiswaController::class, 'resetPassword'])
            ->name('akun-mahasiswa.reset-password');

        Route::patch('/akun-mahasiswa/{id}/toggle-status', [\App\Http\Controllers\Admin\MahasiswaController::class, 'toggleStatus'])
            ->name('akun-mahasiswa.toggle-status');
        
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])
            ->name('laporan.index');
    });

Route::middleware(['auth', 'mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])
            ->name('dashboard');

        Route::get('/pengajuan', [MahasiswaPengajuanController::class, 'create'])
            ->name('pengajuan');

        Route::get('/pengajuan/create', [MahasiswaPengajuanController::class, 'create'])
            ->name('pengajuan.create');

        Route::post('/pengajuan', [MahasiswaPengajuanController::class, 'store'])
            ->name('pengajuan.store');

        Route::get('/pengajuan/{pengajuan}/success', [MahasiswaPengajuanController::class, 'success'])
            ->name('pengajuan.success');

        Route::get('/pengajuan/{pengajuan}/surat/lihat', [MahasiswaPengajuanController::class, 'lihatSurat'])
            ->name('pengajuan.surat.lihat');

        Route::get('/pengajuan/{pengajuan}/surat/download', [MahasiswaPengajuanController::class, 'downloadSurat'])
            ->name('pengajuan.surat.download');

        Route::get('/riwayat', [MahasiswaRiwayatController::class, 'index'])
            ->name('riwayat');

        Route::get('/profile', [MahasiswaProfileController::class, 'index'])
            ->name('profile');

        Route::patch('/profile', [MahasiswaProfileController::class, 'update'])
            ->name('profile.update');

        Route::patch('/profile/password', [MahasiswaProfileController::class, 'updatePassword'])
            ->name('profile.password.update');
    });
