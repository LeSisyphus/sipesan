<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Admin\DokumenSyaratController;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('/dokumen-syarat', DokumenSyaratController::class);
});

Route::middleware(['auth', 'mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
});

Route::resource('prodi', ProdiController::class);