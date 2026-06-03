<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenSyarat;
use App\Models\JenisSurat;

class DokumenSyaratController extends Controller
{
    public function index()
    {
        $jenisSurats = JenisSurat::with('dokumenSyarat')->orderBy('nama_surat')->get();
        $dokumenSyarats = DokumenSyarat::orderBy('nama_dokumen')->get();
        
        $totalJenisSurat = JenisSurat::count();
        $totalSyarat = DokumenSyarat::count();
        $totalWajib = DokumenSyarat::where('is_wajib', true)->count();
        $totalOpsional = DokumenSyarat::where('is_wajib', false)->count();

        return view('admin.dokumen-syarat.index', compact(
            'jenisSurats',
            'dokumenSyarats',
            'totalJenisSurat',
            'totalSyarat',
            'totalWajib',
            'totalOpsional'
        ));
    }

    /**
     * gak kepakai
     */
    public function create()
    {
        return view('admin.dokumen-syarat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'allowed_formats' => 'required|array',
            'allowed_formats.*' => 'string|in:pdf,jpg,png,docx',
            'max_size' => 'required|integer|in:2,5,10,20',
            'is_wajib' => 'required|boolean',
            'berlaku_untuk' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
            'jenis_surat_id' => 'nullable|exists:jenis_surat,id',
        ]);

        $validated['allowed_formats'] = implode(',', $request->allowed_formats);

        $dokumenSyarat = DokumenSyarat::create($validated);
        
        // Hubungkan ke jenis surat terkait jika dikirimkan
        if ($request->filled('jenis_surat_id')) {
            $dokumenSyarat->jenisSurat()->attach($request->jenis_surat_id);
        }

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat master berhasil ditambahkan.');
    }

    /**
     * gak kepakai
     */
    public function show($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        return view('admin.dokumen-syarat.show', compact('dokumenSyarat'));
    }

    /**
     * gak kepakai
     */
    public function edit($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        return view('admin.dokumen-syarat.edit', compact('dokumenSyarat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'allowed_formats' => 'required|array',
            'allowed_formats.*' => 'string|in:pdf,jpg,png,docx',
            'max_size' => 'required|integer|in:2,5,10,20',
            'is_wajib' => 'required|boolean',
            'berlaku_untuk' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
        ]);

        $validated['allowed_formats'] = implode(',', $request->allowed_formats);

        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        $dokumenSyarat->update($validated);

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat berhasil diperbarui.');
    }

    /**
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);

        $dokumenSyarat->delete();

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Dokumen syarat master berhasil dihapus.');
    }

    /**
     * Hubungkan dokumen syarat ke jenis surat (Many-to-Many).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function hubungkan(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'dokumen_ids' => 'nullable|array',
            'dokumen_ids.*' => 'exists:dokumen_syarat,id',
        ]);

        $jenisSurat = JenisSurat::findOrFail($validated['jenis_surat_id']);
        
        // Dapatkan data sinkronisasi relasi pivot
        $jenisSurat->dokumenSyarat()->sync($validated['dokumen_ids'] ?? []);

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Persyaratan dokumen berhasil diperbarui untuk jenis surat ini.');
    }

    /**
     * Lepas hubungan dokumen syarat dari jenis surat (Many-to-Many).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function putuskan(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'dokumen_syarat_id' => 'required|exists:dokumen_syarat,id',
        ]);

        $jenisSurat = JenisSurat::findOrFail($validated['jenis_surat_id']);
        $jenisSurat->dokumenSyarat()->detach($validated['dokumen_syarat_id']);

        return redirect()->route('admin.dokumen-syarat.index')->with('success', 'Hubungan dokumen syarat berhasil dilepas.');
    }
}
