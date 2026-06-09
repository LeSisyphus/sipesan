<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalJenisSurat = JenisSurat::count();
        $totalPengajuan = Pengajuan::count();

        $menunggu = Pengajuan::where('status', 'menunggu')->count();
        $diproses = Pengajuan::where('status', 'diproses')->count();
        $selesai = Pengajuan::where('status', 'selesai')->count();
        $ditolak = Pengajuan::where('status', 'ditolak')->count();

        $pengajuanTerbaru = Pengajuan::with([
                'mahasiswa.user',
                'jenisSurat',
            ])
            ->orderByDesc('tgl_ajuan')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalJenisSurat',
            'totalPengajuan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak',
            'pengajuanTerbaru'
        ));
    }
}