<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengajuan  = Pengajuan::count();
        $menunggu        = Pengajuan::where('status', 'menunggu')->count();
        $diproses        = Pengajuan::where('status', 'diproses')->count();
        $selesai         = Pengajuan::where('status', 'selesai')->count();
        $totalMahasiswa  = Mahasiswa::count();

        return view('admin.dashboard', compact(
            'totalPengajuan',
            'menunggu',
            'diproses',
            'selesai',
            'totalMahasiswa'
        ));
    }
}