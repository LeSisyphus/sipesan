<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $pengajuan = Pengajuan::with([
                'mahasiswa.user',
                'mahasiswa.prodi',
                'jenisSurat',
            ])
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuan', 'status'));
    }
}