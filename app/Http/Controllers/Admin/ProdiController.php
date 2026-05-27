<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request; 

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::withCount('mahasiswa')->get();
        
        $totalProdi = Prodi::count();
        $totalAktif = Prodi::where('status', 'aktif')->count();
        $totalMahasiswa = \App\Models\Mahasiswa::count();
        $totalAkreditasiA = Prodi::where('akreditasi', 'A')->count();

        return view('admin.prodi.index', compact('prodis', 'totalProdi', 'totalAktif', 'totalMahasiswa', 'totalAkreditasiA'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_prodi'    => 'required|string|max:10|unique:prodi,kode_prodi',
            'nama_prodi'    => 'required|string|max:255',
            'jenjang'       => 'required|in:S1,D3,D4,S2',
            'akreditasi'    => 'required|in:A,B,C',
            'fakultas'      => 'required|string|max:255',
            'ketua_prodi'   => 'nullable|string|max:255',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . date('Y'),
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        Prodi::create($validated); 

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'kode_prodi'    => 'required|string|max:10|unique:prodi,kode_prodi,' . $prodi->id,
            'nama_prodi'    => 'required|string|max:255',
            'jenjang'       => 'required|in:S1,D3,D4,S2',
            'akreditasi'    => 'required|in:A,B,C',
            'fakultas'      => 'required|string|max:255',
            'ketua_prodi'   => 'nullable|string|max:255',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . date('Y'),
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $prodi->update($validated); 

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        // Cek apakah prodi masih ada mahasiswa sebelum dihapus
        if ($prodi->mahasiswa()->count() > 0) {
            return redirect()->route('admin.prodi.index')->with('error', 'Gagal dihapus! Prodi ini masih memiliki data mahasiswa.');
        }

        $prodi->delete();

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}