<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    public function index(): View
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $pengajuan = collect();

        if ($mahasiswa) {
            $pengajuan = Pengajuan::with([
                    'jenisSurat',
                    'dokumen.dokumenSyarat',
                ])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->latest('created_at')
                ->get();
        }

        $riwayatItems = $pengajuan->map(function (Pengajuan $item) {
            $tanggalAjuan = $item->tgl_ajuan ?: $item->created_at;
            $tanggalProses = $item->tgl_proses ?: $item->updated_at;

            $hasFinalFile = filled($item->file_surat)
                && Storage::disk('public')->exists($item->file_surat);

            $timeline = [
                [
                    'title' => 'Pengajuan Dikirim',
                    'description' => 'Pengajuan berhasil masuk ke sistem.',
                    'date' => optional($tanggalAjuan)->translatedFormat('d M Y'),
                    'icon' => 'upload_file',
                    'tone' => 'primary',
                ],
            ];

            if (in_array($item->status, ['diproses', 'selesai', 'ditolak'], true)) {
                $timeline[] = [
                    'title' => $item->status === 'ditolak' ? 'Pengajuan Ditolak' : 'Diverifikasi Admin',
                    'description' => $item->status === 'ditolak'
                        ? ($item->catatan_admin ?: 'Pengajuan ditolak oleh admin.')
                        : 'Pengajuan sedang diproses oleh admin.',
                    'date' => optional($tanggalProses)->translatedFormat('d M Y'),
                    'icon' => $item->status === 'ditolak' ? 'cancel' : 'verified_user',
                    'tone' => $item->status === 'ditolak' ? 'danger' : 'violet',
                ];
            }

            if ($item->status === 'selesai') {
                $timeline[] = [
                    'title' => 'Selesai',
                    'description' => 'Dokumen dari admin siap dilihat atau diunduh.',
                    'date' => optional($tanggalProses)->translatedFormat('d M Y'),
                    'icon' => 'check',
                    'tone' => 'success',
                ];
            }

            return [
                'id' => $item->id,
                'code' => 'REQ-' . str_pad((string) $item->id, 4, '0', STR_PAD_LEFT),
                'title' => $item->jenisSurat?->nama_surat ?? 'Jenis Surat Tidak Ditemukan',
                'status' => $item->status,
                'status_label' => $this->statusLabel($item->status),
                'date' => optional($tanggalAjuan)->translatedFormat('d M Y'),
                'time' => optional($item->created_at)->translatedFormat('H:i') . ' WIB',
                'note' => $item->catatan_admin ?: $this->defaultNote($item->status),
                'keperluan' => $item->keperluan,
                'icon' => $this->statusIcon($item->status),
                'has_final_file' => $hasFinalFile,
                'lihat_url' => $hasFinalFile ? route('mahasiswa.pengajuan.surat.lihat', $item) : null,
                'download_url' => $hasFinalFile ? route('mahasiswa.pengajuan.surat.download', $item) : null,
                'file_name' => $hasFinalFile ? 'surat-final-' . str_pad((string) $item->id, 4, '0', STR_PAD_LEFT) . '.pdf' : null,
                'dokumen' => $item->dokumen->map(function ($dokumen) {
                    return [
                        'nama' => $dokumen->dokumenSyarat?->nama_dokumen ?? $dokumen->original_name,
                        'file' => $dokumen->original_name,
                    ];
                })->values(),
                'timeline' => $timeline,
            ];
        })->values();

        $totalPengajuan = $riwayatItems->count();
        $menunggu = $riwayatItems->where('status', 'menunggu')->count();
        $diproses = $riwayatItems->where('status', 'diproses')->count();
        $selesai = $riwayatItems->where('status', 'selesai')->count();
        $ditolak = $riwayatItems->where('status', 'ditolak')->count();

        return view('mahasiswa.riwayat.index', compact(
            'riwayatItems',
            'totalPengajuan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak'
        ));
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($status),
        };
    }

    private function statusIcon(string $status): string
    {
        return match ($status) {
            'selesai' => 'mark_email_read',
            'diproses' => 'pending_actions',
            'ditolak' => 'cancel',
            default => 'hourglass_empty',
        };
    }

    private function defaultNote(string $status): string
    {
        return match ($status) {
            'menunggu' => 'Pengajuan menunggu verifikasi admin.',
            'diproses' => 'Pengajuan sedang diproses oleh admin.',
            'selesai' => 'Surat sudah selesai dan dapat diunduh jika file tersedia.',
            'ditolak' => 'Pengajuan ditolak. Silakan cek catatan admin.',
            default => '-',
        };
    }
}
