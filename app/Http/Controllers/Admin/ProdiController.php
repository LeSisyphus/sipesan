<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request; // <-- TAMBAHAN WAJIB

class ProdiController extends Controller
{
    public function index()
    {
        $prodis = Prodi::all();
        return view('admin.prodi.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

        Prodi::create($validated); // <-- PENGUBAHAN: Gunakan data yang tervalidasi

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        return view('admin.prodi.edit', compact('prodi'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

        $prodi->update($validated); // <-- PENGUBAHAN: Gunakan data yang tervalidasi

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        // <-- PENGUBAHAN: Cek apakah prodi memiliki mahasiswa sebelum dihapus
        if ($prodi->mahasiswa()->count() > 0) {
            return redirect()->route('admin.prodi.index')->with('error', 'Gagal dihapus! Prodi ini masih memiliki data mahasiswa.');
        }

        $prodi->delete();

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}