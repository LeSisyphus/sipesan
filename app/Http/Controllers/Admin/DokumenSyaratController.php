<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenSyarat;
use App\Models\JenisSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DokumenSyaratController extends Controller
{
    public function index(): View
    {
        $jenisSurats = JenisSurat::with(['dokumenSyarat' => function ($query) {
                $query->orderBy('nama_dokumen');
            }])
            ->orderBy('nama_surat')
            ->get();

        $dokumenSyarats = DokumenSyarat::orderBy('nama_dokumen')->get();

        $totalJenisSurat = JenisSurat::count();
        $totalSyarat = DokumenSyarat::count();
        $totalRelasi = $jenisSurats->sum(fn ($jenisSurat) => $jenisSurat->dokumenSyarat->count());

        return view('admin.dokumen-syarat.index', compact(
            'jenisSurats',
            'dokumenSyarats',
            'totalJenisSurat',
            'totalSyarat',
            'totalRelasi'
        ));
    }

    public function create(): View
    {
        return view('admin.dokumen-syarat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'allowed_formats' => ['required', 'array', 'min:1'],
            'allowed_formats.*' => ['string', 'in:pdf,jpg,jpeg,png,docx'],
            'max_size' => ['required', 'integer', 'in:2,5,10,20'],
            'jenis_surat_id' => ['nullable', 'exists:jenis_surat,id'],
        ], [
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'allowed_formats.required' => 'Minimal satu format file harus dipilih.',
            'allowed_formats.*.in' => 'Format file tidak valid.',
            'max_size.required' => 'Ukuran maksimal wajib dipilih.',
            'max_size.in' => 'Ukuran maksimal tidak valid.',
            'jenis_surat_id.exists' => 'Jenis surat tidak valid.',
        ]);

        $allowedFormats = collect($validated['allowed_formats'])
            ->map(fn ($format) => strtolower(trim($format)))
            ->unique()
            ->values()
            ->implode(',');

        $dokumenSyarat = DokumenSyarat::create([
            'nama_dokumen' => $validated['nama_dokumen'],
            'keterangan' => $validated['keterangan'] ?? null,
            'allowed_formats' => $allowedFormats,
            'max_size' => $validated['max_size'],
        ]);

        if ($request->filled('jenis_surat_id')) {
            $dokumenSyarat->jenisSurat()->syncWithoutDetaching([
                $request->integer('jenis_surat_id'),
            ]);
        }

        return redirect()
            ->route('admin.dokumen-syarat.index')
            ->with('success', 'Dokumen syarat master berhasil ditambahkan.');
    }

    public function show($id): View
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);

        return view('admin.dokumen-syarat.show', compact('dokumenSyarat'));
    }

    public function edit($id): View
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);

        return view('admin.dokumen-syarat.edit', compact('dokumenSyarat'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'allowed_formats' => ['required', 'array', 'min:1'],
            'allowed_formats.*' => ['string', 'in:pdf,jpg,jpeg,png,docx'],
            'max_size' => ['required', 'integer', 'in:2,5,10,20'],
        ], [
            'nama_dokumen.required' => 'Nama dokumen wajib diisi.',
            'allowed_formats.required' => 'Minimal satu format file harus dipilih.',
            'allowed_formats.*.in' => 'Format file tidak valid.',
            'max_size.required' => 'Ukuran maksimal wajib dipilih.',
            'max_size.in' => 'Ukuran maksimal tidak valid.',
        ]);

        $allowedFormats = collect($validated['allowed_formats'])
            ->map(fn ($format) => strtolower(trim($format)))
            ->unique()
            ->values()
            ->implode(',');

        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        $dokumenSyarat->update([
            'nama_dokumen' => $validated['nama_dokumen'],
            'keterangan' => $validated['keterangan'] ?? null,
            'allowed_formats' => $allowedFormats,
            'max_size' => $validated['max_size'],
        ]);

        return redirect()
            ->route('admin.dokumen-syarat.index')
            ->with('success', 'Dokumen syarat berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $dokumenSyarat = DokumenSyarat::findOrFail($id);
        $dokumenSyarat->delete();

        return redirect()
            ->route('admin.dokumen-syarat.index')
            ->with('success', 'Dokumen syarat master berhasil dihapus.');
    }

    public function hubungkan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'dokumen_ids' => ['nullable', 'array'],
            'dokumen_ids.*' => ['exists:dokumen_syarat,id'],
        ]);

        $jenisSurat = JenisSurat::findOrFail($validated['jenis_surat_id']);
        $jenisSurat->dokumenSyarat()->sync($validated['dokumen_ids'] ?? []);

        return redirect()
            ->route('admin.dokumen-syarat.index')
            ->with('success', 'Persyaratan dokumen berhasil diperbarui untuk jenis surat ini.');
    }

    public function putuskan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'dokumen_syarat_id' => ['required', 'exists:dokumen_syarat,id'],
        ]);

        $jenisSurat = JenisSurat::findOrFail($validated['jenis_surat_id']);
        $jenisSurat->dokumenSyarat()->detach($validated['dokumen_syarat_id']);

        return redirect()
            ->route('admin.dokumen-syarat.index')
            ->with('success', 'Hubungan dokumen syarat berhasil dilepas.');
    }
}
