<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $totalPengajuan = 0;
        $menunggu       = 0;
        $selesai        = 0;
        $ditolak        = 0;

        if ($mahasiswa) {
            $totalPengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)->count();
            $menunggu       = Pengajuan::where('mahasiswa_id', $mahasiswa->id)->where('status', 'menunggu')->count();
            $selesai        = Pengajuan::where('mahasiswa_id', $mahasiswa->id)->where('status', 'selesai')->count();
            $ditolak        = Pengajuan::where('mahasiswa_id', $mahasiswa->id)->where('status', 'ditolak')->count();
        }

        return view('mahasiswa.dashboard', compact(
            'totalPengajuan',
            'menunggu',
            'selesai',
            'ditolak'
        ));
    }
}