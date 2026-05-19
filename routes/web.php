<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;

use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\DokumenSyaratController;
use App\Http\Controllers\Admin\ProdiController;

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

        Route::view('/pengajuan', 'admin.pengajuan.index')
            ->name('pengajuan.index');

        Route::view('/mahasiswa', 'admin.dashboard')
            ->name('mahasiswa.index');
        
        Route::view('/akun-mahasiswa', 'admin.akun-mahasiswa.index')
            ->name('akun-mahasiswa.index');
        
        Route::view('/laporan', 'admin.laporan.index')
            ->name('laporan.index');
    });

Route::middleware(['auth', 'mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])
            ->name('dashboard');
    });