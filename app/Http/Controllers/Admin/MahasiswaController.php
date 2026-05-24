<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['user', 'prodi']);

        // Filter prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Search nama / NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $mahasiswa = $query->latest()->paginate(10)->withQueryString();

        // Data untuk dropdown filter
        $prodis = Prodi::orderBy('nama_prodi')->get();
        $angkatans = Mahasiswa::select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        $totalMahasiswa = Mahasiswa::count();

        return view('admin.mahasiswa.index', compact(
            'mahasiswa',
            'prodis',
            'angkatans',
            'totalMahasiswa'
        ));
    }
}
