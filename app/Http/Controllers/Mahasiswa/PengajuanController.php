<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Pengajuan;
use App\Models\PengajuanDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PengajuanController extends Controller
{
    public function create(): View
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa()->with('prodi')->first();

        $jenisSurat = JenisSurat::with(['dokumenSyarat' => function ($query) {
                $query->orderBy('nama_dokumen');
            }])
            ->orderBy('nama_surat')
            ->get();

        return view('mahasiswa.pengajuan.index', compact(
            'user',
            'mahasiswa',
            'jenisSurat'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alamat_lengkap' => ['required', 'string', 'max:1000'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'semester' => ['required', 'in:Ganjil,Genap'],
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'keperluan' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
            'tahun_ajaran.required' => 'Tahun ajaran wajib dipilih.',
            'semester.required' => 'Semester wajib dipilih.',
            'jenis_surat_id.required' => 'Jenis surat wajib dipilih.',
            'jenis_surat_id.exists' => 'Jenis surat tidak valid.',
            'keperluan.required' => 'Keperluan pengajuan wajib diisi.',
            'keperluan.min' => 'Keperluan pengajuan minimal 5 karakter.',
        ]);

        $mahasiswa = $request->user()->mahasiswa;

        if (! $mahasiswa) {
            return back()
                ->withErrors(['mahasiswa' => 'Profil mahasiswa belum lengkap. Silakan hubungi admin.'])
                ->withInput();
        }

        $jenisSurat = JenisSurat::with('dokumenSyarat')
            ->findOrFail($validated['jenis_surat_id']);

        $fileRules = [];
        $fileMessages = [];

        foreach ($jenisSurat->dokumenSyarat as $dokumen) {
            $key = 'berkas.' . $dokumen->id;
            $allowedFormats = $this->normalizeAllowedFormats($dokumen->allowed_formats);
            $maxSizeMb = (int) ($dokumen->max_size ?: 5);
            $maxSizeKb = $maxSizeMb * 1024;
            $formatLabel = $this->formatLabel($allowedFormats);

            $fileRules[$key] = [
                'required',
                'file',
                'mimes:' . implode(',', $allowedFormats),
                'max:' . $maxSizeKb,
            ];

            $fileMessages[$key . '.required'] = $dokumen->nama_dokumen . ' wajib diunggah.';
            $fileMessages[$key . '.file'] = $dokumen->nama_dokumen . ' harus berupa file yang valid.';
            $fileMessages[$key . '.mimes'] = $dokumen->nama_dokumen . ' harus berformat ' . $formatLabel . '.';
            $fileMessages[$key . '.max'] = $dokumen->nama_dokumen . ' maksimal berukuran ' . $maxSizeMb . ' MB.';
        }

        if ($fileRules !== []) {
            $request->validate($fileRules, $fileMessages);
        }

        $pengajuan = DB::transaction(function () use ($request, $validated, $mahasiswa, $jenisSurat) {
            $pengajuan = Pengajuan::create([
                'mahasiswa_id' => $mahasiswa->id,
                'jenis_surat_id' => $validated['jenis_surat_id'],
                'keperluan' => $validated['keperluan'],
                'status' => 'menunggu',
                'tgl_ajuan' => now()->toDateString(),
                'tgl_proses' => null,
                'catatan_admin' => null,
                'file_surat' => null,
                'data_tambahan' => [
                    'alamat_lengkap' => $validated['alamat_lengkap'],
                    'tahun_ajaran' => $validated['tahun_ajaran'],
                    'semester' => $validated['semester'],
                ],
            ]);

            foreach ($jenisSurat->dokumenSyarat as $dokumen) {
                $file = $request->file('berkas.' . $dokumen->id);

                if (! $file) {
                    continue;
                }

                $path = $file->store(
                    'berkas-pengajuan/' . $pengajuan->id,
                    'public'
                );

                PengajuanDokumen::create([
                    'pengajuan_id' => $pengajuan->id,
                    'dokumen_syarat_id' => $dokumen->id,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }

            return $pengajuan;
        });

        return redirect()
            ->route('mahasiswa.pengajuan.success', $pengajuan)
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function success(Pengajuan $pengajuan): View
    {
        $this->authorizeOwner($pengajuan);

        $pengajuan->load('jenisSurat');

        return view('mahasiswa.pengajuan.success', compact('pengajuan'));
    }

    public function lihatSurat(Pengajuan $pengajuan): StreamedResponse
    {
        $this->authorizeOwner($pengajuan);

        abort_unless($pengajuan->file_surat, 404);
        abort_unless(Storage::disk('public')->exists($pengajuan->file_surat), 404);

        return Storage::disk('public')->response(
            $pengajuan->file_surat,
            'surat-final-' . str_pad((string) $pengajuan->id, 4, '0', STR_PAD_LEFT) . '.pdf'
        );
    }

    public function downloadSurat(Pengajuan $pengajuan): StreamedResponse
    {
        $this->authorizeOwner($pengajuan);

        abort_unless($pengajuan->file_surat, 404);
        abort_unless(Storage::disk('public')->exists($pengajuan->file_surat), 404);

        return Storage::disk('public')->download(
            $pengajuan->file_surat,
            'surat-final-' . str_pad((string) $pengajuan->id, 4, '0', STR_PAD_LEFT) . '.pdf'
        );
    }

    private function authorizeOwner(Pengajuan $pengajuan): void
    {
        $mahasiswa = request()->user()->mahasiswa;

        abort_if(! $mahasiswa || $pengajuan->mahasiswa_id !== $mahasiswa->id, 403);
    }

    private function normalizeAllowedFormats(?string $allowedFormats): array
    {
        $formats = collect(explode(',', $allowedFormats ?: 'pdf,jpg,jpeg,png'))
            ->map(fn ($format) => strtolower(trim(str_replace('.', '', $format))))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $formats === [] ? ['pdf', 'jpg', 'jpeg', 'png'] : $formats;
    }

    private function formatLabel(array $formats): string
    {
        return collect($formats)
            ->map(fn ($format) => strtoupper($format))
            ->implode(', ');
    }
}
