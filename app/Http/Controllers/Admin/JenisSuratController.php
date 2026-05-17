<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\DokumenSyarat;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurats = JenisSurat::with('dokumenSyarat')->orderBy('nama_surat')->get();
        return view('admin.jenis-surat.index', compact('jenisSurats'));
    }

    public function create()
    {
        $dokumenSyarats = DokumenSyarat::orderBy('nama_dokumen')->get();
        return view('admin.jenis-surat.create', compact('dokumenSyarats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'template_isi' => 'nullable|string',
            'dokumen_syarat_ids' => 'nullable|array',
            'dokumen_syarat_ids.*' => 'exists:dokumen_syarat,id',
        ]);

        $jenisSurat = JenisSurat::create($validated);

        // Sync relasi Many-to-Many ke tabel pivot jenis_surat_syarat
        $jenisSurat->dokumenSyarat()->sync($request->dokumen_syarat_ids ?? []);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisSurat = JenisSurat::with('dokumenSyarat')->findOrFail($id);
        $dokumenSyarats = DokumenSyarat::orderBy('nama_dokumen')->get();

        return view('admin.jenis-surat.edit', compact('jenisSurat', 'dokumenSyarats'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'template_isi' => 'nullable|string',
            'dokumen_syarat_ids' => 'nullable|array',
            'dokumen_syarat_ids.*' => 'exists:dokumen_syarat,id',
        ]);

        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->update($validated);

        // Sync ulang relasi Many-to-Many
        $jenisSurat->dokumenSyarat()->sync($request->dokumen_syarat_ids ?? []);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        // Cek apakah jenis surat ini sudah digunakan di tabel pengajuan
        if ($jenisSurat->pengajuan()->count() > 0) {
            return redirect()->route('admin.jenis-surat.index')->with('error', 'Gagal dihapus! Jenis surat ini masih digunakan oleh data pengajuan.');
        }

        $jenisSurat->delete();

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil dihapus.');
    }
}
