<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PengajuanDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengajuanController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');

        $pengajuan = Pengajuan::with([
                'mahasiswa.user',
                'mahasiswa.prodi',
                'jenisSurat',
                'dokumen.dokumenSyarat',
            ])
            ->when($status && $status !== 'semua', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuan', 'status'));
    }

    public function update(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
            'file_surat' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status pengajuan tidak valid.',
            'catatan_admin.max' => 'Catatan maksimal 2000 karakter.',
            'file_surat.file' => 'Dokumen balasan harus berupa file.',
            'file_surat.mimes' => 'Dokumen balasan harus berupa PDF.',
            'file_surat.max' => 'Dokumen balasan maksimal 5MB.',
        ]);

        if ($validated['status'] === 'ditolak' && blank($validated['catatan_admin'] ?? null)) {
            return back()
                ->withErrors(['catatan_admin' => 'Catatan wajib diisi jika pengajuan ditolak.'])
                ->withInput();
        }

        if ($request->hasFile('file_surat') && $validated['status'] !== 'selesai') {
            return back()
                ->withErrors(['file_surat' => 'Jika mengunggah dokumen balasan, status pengajuan harus diubah menjadi selesai.'])
                ->withInput();
        }

        if ($validated['status'] === 'selesai' && ! $request->hasFile('file_surat') && ! $pengajuan->file_surat) {
            return back()
                ->withErrors(['file_surat' => 'Dokumen balasan wajib diunggah jika status pengajuan selesai.'])
                ->withInput();
        }

        $data = [
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ];

        if (in_array($validated['status'], ['diproses', 'selesai', 'ditolak'], true)) {
            $data['tgl_proses'] = $pengajuan->tgl_proses ?? now();
        }

        if ($request->hasFile('file_surat')) {
            if ($pengajuan->file_surat && Storage::disk('public')->exists($pengajuan->file_surat)) {
                Storage::disk('public')->delete($pengajuan->file_surat);
            }

            $data['file_surat'] = $request->file('file_surat')->store('surat-final', 'public');
        }

        $pengajuan->update($data);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Perubahan pengajuan berhasil disimpan.');
    }

    public function lihatDokumen(PengajuanDokumen $dokumen): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($dokumen->file_path), 404);

        return Storage::disk('public')->response(
            $dokumen->file_path,
            $dokumen->original_name
        );
    }

    public function downloadDokumen(PengajuanDokumen $dokumen): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($dokumen->file_path), 404);

        return Storage::disk('public')->download(
            $dokumen->file_path,
            $dokumen->original_name
        );
    }

    public function hapusSurat(Pengajuan $pengajuan): RedirectResponse{
        if (! $pengajuan->file_surat) {
            return back()->with('error', 'Surat balasan belum tersedia.');
        }

        if (Storage::disk('public')->exists($pengajuan->file_surat)) {
            Storage::disk('public')->delete($pengajuan->file_surat);
        }

        $data = [
            'file_surat' => null,
        ];

        if ($pengajuan->status === 'selesai') {
            $data['status'] = 'diproses';
        }

        $pengajuan->update($data);

        return redirect()
            ->route('admin.pengajuan.index')
            ->with('success', 'Surat balasan berhasil dihapus.');
}
    public function lihatSurat(Pengajuan $pengajuan): StreamedResponse
    {
        abort_unless($pengajuan->file_surat, 404);
        abort_unless(Storage::disk('public')->exists($pengajuan->file_surat), 404);

        return Storage::disk('public')->response(
            $pengajuan->file_surat,
            'surat-final-' . str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) . '.pdf'
        );
    }

    public function downloadSurat(Pengajuan $pengajuan): StreamedResponse
    {
        abort_unless($pengajuan->file_surat, 404);
        abort_unless(Storage::disk('public')->exists($pengajuan->file_surat), 404);

        return Storage::disk('public')->download(
            $pengajuan->file_surat,
            'surat-final-' . str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) . '.pdf'
        );
    }
}