<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa()->with('prodi')->first();

        $baseQuery = Pengajuan::query();

        if ($mahasiswa) {
            $baseQuery->where('mahasiswa_id', $mahasiswa->id);
        } else {
            $baseQuery->whereRaw('1 = 0');
        }

        $totalPengajuan = (clone $baseQuery)->count();
        $menunggu = (clone $baseQuery)->where('status', 'menunggu')->count();
        $diproses = (clone $baseQuery)->where('status', 'diproses')->count();
        $selesai = (clone $baseQuery)->where('status', 'selesai')->count();
        $ditolak = (clone $baseQuery)->where('status', 'ditolak')->count();

        $aktivitasTerbaru = (clone $baseQuery)
            ->with('jenisSurat')
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'user',
            'mahasiswa',
            'totalPengajuan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak',
            'aktivitasTerbaru'
        ));
    }
}
