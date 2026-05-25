<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;

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

        Route::resource('/dokumen-syarat', DokumenSyaratController::class);

        Route::resource('/prodi', ProdiController::class);

        /*
        |--------------------------------------------------------------------------
        | Temporary Dummy Routes
        |--------------------------------------------------------------------------
        */

        Route::get('/pengajuan', [PengajuanController::class, 'index'])
            ->name('pengajuan.index');

        Route::patch('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])
            ->name('pengajuan.update');

        Route::get('/pengajuan/dokumen/{dokumen}/lihat', [PengajuanController::class, 'lihatDokumen'])
            ->name('pengajuan.dokumen.lihat');

        Route::get('/pengajuan/dokumen/{dokumen}/download', [PengajuanController::class, 'downloadDokumen'])
            ->name('pengajuan.dokumen.download');


        Route::view('/mahasiswa', 'admin.dashboard')
            ->name('mahasiswa.index');
        
        Route::get('/akun-mahasiswa', [\App\Http\Controllers\Admin\MahasiswaController::class, 'index'])
            ->name('akun-mahasiswa.index');
        Route::patch('/akun-mahasiswa/{id}/reset-password', [\App\Http\Controllers\Admin\MahasiswaController::class, 'resetPassword'])
            ->name('akun-mahasiswa.reset-password');
        Route::patch('/akun-mahasiswa/{id}/toggle-status', [\App\Http\Controllers\Admin\MahasiswaController::class, 'toggleStatus'])
            ->name('akun-mahasiswa.toggle-status');
        
        Route::view('/laporan', 'admin.laporan.index')
            ->name('laporan.index');
    });

Route::middleware(['auth', 'mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])
            ->name('dashboard');
        Route::get('/pengajuan/create', [MahasiswaPengajuanController::class, 'create'])
            ->name('pengajuan.create');

        Route::post('/pengajuan', [MahasiswaPengajuanController::class, 'store'])
            ->name('pengajuan.store');

        Route::get('/pengajuan/{pengajuan}/success', [MahasiswaPengajuanController::class, 'success'])
            ->name('pengajuan.success');
    });