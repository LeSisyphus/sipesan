<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenSyarat;

class DokumenSyaratController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokumenSyarat = DokumenSyarat::all();
        return view('admin.dokumen-syarat.index', compact('dokumenSyarat'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dokumen-syarat.create');
    }

    /**
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DokumenSyarat::create($validated);

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat berhasil ditambahkan.');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        return view('admin.dokumen-syarat.show', compact('dokumenSyarat'));
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        return view('admin.dokumen-syarat.edit', compact('dokumenSyarat'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        $dokumenSyarat->update($validated);

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat berhasil diperbarui.');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);

        // Cek apakah dokumen ini masih digunakan oleh jenis surat
        if ($dokumenSyarat->jenisSurat()->count() > 0) {
            return redirect()->route('admin.dokumen-syarat.index')->with('error', 'Gagal dihapus! Dokumen ini masih digunakan oleh jenis surat.');
        }

        $dokumenSyarat->delete();

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat berhasil dihapus.');
    }
}
